<?php

namespace DataSource\Http\Controllers\Admin\Classroom;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use DataSource\Entities\User\User;
use DataSource\Entities\Classroom\Classroom;

class AdminClassroomController extends BaseController
{
    public function index(Request $request)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        $classrooms = Classroom::with('instructor')
            ->when($currentOrg, fn($q) => $q->inOrganization($currentOrg->id))
            ->latest('id')
            ->paginate(20);

        return view('datasource::management.classrooms.index', compact('classrooms', 'currentOrg'));
    }

    public function create(Request $request)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        $instructors = User::where('role', 'instructor')
            ->when($currentOrg, fn($q) => $q->where('organization_id', $currentOrg->id))
            ->orderBy('first_name')
            ->get(['id','first_name','last_name']);
        $students = User::where('role', 'student')
            ->when($currentOrg, fn($q) => $q->where('organization_id', $currentOrg->id))
            ->orderBy('first_name')
            ->get(['id','first_name','last_name']);
        return view('datasource::management.classrooms.create', compact('currentOrg', 'instructors', 'students'));
    }

    public function store(Request $request)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'repeats_per_week' => 'required|integer|min:1|max:14',
            'instructor_id' => 'required|exists:users,id',
            'student_ids' => 'array',
            'student_ids.*' => 'exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            $classroom = Classroom::create([
                'name' => $data['name'],
                'repeats_per_week' => $data['repeats_per_week'],
                'instructor_id' => $data['instructor_id'],
                'organization_id' => $currentOrg ? $currentOrg->id : null,
            ]);

            $classroom->students()->sync($data['student_ids'] ?? []);

            DB::commit();
            return redirect()->route('admin.org.classrooms.index')->with('success', 'Classroom created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit(Request $request, Classroom $classroom)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        if ($currentOrg && (int) $classroom->organization_id !== (int) $currentOrg->id) {
            abort(403);
        }
        $instructors = User::where('role', 'instructor')
            ->when($currentOrg, fn($q) => $q->where('organization_id', $currentOrg->id))
            ->orderBy('first_name')
            ->get(['id','first_name','last_name']);
        $students = User::where('role', 'student')
            ->when($currentOrg, fn($q) => $q->where('organization_id', $currentOrg->id))
            ->orderBy('first_name')
            ->get(['id','first_name','last_name']);
        $selectedStudents = $classroom->students()->pluck('users.id')->toArray();
        return view('datasource::management.classrooms.edit', compact('classroom', 'currentOrg', 'instructors', 'students', 'selectedStudents'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        if ($currentOrg && (int) $classroom->organization_id !== (int) $currentOrg->id) {
            abort(403);
        }
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'repeats_per_week' => 'required|integer|min:1|max:14',
            'instructor_id' => 'required|exists:users,id',
            'student_ids' => 'array',
            'student_ids.*' => 'exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            $classroom->update([
                'name' => $data['name'],
                'repeats_per_week' => $data['repeats_per_week'],
                'instructor_id' => $data['instructor_id'],
            ]);
            $classroom->students()->sync($data['student_ids'] ?? []);

            DB::commit();
            return redirect()->route('admin.org.classrooms.index')->with('success', 'Classroom updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(Request $request, Classroom $classroom)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        if ($currentOrg && (int) $classroom->organization_id !== (int) $currentOrg->id) {
            abort(403);
        }
        try {
            $classroom->delete();
            return redirect()->route('admin.org.classrooms.index')->with('success', 'Classroom deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}


