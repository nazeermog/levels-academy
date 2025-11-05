<?php

namespace Modules\Instructor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\Classroom\Classroom;
use DataSource\Entities\Classroom\ClassSession;
use DataSource\Entities\Classroom\ClassSessionType;
use DataSource\Entities\Student\Student;
use DataSource\Entities\Transaction\Transaction;
use Illuminate\Support\Facades\DB;

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

    public function edit(ClassSession $session)
    {
        $instructorId = Auth::id();
        if ((int) $session->instructor_id !== (int) $instructorId) {
            abort(403);
        }
        return view('instructor::classrooms.sessions.edit', compact('session'));
    }

    public function update(Request $request, ClassSession $session)
    {
        $instructorId = Auth::id();
        if ((int) $session->instructor_id !== (int) $instructorId) {
            abort(403);
        }
        $data = $request->validate([
            'content' => 'nullable|string',
        ]);
        $session->update([
            'content' => $data['content'] ?? null,
        ]);
        return redirect()->route('instructor.sessions.index')->with('success', 'Session updated.');
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

        DB::beginTransaction();
        try {
            $type = ClassSessionType::findOrFail($data['class_session_type_id']);

            $session = ClassSession::create([
                'classroom_id' => $classroom->id,
                'instructor_id' => $instructorId,
                'held_at' => $data['held_at'],
                'content' => $data['content'] ?? null,
                'class_session_type_id' => $data['class_session_type_id'],
            ]);

            $studentUserIds = $classroom->students()->pluck('users.id')->toArray();
            $numStudents = count($studentUserIds);
            if ($numStudents > 0) {
                $perStudentPrice = $type->price; // charge full price per student
                foreach ($studentUserIds as $studentUserId) {
                    $student = Student::find($studentUserId);
                    if (!$student) { continue; }
                    $parent = $student->parentts()->first();
                    if (!$parent) { continue; }
                    Transaction::create([
                        'parent_id' => $parent->user_id,
                        'course_id' => 0,
                        'student_id' => $student->user_id,
                        'price' => $perStudentPrice,
                        'type' => 'once',
                        'is_credit' => 0,
                        'desc' => 'Class session #'.$session->id.' charge: '.$type->name,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('instructor.sessions.index')->with('success', 'Session saved. Parent transactions added.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}


