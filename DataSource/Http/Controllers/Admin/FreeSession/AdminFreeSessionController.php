<?php

namespace DataSource\Http\Controllers\Admin\FreeSession;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Support\IcsBuilder;
use App\Jobs\SendSessionInvite;
use DataSource\Entities\User\User;
use DataSource\Entities\Classroom\ClassSession;
use DataSource\Entities\FreeSession\FreeSessionRequest;
use DataSource\Entities\FreeSession\InstructorAvailability;

/**
 * Admin management of free-session requests (the waiting list).
 * The admin assigns a pending request to an instructor's available time slot,
 * which creates a free ClassSession and emails the requesting user a calendar
 * invite (same flow normal sessions use).
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

        // Scheduling is committed. Send the calendar invite in the background AFTER
        // the response — a mail failure must never affect the (already saved) assignment.
        $this->sendInvite($freeSession, $session, $slot);

        return redirect()->route('admin.free-sessions.index')
            ->with('success', 'Free session scheduled. A calendar invite is being emailed to the user.');
    }

    /**
     * Queue an ICS calendar invite to the requesting user after commit.
     * Mirrors the invite logic in Modules\Instructor ClassSessionController::store.
     */
    private function sendInvite(FreeSessionRequest $freeSession, ClassSession $session, InstructorAvailability $slot): void
    {
        try {
            $attendeeUser = User::find($freeSession->user_id);
            if (!$attendeeUser || empty($attendeeUser->email)) {
                Log::warning('[ICS][free] No attendee email', ['request_id' => $freeSession->id]);
                return;
            }

            $instructorUser  = User::find($slot->instructor_id);
            $instructorEmail = $instructorUser?->email ?? config('mail.from.address');
            $instructorName  = trim(($instructorUser->first_name ?? '') . ' ' . ($instructorUser->last_name ?? ''));

            $domain = parse_url(config('app.url'), PHP_URL_HOST) ?: 'levels-academy.local';
            $uid    = 'free-session-' . $session->id . '@' . $domain;

            $startUtc = Carbon::parse($session->held_at)->setTimezone('UTC');
            $endUtc   = Carbon::parse($session->end_at)->setTimezone('UTC');
            $summary  = 'Free Trial Session';
            $description = 'Your free trial session with ' . ($instructorName ?: 'your instructor') . '.'
                . ($session->content ? "\n" . $session->content : '');

            $attendees = [[
                'email' => $attendeeUser->email,
                'name'  => trim(($attendeeUser->first_name ?? '') . ' ' . ($attendeeUser->last_name ?? '')),
            ]];

            $ics = IcsBuilder::buildInvite([
                'uid'             => $uid,
                'summary'         => $summary,
                'description'     => $description,
                'organizer_email' => $instructorEmail,
                'organizer_name'  => $instructorName ?: null,
                'start_utc'       => $startUtc,
                'end_utc'         => $endUtc,
                'attendees'       => $attendees,
                'sequence'        => 0,
                'method'          => 'REQUEST',
            ]);

            // Render in the attendee's timezone when we know it (auto-detected at login).
            $attendeeTz = ($attendeeUser->timezone && in_array($attendeeUser->timezone, timezone_identifiers_list(), true))
                ? $attendeeUser->timezone : null;
            $startUtcText  = $attendeeTz
                ? $startUtc->copy()->setTimezone($attendeeTz)->format('Y-m-d H:i') . ' (' . $attendeeTz . ')'
                : $startUtc->format('Y-m-d H:i') . ' UTC';
            $endUtcText    = $attendeeTz
                ? $endUtc->copy()->setTimezone($attendeeTz)->format('Y-m-d H:i') . ' (' . $attendeeTz . ')'
                : $endUtc->format('Y-m-d H:i') . ' UTC';
            $startIsoParam = $startUtc->format('Ymd\THis\Z');
            $endIsoParam   = $endUtc->format('Ymd\THis\Z');
            $startLocalLink = 'https://www.timeanddate.com/worldclock/fixedtime.html?iso=' . $startIsoParam;
            $endLocalLink   = 'https://www.timeanddate.com/worldclock/fixedtime.html?iso=' . $endIsoParam;

            $body = '<p>Your free trial session has been scheduled.</p>'
                . '<p><strong>' . $summary . '</strong></p>'
                . '<p>Instructor: ' . ($instructorName ?: 'TBA') . '</p>'
                . '<p>'
                . 'Starts: ' . $startUtcText . ' (<a href="' . $startLocalLink . '">view in your local time</a>)<br>'
                . 'Ends: ' . $endUtcText . ' (<a href="' . $endLocalLink . '">view in your local time</a>)'
                . '</p>'
                . '<p>Tip: Open the attached calendar invite; your calendar will show the event in your local time automatically.</p>';

            $email = $attendeeUser->email;
            Log::info('[ICS][free] Dispatch invite', ['session_id' => $session->id, 'to' => $email]);
            // afterResponse() runs the send after the HTTP response is returned, so a slow
            // or failing mail server never blocks or breaks the assignment request. If a real
            // queue worker is configured later, the job already implements ShouldQueue.
            SendSessionInvite::dispatch(
                $email,
                'Your Free Trial Session',
                $body,
                $ics
            )->afterResponse();
        } catch (\Throwable $e) {
            Log::error('[ICS][free] Mail block failed', [
                'request_id' => $freeSession->id ?? null,
                'error'      => $e->getMessage(),
            ]);
        }
    }
}
