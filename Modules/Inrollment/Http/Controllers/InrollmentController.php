<?php

namespace Modules\Inrollment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use DataSource\Entities\Course\Course;
use DataSource\Entities\Lesson\Lesson;
use Illuminate\Contracts\Support\Renderable;
use DataSource\Entities\Course\CourseStudent;
use DataSource\Entities\Inrollment\Inrollment;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Repositories\DB\Lesson\Admin\AdminLessonRepository;
use DataSource\Repositories\DB\Taxonomy\Admin\AdminTaxonomyRepository;
use DataSource\Repositories\DB\Instructor\Admin\AdminInstructorRepository;
use DataSource\Repositories\DB\Course\Student\StudentCourseRatingRepository;
use DataSource\Repositories\DB\StudentInrollmentRepository;


class InrollmentController extends Controller
{
  use AdminCRUDControllerActions;


  public function index()
  {
    $taxonomies = AdminTaxonomyRepository::list();
    $courses = StudentInrollmentRepository::list();
    $courseLessons = StudentInrollmentRepository::inrollmentLessons();
    $totalLessonTime = 0;
    $totalLessonTime = StudentInrollmentRepository::TotalLessonsHours($courses);
    $instructor = StudentInrollmentRepository::InstructorForCourse($courses);
    $courseRate=StudentInrollmentRepository::CalculateAverageRatingForAllCourses($courses);
    return view('inrollment::index', [
      'taxonomies' => $taxonomies,
      'courses' => $courses,
      'courseLessons' => $courseLessons,
      'totalLessonTime' => $totalLessonTime,
      'instructor' => $instructor,
      'courseRate'=> $courseRate,
    ]);
  
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    return view('inrollment::create');
  }

  /**
   * Store a newly created resource in storage.
   * @param Request $request
   * @return Renderable
   */
  public function store(Request $request, $courseId)
  {
    $studentId = auth()->user()->id;
    $inrollment = Inrollment::where('student_id', $studentId)
      ->where('course_id', $courseId)
      ->first();

    if ($inrollment) {
      return redirect()->back()->withError('You are already enrolled in this course.');
    }
    $inrollmentNew = new Inrollment();
    $inrollmentNew->student_id = $studentId;
    $inrollmentNew->course_id = $courseId;
    // $inrollmentNew->approved_at = now();

    $inrollmentNew->save();




    return redirect()->back()->withSuccess('Enrollment successful');
  }

  /**
   * Show the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function show($id)
  {
    return view('inrollment::show');
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function edit($id)
  {
    return view('inrollment::edit');
  }

  /**
   * Update the specified resource in storage.
   * @param Request $request
   * @param int $id
   * @return Renderable
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Renderable
   */
  public function destroy($id)
  {
    //
  }


  public function watched($lessonId, $courseId)
  {
    $studentId = auth()->user()->id;
    $existingRecord = CourseStudent::where('student_id', $studentId)
      ->where('lesson_id', $lessonId)
      ->where('course_id', $courseId)
      ->first();

    if (!$existingRecord) {
      CourseStudent::create([
        'student_id' => $studentId,
        'lesson_id' => $lessonId,
        'course_id' => $courseId,
      ]);
    }
    $totalWatchedTime = CourseStudent::where('student_id', $studentId)
      ->where('course_id', $courseId)
      ->join('lessons', 'course_students.lesson_id', '=', 'lessons.id')
      ->sum('lessons.time');

    $course = Course::find($courseId);

    $totalLessonTimeOld = AdminLessonRepository::SingleCoursTotalLesson($course);

    $progressPercentage = ($totalWatchedTime / $totalLessonTimeOld) * 100;

    $enrollment = Inrollment::where('student_id', $studentId)
      ->where('course_id', $courseId)
      ->first();

    if ($enrollment) {
      $enrollment->progress = number_format($progressPercentage, 1);
      $enrollment->update();
    }

    return redirect()->back()->withSuccess('Lesson marked as watched');
  }
  public static function  isWatched($courseId,$lessonId)
  {
    $studentId = auth()->user()->id;

    // Check if the lesson is watched by the student for the course.
    $watched = CourseStudent::where('student_id', $studentId)
      ->where('lesson_id', $lessonId)
      ->where('course_id', $courseId)
      ->first();
    return $watched;
  }
}
