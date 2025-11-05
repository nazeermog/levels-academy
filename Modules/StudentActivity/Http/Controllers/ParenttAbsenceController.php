<?php

namespace Modules\StudentActivity\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DataSource\Entities\Absence\Absence;
use DataSource\Entities\Student\Student;
use DataSource\Entities\Classroom\ClassSession;
use DataSource\Entities\Classroom\Classroom;
use DataSource\Entities\Transaction\Transaction;

class ParenttAbsenceController extends Controller
{
    public function index()
    {
        $parentId = Auth::id();
        $studentIds = Student::whereHas('parentts', fn($q) => $q->where('parentt_id', $parentId))->pluck('user_id');
        $absences = Absence::whereIn('student_id', $studentIds)
            ->with('session')
            ->orderByDesc('id')
            ->paginate(20);
        return view('studentactivity::absences.index', compact('absences'));
    }

    public function create()
    {
        $parentId = Auth::id();
        // Load only this parent's children
        $children = Student::with('user')
            ->whereHas('parentts', fn($q) => $q->where('parentt_id', $parentId))
            ->get();

        $childUserIds = $children->pluck('user_id')->all();

        // Upcoming sessions where any of the parent's children are in the classroom
        $sessions = ClassSession::with('classroom')
            ->where('held_at', '>', Carbon::now())
            ->whereHas('classroom.students', function ($q) use ($childUserIds) {
                $q->whereIn('users.id', $childUserIds);
            })
            ->orderBy('held_at')
            ->get();

        return view('studentactivity::absences.create', compact('children', 'sessions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'class_session_id' => 'required|exists:class_sessions,id',
            'student_id' => 'required|exists:students,user_id',
            'notes' => 'nullable|string',
        ]);
        $parentId = Auth::id();
        $owns = Student::where('user_id', $data['student_id'])
            ->whereHas('parentts', fn($q) => $q->where('parentt_id', $parentId))
            ->exists();
        if (!$owns) { abort(403); }

        $session = ClassSession::with('classroom')->findOrFail($data['class_session_id']);
        $requestedAt = Carbon::now();
        $heldAt = Carbon::parse($session->held_at);
        $hoursDiff = $requestedAt->diffInHours($heldAt, false);

        // Ensure session is in the future
        if ($heldAt->isPast()) {
            return back()->withErrors(['class_session_id' => 'You can only request absence for upcoming sessions.'])->withInput();
        }

        // Ensure selected student is in this session's classroom
        $studentInClassroom = $session->classroom
            ? $session->classroom->students()->where('users.id', $data['student_id'])->exists()
            : false;
        if (!$studentInClassroom) {
            return back()->withErrors(['class_session_id' => 'Selected student is not part of the chosen session classroom.'])->withInput();
        }

        // Use organization-configured window (fallback to 24 if not set)
        $org = optional(Auth::user())->organization;
        $windowHours = (int) (optional($org)->absence_free_hours ?? 24);
        $status = $hoursDiff >= $windowHours ? 'approved' : 'rejected';
        $autoNotes = $status === 'approved'
            ? 'Approved: requested '.$hoursDiff.' hours before session (>= '.$windowHours.' hours window).'
            : 'Rejected: requested '.$hoursDiff.' hours before session (< '.$windowHours.' hours window).';

        $absence = Absence::create([
            'class_session_id' => $session->id,
            'student_id' => $data['student_id'],
            'requested_at' => $requestedAt,
            'status' => $status,
            'notes' => trim(($data['notes'] ?? '').' '.$autoNotes),
        ]);

        // If approved, delete any existing debit transaction for this session/student (if already created)
        if ($status === 'approved') {
            Transaction::where('student_id', $data['student_id'])
                ->where('is_credit', 0)
                ->where('desc', 'like', 'Class session #'.$session->id.'%')
                ->delete();
        }

        return redirect()->route('parentt.absences.index')->with('success', 'Absence request submitted.');
    }
}

?>


