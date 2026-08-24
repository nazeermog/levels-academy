<?php

namespace DataSource\Http\Controllers\Admin\FreeSession;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendSessionWhatsApp;
use App\Support\SessionMessage;
use DataSource\Entities\User\User;
use DataSource\Entities\Parentt\Parentt;
use DataSource\Entities\Student\Student;
use DataSource\Entities\Classroom\ClassSession;
use DataSource\Entities\FreeSession\FreeSessionRequest;
use DataSource\Entities\FreeSession\InstructorAvailability;

/**
 * Admin management of free-session requests (the waiting list).
 * The admin assigns a pending request to an instructor's available time slot,
 * which creates a free ClassSession and sends the requesting user a WhatsApp
 * message with the date and a calendar link (same flow normal sessions use).
 */
class AdminFreeSessionController extends BaseController
{
    public function index()
    {
        $pending = FreeSessionRequest::pending()
            ->with('user:id,first_name,last_name,email')
            ->latest('id')
            ->get();

        // Scheduled + given so the admin sees the full lifecycle of every assignment.
        $scheduled = FreeSessionRequest::whereIn('status', [
                FreeSessionRequest::STATUS_SCHEDULED,
                FreeSessionRequest::STATUS_GIVEN,
            ])
            ->with(['user:id,first_name,last_name,email', 'instructor:id,first_name,last_name'])
            ->latest('scheduled_at')
            ->limit(50)
            ->get();

        return view('datasource::management.free_sessions.index', compact('pending', 'scheduled'));
    }

    public function assignForm(FreeSessionRequest $freeSession)
    {
        if ($freeSession->status !== FreeSessionRequest::STATUS_PENDING) {
            return redirect()->route('admin.free-sessions.index')
                ->withErrors(['error' => 'This request is no longer pending.']);
        }

        $freeSession->load('user:id,first_name,last_name,email');

        // Open, future slots grouped by instructor for the admin to pick from.
        $slots = InstructorAvailability::available()
            ->where('end_at', '>=', now())
            ->with('instructor:id,first_name,last_name')
            ->orderBy('start_at')
            ->get();

        return view('datasource::management.free_sessions.assign', compact('freeSession', 'slots'));
    }

    public function assign(Request $request, FreeSessionRequest $freeSession)
    {
        if ($freeSession->status !== FreeSessionRequest::STATUS_PENDING) {
            return redirect()->route('admin.free-sessions.index')
                ->withErrors(['error' => 'This request is no longer pending.']);
        }

        $data = $request->validate([
            'availability_id' => 'required|exists:instructor_availabilities,id',
            'content'         => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Lock the slot row to avoid double booking.
            $slot = InstructorAvailability::where('id', $data['availability_id'])
                ->lockForUpdate()
                ->first();

            if (!$slot || $slot->status !== InstructorAvailability::STATUS_AVAILABLE) {
                DB::rollBack();
                return back()->withErrors(['error' => 'That slot is no longer available.']);
            }

            $session = ClassSession::create([
                'classroom_id'          => null,
                'instructor_id'         => $slot->instructor_id,
                'student_user_id'       => $freeSession->user_id,
                'held_at'               => $slot->start_at,
                'end_at'                => $slot->end_at,
                'content'               => $data['content'] ?? null,
                'class_session_type_id' => null,
                'type'                  => ClassSession::TYPE_FREE,
            ]);

            $slot->update(['status' => InstructorAvailability::STATUS_BOOKED]);

            $freeSession->update([
                'status'           => FreeSessionRequest::STATUS_SCHEDULED,
                'instructor_id'    => $slot->instructor_id,
                'availability_id'  => $slot->id,
                'class_session_id' => $session->id,
                'scheduled_at'     => $slot->start_at,
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        // Scheduling is committed. Send the WhatsApp notification in the background AFTER
        // the response — a delivery failure must never affect the (already saved) assignment.
        $this->sendInvite($freeSession, $session, $slot);

        return redirect()->route('admin.free-sessions.index')
            ->with('success', 'Free session scheduled. A WhatsApp message is being sent to the user.');
    }

    /**
     * Send the requesting user a WhatsApp notification after commit.
     * Mirrors the notification logic in Modules\Instructor ClassSessionController::store.
     */
    private function sendInvite(FreeSessionRequest $freeSession, ClassSession $session, InstructorAvailability $slot): void
    {
        try {
            $attendeeUser = User::find($freeSession->user_id);
            if (!$attendeeUser) {
                Log::warning('[WhatsApp][free] No attendee user', ['request_id' => $freeSession->id]);
                return;
            }

            // The requester's phone lives on their student/parent profile (keyed by user_id).
            $phone = optional(Parentt::find($freeSession->user_id))->phone_number
                ?? optional(Student::find($freeSession->user_id))->phone_number;
            if (empty($phone)) {
                Log::warning('[WhatsApp][free] Attendee has no phone — skipping', [
                    'request_id' => $freeSession->id,
                    'user_id'    => $freeSession->user_id,
                ]);
                return;
            }

            $instructorUser = User::find($slot->instructor_id);
            $instructorName = trim(($instructorUser->first_name ?? '') . ' ' . ($instructorUser->last_name ?? ''));

            $meta = [
                'summary'         => 'Free Trial Session',
                'description'     => 'Your free trial session with ' . ($instructorName ?: 'your instructor') . '.'
                    . ($session->content ? "\n" . $session->content : ''),
                'start_utc'       => Carbon::parse($session->held_at)->setTimezone('UTC'),
                'end_utc'         => Carbon::parse($session->end_at)->setTimezone('UTC'),
                'instructor_name' => $instructorName ?: null,
            ];

            Log::info('[WhatsApp][free] Dispatch notification', [
                'session_id' => $session->id,
                'user_id'    => $freeSession->user_id,
            ]);

            // afterResponse() runs the send after the HTTP response is returned, so a slow
            // or failing gateway never blocks or breaks the assignment request. If a real
            // queue worker is configured later, the job already implements ShouldQueue.
            SendSessionWhatsApp::dispatch(
                $phone,
                SessionMessage::whatsappBody($meta, $attendeeUser->timezone)
            )->afterResponse();
        } catch (\Throwable $e) {
            Log::error('[WhatsApp][free] Notify block failed', [
                'request_id' => $freeSession->id ?? null,
                'error'      => $e->getMessage(),
            ]);
        }
    }
}
