<?php

namespace Modules\Instructor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Auth;
use DataSource\Entities\Student\Student;
use Modules\Instructor\Http\Requests\Store;
use Modules\Instructor\Http\Requests\Update;
use DataSource\Entities\Instructor\InstructorNote;
use DataSource\Entities\Classroom\Classroom;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Repositories\DB\Instructor\Student\InstructorNoteRepository;

class InstructorNoteController extends Controller
{
    use AdminCRUDControllerActions;

    protected string $store_request = Store::class;
    protected string $update_request = Update::class;
    protected string $module = 'Modules::Instructor.InstructorNote';
    protected string $table_name = 'practice_details';
    protected string $route_name = 'practice-details';

    public function index()
    {
        $instructorId = Auth::id();
        $notes = InstructorNote::where('instructor_id', $instructorId)
            ->with('student.user')
            ->latest()
            ->get();

        return view('instructor::notes.index', compact('notes'));
    }

    public function create()
    {
        $studentIds = Classroom::where('instructor_id', Auth::id())
            ->with('students:id')
            ->get()
            ->pluck('students')
            ->flatten()
            ->pluck('id')
            ->unique()
            ->values();

        $students = Student::whereIn('user_id', $studentIds)->get();
        return view('instructor::notes.create', compact('students'));
    }


    public function store(Store $request)
    {
        try {
            InstructorNote::create([
                'instructor_id' => Auth::id(),
                'student_id'    => $request->student_id,
                'note'          => $request->note,
                'rating'        => $request->rating,
                'is_read'       => false,
            ]);

            return redirect()->route('instructor.notes.index')->with('success', 'Note added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function edit($id)
    {
        $note = InstructorNote::where('id', $id)
            ->where('instructor_id', Auth::id())
            ->firstOrFail();

        $students = Auth::user()->instructor->students ?? [];

        return view('instructor::notes.edit', compact('note', 'students'));
    }

    public function update(Update $request, $id)
    {
        $note = InstructorNote::where('id', $id)
            ->where('instructor_id', Auth::id())
            ->firstOrFail();

        $note->update([
            'student_id' => $request->student_id,
            'note'       => $request->note,
            'rating'     => $request->rating,
        ]);

        return redirect()->route('instructor.notes.index')->with('success', 'Note updated successfully.');
    }

    public function destroy($id)
    {
        $note = InstructorNote::where('id', $id)
            ->where('instructor_id', Auth::id())
            ->firstOrFail();

        $note->delete();

        return redirect()->route('instructor.notes.index')->with('success', 'Note deleted successfully.');
    }
}
