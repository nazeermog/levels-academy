<?php

namespace Modules\LearningPath\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LearningPathController extends Controller
{
    public function index()
    {
        return view('learningpath::student.index');
    }
}
