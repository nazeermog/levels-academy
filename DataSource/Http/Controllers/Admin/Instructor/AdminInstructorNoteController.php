<?php

namespace DataSource\Http\Controllers\Admin\Instructor;

use DataSource\Http\Controllers\BaseController;
use DataSource\Entities\Instructor\InstructorNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminInstructorNoteController extends BaseController
{
    public function index(Request $request)
    {
        $table_name = 'Instructor Notes';
        $route_name = 'instructor-notes';

        $user = Auth::user();
        $notesQuery = InstructorNote::with(['student.user', 'instructor'])->latest();

        // Super admin sees all notes globally
        if ($user && $user->role === 'super_admin') {
            $notes = $notesQuery->paginate(20);
            return view('datasource::management.instructorNotes.index', compact('notes', 'table_name', 'route_name'));
        }

        // Org admin: restrict to yasmine org only
        $currentOrg = $request->attributes->get('currentOrganization');
        if (! $user || $user->role !== 'admin' || ! $currentOrg || $currentOrg->subdomain !== 'yasmine') {
            abort(403);
        }

        $orgId = (int) $currentOrg->id;
        $notesQuery->whereHas('instructor', function ($q) use ($orgId) {
            $q->where('organization_id', $orgId);
        })->whereHas('student.user', function ($q) use ($orgId) {
            $q->where('organization_id', $orgId);
        });

        $notes = $notesQuery->paginate(20);

        return view('datasource::management.instructorNotes.index', compact('notes', 'table_name', 'route_name', 'currentOrg'));
    }
}


