<?php

namespace Modules\StudentActivity\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\Parentt\Parentt;
use DataSource\Entities\Inrollment\Inrollment;

class ParenttController extends Controller
{
  public function showDashboard()
  { 
    return view('studentactivity::dashboard');
  }

  public function progressChilderns()
  { 
    $userParent = Auth::user();
    $parent=Parentt::find($userParent->id);
    $children = $parent->students;
    $list = Inrollment::whereIn('student_id', $children->pluck('user_id')->toArray())->get();
    $route_name = 'inrollments';
    $table_name = 'inrollment Courses';
    return view('studentactivity::progressChilderns',compact('list','route_name','table_name')); 
  }

}
