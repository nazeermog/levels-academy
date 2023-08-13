<?php

namespace Modules\Course\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use DataSource\Entities\Course\Course;
use DataSource\Entities\Course\CourseStep;
use DataSource\Entities\Course\CourseContent;
use DataSource\Repositories\DB\Course\Admin\AdminCourseRepository;
use DataSource\Repositories\DB\Lesson\Admin\AdminLessonRepository;
use DataSource\Repositories\DB\Taxonomy\Admin\AdminTaxonomyRepository;
use DataSource\Repositories\DB\Instructor\Admin\AdminInstructorRepository;

class StudentCourseController extends Controller
{

  public function index()
  {
    $taxonomies = AdminTaxonomyRepository::list();
    $courses = AdminCourseRepository::list();
    $courseLessons = AdminCourseRepository::courseLessons();
    $totalLessonTime = 0;
    $totalLessonTime = AdminLessonRepository::TotalLessonsHours($courses);
    $instructor = AdminInstructorRepository::InstructorForCourse($courses);
    return view('course::student.index', [
      'taxonomies' => $taxonomies,
      'courses' => $courses,
      'courseLessons' => $courseLessons,
      'totalLessonTime' => $totalLessonTime,
      'instructor' => $instructor

    ]);
  }

  public function show($courseId)
  {
    $course = Course::findOrFail($courseId);
    $contents = CourseContent::where('course_id', $course->id)->get();
    $contentSteps = [];

    foreach ($contents as $content) {
      $steps = $content->courseSteps()->get();
      $contentSteps[$content->id] = $steps;
      $coursestepCount[$content->id] = $steps->count();
    }

    $instructor = AdminInstructorRepository::InstructorForOneCourse($course);
    $totalLessonTime = AdminLessonRepository::SingleCoursTotalLesson($course);

    return view('course::student.show', [
      'course' => $course,
      'contents' => $contents,
      'contentSteps' => $contentSteps,
      'totalLessonTime' => $totalLessonTime,
      'coursestepCount' => $coursestepCount,
      'instructor' => $instructor

    ]);
  }
}
