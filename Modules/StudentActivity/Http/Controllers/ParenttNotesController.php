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

class ParenttNotesController extends Controller
{
  
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
