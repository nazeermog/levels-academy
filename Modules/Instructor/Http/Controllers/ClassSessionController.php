<?php

namespace Modules\Instructor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\Classroom\Classroom;
use DataSource\Entities\Classroom\ClassSession;
use DataSource\Entities\Classroom\ClassSessionType;

class ClassSessionController extends Controller
{
    public function index()
    {
        $instructorId = Auth::id();
        $sessions = ClassSession::with(['classroom', 'type'])
            ->where('instructor_id', $instructorId)
            ->orderByDesc('held_at')
            ->paginate(20);
        return view('instructor::classrooms.sessions.index', compact('sessions'));
    }

    public function create()
    {
        $instructorId = Auth::id();
        $classrooms = Classroom::where('instructor_id', $instructorId)->orderBy('name')->get();
        $orgId = optional($classrooms->first())->organization_id;
        $types = $orgId ? ClassSessionType::inOrganization($orgId)->orderBy('name')->get() : collect();
        return view('instructor::classrooms.sessions.create', compact('classrooms', 'types'));
    }

    public function store(Request $request)
    {
        $instructorId = Auth::id();
        $data = $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'held_at' => 'required|date',
            'content' => 'nullable|string',
            'class_session_type_id' => 'required|exists:class_session_types,id',
        ]);
        $classroom = Classroom::findOrFail($data['classroom_id']);
        if ((int) $classroom->instructor_id !== (int) $instructorId) {
            abort(403);
        }
        ClassSession::create([
            'classroom_id' => $classroom->id,
            'instructor_id' => $instructorId,
            'held_at' => $data['held_at'],
            'content' => $data['content'] ?? null,
            'class_session_type_id' => $data['class_session_type_id'],
        ]);
        return redirect()->route('instructor.sessions.index')->with('success', 'Session saved.');
    }
}


