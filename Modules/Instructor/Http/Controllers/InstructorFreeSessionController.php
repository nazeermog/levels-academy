<?php

namespace Modules\Instructor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\Classroom\ClassSession;
use DataSource\Entities\FreeSession\FreeSessionRequest;

/**
 * The free sessions assigned to the logged-in instructor. The instructor can
 * mark a scheduled session as "given" once it has happened and attach a note.
 */
class InstructorFreeSessionController extends Controller
{
    public function index()
    {
        $instructorId = Auth::id();

        $sessions = FreeSessionRequest::where('instructor_id', $instructorId)
            ->whereIn('status', [FreeSessionRequest::STATUS_SCHEDULED, FreeSessionRequest::STATUS_GIVEN])
            ->with([
                'user:id,first_name,last_name,email',
                'session:id,held_at,end_at,content',
            ])
            ->orderByDesc('scheduled_at')
            ->paginate(20);

        return view('instructor::free_sessions.index', compact('sessions'));
    }

    /**
     * Mark an assigned free session as given and (optionally) save a note.
     * Also callable on an already-given session to update the note.
     */
    public function markGiven(Request $request, FreeSessionRequest $freeSession)
    {
        abort_unless((int) $freeSession->instructor_id === (int) Auth::id(), 403);

        if (!in_array($freeSession->status, [FreeSessionRequest::STATUS_SCHEDULED, FreeSessionRequest::STATUS_GIVEN], true)) {
            return back()->withErrors(['error' => 'Only a scheduled session can be marked as given.']);
        }

        $data = $request->validate([
            'instructor_note' => 'nullable|string|max:2000',
        ]);

        $freeSession->status          = FreeSessionRequest::STATUS_GIVEN;
        $freeSession->instructor_note = $data['instructor_note'] ?? null;
        $freeSession->given_at        = $freeSession->given_at ?? now();
        $freeSession->save();

        // Keep the linked free ClassSession's given flag in sync.
        if ($freeSession->class_session_id) {
            ClassSession::where('id', $freeSession->class_session_id)->update(['is_given' => true]);
        }

        return back()->with('success', 'Free session marked as given.');
    }
}
