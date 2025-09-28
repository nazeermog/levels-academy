<?php

namespace DataSource\Http\Controllers\Admin\Instructor;

use DataSource\Http\Controllers\BaseController;
use DataSource\Entities\Instructor\InstructorNote;

class AdminInstructorNoteController extends BaseController
{
    public function index()
    {
        $table_name = 'Instructor Notes';
        $route_name = 'instructor-notes';

        $notes = InstructorNote::with(['student.user', 'instructor'])->latest()->paginate(20);

        return view('datasource::management.instructorNotes.index', compact('notes', 'table_name', 'route_name'));
    }
}


