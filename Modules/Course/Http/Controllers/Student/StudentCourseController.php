<?php

namespace Modules\Course\Http\Controllers\Student;

use App\Http\Controllers\Controller;

class StudentCourseController extends Controller
{

    public function index()
    {
        return view('course::student.index');
    }

    public function show()
    {
        return view('course::student.show');
    }

}
