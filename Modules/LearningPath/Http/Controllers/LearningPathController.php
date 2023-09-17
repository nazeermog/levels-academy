<?php

namespace Modules\LearningPath\Http\Controllers;

use Illuminate\Routing\Controller;
use DataSource\Repositories\DB\Lesson\Admin\AdminLessonRepository;
use DataSource\Repositories\DB\Taxonomy\Admin\AdminTaxonomyRepository;
use DataSource\Repositories\DB\CoursePath\Admin\AdminCoursePathRepository;
use DataSource\Repositories\DB\Instructor\Admin\AdminInstructorRepository;
use DataSource\Repositories\DB\Course\Student\StudentCourseRatingRepository;

class LearningPathController extends Controller
{
  public function index()
  {
    $taxonomies = AdminTaxonomyRepository::list();
    $coursePaths = AdminCoursePathRepository::list();
    $coursesCounts = AdminCoursePathRepository::CourseCounter();
    return view('learningpath::student.index', [
      'taxonomies' => $taxonomies,
      'coursePaths' => $coursePaths,
      'coursesCounts' => $coursesCounts,
    ]);
  }

  public function show($pathId)
  {
      $coursePath = AdminCoursePathRepository::find($pathId);
      $courses = $coursePath->courses;
      $totalLessonCoursesTime=0;
      $totalLessonCount=0;
      foreach ($courses as $course) {
          $instructors[$course->id] = AdminInstructorRepository::InstructorForOneCourse($course);
          $ratingavg[$course->id] =StudentCourseRatingRepository::CalculateAverageRatingForCourse($course);
          $totalLessonTime[$course->id]=AdminLessonRepository::SingleCoursTotalLesson($course);
          $totalLessonCount=AdminLessonRepository::SingleCoursTotalLessonCount($course) + $totalLessonCount;
      }
      $totalLessonCoursesTime=AdminCoursePathRepository::SinglePathTotalLesson($coursePath);

      return view('learningpath::student.show', compact('coursePath', 'courses', 'instructors','ratingavg','totalLessonTime','totalLessonCoursesTime','totalLessonCount'));
  }
  
}
