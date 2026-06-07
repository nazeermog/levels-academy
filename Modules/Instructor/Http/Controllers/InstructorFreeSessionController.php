<?php

namespace Modules\Instructor\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\Classroom\ClassSession;

/**
 * Read-only list of the free sessions assigned to the logged-in instructor.
 */
class InstructorFreeSessionController extends Controller
{
    public function index()
    {
        $instructorId = Auth::id();

        $sessions = ClassSession::free()
            ->where('instructor_id', $instructorId)
            ->with('attendee:id,first_name,last_name,email')
            ->orderByDesc('held_at')
            ->paginate(20);

        return view('instructor::free_sessions.index', compact('sessions'));
    }
}
