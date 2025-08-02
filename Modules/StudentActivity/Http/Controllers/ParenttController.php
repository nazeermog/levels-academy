<?php

namespace Modules\StudentActivity\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\User\UserEvent;
use DataSource\Entities\Parentt\Parentt;
use DataSource\Entities\Inrollment\Inrollment;
use DataSource\Entities\Instructor\InstructorNote;

class ParenttController extends Controller
{
  public function showDashboard()
  {
    return view('studentactivity::dashboard');
  }

  public function progressChilderns()
  {
    $userParent = Auth::user();
    $parent = Parentt::find($userParent->id);
    $children = $parent->students;
    $list = Inrollment::whereIn('student_id', $children->pluck('user_id')->toArray())->get();
    $route_name = 'inrollments';
    $table_name = 'childern progress';
    return view('studentactivity::progressChilderns', compact('list', 'route_name', 'table_name'));
  }
  public function childrenEvents(Request $request)
  {
    $userParent = Auth::user();
    $parent = Parentt::find($userParent->id);

    if (!$parent) {
      abort(403, 'Unauthorized');
    }

    $selectedStudentId = $request->input('student_id');
    $selectedTypes = $request->input('type', []);
    $selectedRole = $request->input('role', '');

    $students = $parent->students;

    $types = UserEvent::whereIn('user_id', $students->pluck('user_id'))
      ->whereNotNull('type')
      ->distinct()
      ->pluck('type');

    $roles = UserEvent::whereIn('user_id', $students->pluck('user_id'))
      ->whereNotNull('role')
      ->distinct()
      ->pluck('role');

    $eventsQuery = UserEvent::query();

    if ($selectedStudentId) {
      $student = $students->where('user_id', $selectedStudentId)->first();
      if ($student) {
        $eventsQuery->where('user_id', $student->user_id);
      } else {
        $eventsQuery->whereRaw('1 = 0');
      }
    } else {
      $eventsQuery->whereIn('user_id', $students->pluck('user_id'));
    }

    if (!empty($selectedTypes)) {
      $eventsQuery->whereIn('type', $selectedTypes);
    }

    if ($selectedRole) {
      $eventsQuery->where('role', $selectedRole);
    }

    $events = $eventsQuery->with('user')->latest()->paginate(5);

    return view('studentactivity::childernEvents', compact('events', 'students', 'selectedStudentId', 'types', 'roles', 'selectedTypes', 'selectedRole'));
  }
  public function childernNotes()
  {
    $userParent = Auth::user();
    $parent = Parentt::find($userParent->id);

    $studentIds = $parent->students()->pluck('id');

    $notes = InstructorNote::with('student')
      ->whereIn('student_id', $studentIds)
      ->orderByDesc('created_at')
      ->get();

    return view('studentactivity::childernNotes', compact('notes'));
  }

  public function check($noteId)
  {
    $note = InstructorNote::findOrFail($noteId);

    $userParent = Auth::user();
    $parent = Parentt::find($userParent->id);

    $childIds = $parent->students()->pluck('id')->toArray();

    if (!in_array($note->student_id, $childIds)) {
      abort(403);
    }

    if (!$note->is_read) {
      $note->is_read = true;
      $note->save();
    }

    return redirect()->route('parentt.notes.childernNotes')->with('success', 'Note marked as read.');
  }
}
