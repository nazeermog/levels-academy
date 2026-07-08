<?php

namespace Modules\StudentActivity\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\User\UserEvent;
use DataSource\Entities\Parentt\Parentt;
use DataSource\Entities\Inrollment\Inrollment;
use DataSource\Entities\Transaction\Transaction;
use DataSource\Entities\Instructor\InstructorNote;
use DataSource\Entities\Classroom\ClassSession;
use DataSource\Entities\Classroom\ClassSessionStudent;
use DataSource\Entities\Student\Student;

class ParenttNotesController extends Controller
{
  
  public function childernNotes()
  {
    $userParent = Auth::user();
    $parent = Parentt::find($userParent->id);
    if (!$parent) {
      return view('studentactivity::childernNotes', ['notes' => collect()]);
    }

    $studentIds = $parent->students()->pluck('students.user_id');

    $notes = InstructorNote::with('student.user')
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
    if (!$parent) {
      abort(403);
    }

    $childIds = $parent->students()->pluck('students.user_id')->toArray();

    if (!in_array($note->student_id, $childIds)) {
      abort(403);
    }

    if (!$note->is_read) {
      $note->is_read = true;
      $note->save();
    }

    return redirect()->route('parentt.notes.childernNotes')->with('success', 'Note marked as read.');
  }

  public function childrenClassroomSessions(Request $request)
  {
    $userParent = Auth::user();
    $parent = Parentt::find($userParent->id);

    // child user_ids from pivot are Student model primary keys (user_id)
    $childUserIds = $parent->students()->pluck('students.user_id');

    // One row per (child, session): shows the session time, whether it was given
    // to THAT child, and the instructor's note of what they learned.
    $records = ClassSessionStudent::query()
      ->join('class_sessions', 'class_session_student.class_session_id', '=', 'class_sessions.id')
      ->whereIn('class_session_student.student_id', $childUserIds)
      ->where('class_sessions.type', ClassSession::TYPE_NORMAL)
      ->with(['session.classroom', 'session.instructor', 'studentUser'])
      ->orderByDesc('class_sessions.held_at')
      ->select('class_session_student.*')
      ->paginate(20);

    return view('studentactivity::childrenClassroomSessions', compact('records'));
  }
  
}
