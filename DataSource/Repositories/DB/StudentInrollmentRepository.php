<?php

namespace  DataSource\Repositories\DB;

use DataSource\Entities\Inrollment\Inrollment;
use DataSource\Entities\Instructor\Instructor;
use DataSource\Entities\Course\Course;
use DataSource\Entities\Course\Rating;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class StudentInrollmentRepository
{
  use AdminCRUDGenericRepository;

  protected $model = Inrollment::class;

  public static function list()
  {
    return Inrollment::all();
  }
  public static function isAuthInroll($course, $semester)
  {
    if (!$semester) {
      return false;
    }

    $studentId = auth()->id();
    return Inrollment::where('student_id', $studentId)
      ->where('course_id', $course->id)
      ->where('semester_id', $semester->id)
      ->exists();
  }


  public static function inrollmentLessons()
  {
    // Eager-load course + contents + steps to avoid an N+1 per enrollment/content.
    $inrollments = Inrollment::with('course.courseContents.courseSteps')->get();
    $courseLessons = [];
    foreach ($inrollments as $inrollment) {
      $course = $inrollment->course;
      if (!$course) { continue; }
      $totalLessons = 0;
      foreach ($course->courseContents as $content) {
        $totalLessons += $content->courseSteps->where('stepable_type', 'Lessons')->count();
      }
      $courseLessons[$course->id] = $totalLessons;
    }

    return  $courseLessons;
  }
  public static function InstructorForCourse($inrollments)
  {
    // Batch-load instructors in one query instead of one per enrollment (N+1).
    $courseIds = collect($inrollments)->pluck('course_id')->filter()->unique()->all();
    $coursesById = Course::whereIn('id', $courseIds)->get()->keyBy('id');
    $instructorIds = $coursesById->pluck('instructor_id')->filter()->unique()->all();
    $instructorsByUserId = Instructor::whereIn('user_id', $instructorIds)->get()->keyBy('user_id');

    $instructors = [];
    foreach ($inrollments as $inrollment) {
      $course = $coursesById->get($inrollment->course_id);
      if (!$course) { continue; }
      $instructors[$course->id] = $instructorsByUserId->get($course->instructor_id);
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
    // Load all needed contents/steps/lessons in one batch instead of per enrollment (N+1).
    $courseIds = collect($inrollments)->pluck('course_id')->filter()->unique()->all();
    $eagerCourses = Course::whereIn('id', $courseIds)
      ->with('courseContents.courseSteps.lesson')
      ->get();

    $totalLessonTimes = [];
    foreach ($eagerCourses as $course) {
      $totalLessonTime = 0;
      foreach ($course->courseContents as $courseContent) {
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
    // One aggregate query instead of one per enrollment (N+1).
    $courseIds = collect($inrollments)->pluck('course_id')->filter()->unique()->all();
    $byCourse = Rating::whereIn('course_id', $courseIds)
      ->selectRaw('course_id, SUM(rate) as sum_rate, COUNT(*) as cnt')
      ->groupBy('course_id')
      ->get()
      ->keyBy('course_id');

    $averageRatings = [];
    foreach ($inrollments as $inrollment) {
      $courseId = $inrollment->course_id;
      $row = $byCourse->get($courseId);
      if (!$row || (int) $row->cnt === 0) {
        $averageRatings[$courseId] = 0;
      } else {
        $averageRatings[$courseId] = $row->sum_rate / $row->cnt;
      }
    }

    return $averageRatings;
  }
  public static function getAuthUserEnrollments()
  {
    $studentId = auth()->user()->id;
    $courses = Inrollment::where('student_id', $studentId)->get();
    return  $courses;
  }
}
