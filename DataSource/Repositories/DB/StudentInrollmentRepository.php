<?php

namespace  DataSource\Repositories\DB;

use DataSource\Entities\Inrollment\Inrollment;
use DataSource\Entities\Instructor\Instructor;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class StudentInrollmentRepository
{
  use AdminCRUDGenericRepository;

  protected $model = Inrollment::class;

  public static function list()
  {
    return Inrollment::all();
  }
  public static function isAuthInroll($course,$semester){
    $inrollmentstatus=false;
    $studentId=auth()->user()->id;
    $inrollment=Inrollment::where('student_id',$studentId)
    ->where('course_id',$course->id)->where('semester_id',$semester->id)->first();
    if($inrollment){
      $inrollmentstatus=true;
    }

    return $inrollmentstatus;
  }

  public static function inrollmentLessons()
  {
    $inrollments = Inrollment::all();
    $courseLessons = [];
    foreach ($inrollments as $inrollment) {
      $course = $inrollment->course;
      $totalLessons = 0;

      $contents = $course->courseContents;
      foreach ($contents as $content) {
        $totalLessons += $content->courseSteps()->where('stepable_type', 'Lessons')->count();
      }

      $courseLessons[$course->id] = $totalLessons;
    }

    return  $courseLessons;
  }
  public static function InstructorForCourse($inrollments)
  {

    $instructors = [];

    foreach ($inrollments as $inrollment) {
      $course = $inrollment->course;

      $instructorId = $course->instructor_id;
      $instructor = Instructor::where('user_id', $instructorId)->first();
      $instructors[$course->id] = $instructor;
    }
    return $instructors;
  }
  public static function InstructorForOneCourse($course)
  {
    $instructorId = $course->instructor_id;
    $instructor = Instructor::where('user_id', $instructorId)->first();
    return $instructor;
  }

  public static function TotalLessonsHours($inrollments)
  {

    $totalLessonTimes = [];

    foreach ($inrollments as $inrollment) {
      $course = $inrollment->course;

      $totalLessonTime = 0;
      $courseContents = $course->courseContents()->with('courseSteps.lesson')->get();
      foreach ($courseContents as $courseContent) {
        foreach ($courseContent->courseSteps as $step) {
          if ($step->stepable_type === 'Lessons' && $step->lesson) {
            $totalLessonTime += $step->lesson->time;
          }
        }
      }
      $totalLessonTimes[$course->id] = $totalLessonTime;
    }

    return $totalLessonTimes;
  }

  public static function CalculateAverageRatingForAllCourses($inrollments)
  {
    $averageRatings = [];

    foreach ($inrollments as $inrollment) {
      $course = $inrollment->course;
      $totalRatings = $course->ratings()->get();
      $ratingsCount = $totalRatings->count();
      if ($ratingsCount == 0) {
        $averageRatings[$course->id] = 0;
      } else {
        $sumRatings = $totalRatings->sum('rate');
        $averageRating = $sumRatings / $ratingsCount;
        $averageRatings[$course->id] = $averageRating;
      }
    }

    return $averageRatings;
  }
}
