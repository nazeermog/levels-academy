<?php

namespace Modules\Course\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use DataSource\Entities\Course\Course;
use DataSource\Entities\Course\CourseStep;
use DataSource\Entities\Course\CourseContent;
use DataSource\Repositories\DB\Course\Admin\AdminCourseRepository;
use DataSource\Repositories\DB\Lesson\Admin\AdminLessonRepository;
use DataSource\Repositories\DB\Taxonomy\Admin\AdminTaxonomyRepository;
use DataSource\Repositories\DB\Course\Student\StudentCoursesRepository;
use DataSource\Repositories\DB\Instructor\Admin\AdminInstructorRepository;
use DataSource\Repositories\DB\Course\Student\StudentCourseRatingRepository;
use DataSource\Repositories\DB\Course\Student\StudentCourseContentRepository;

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
    $courseRate=StudentCourseRatingRepository::CalculateAverageRatingForAllCourses($courses);

    return view('course::student.index', [
      'taxonomies' => $taxonomies,
      'courses' => $courses,
      'courseLessons' => $courseLessons,
      'totalLessonTime' => $totalLessonTime,
      'instructor' => $instructor,
      'courseRate'=> $courseRate,


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
    $courseRate=StudentCourseRatingRepository::CalculateAverageRatingForCourse($course);
    $ratingWithComments=StudentCourseRatingRepository::ratingWithComments($course);
    $ratingCount=StudentCourseRatingRepository::RatingCount($course);
    $rating5=StudentCourseRatingRepository::CountEachStar5($course);
    $rating4=StudentCourseRatingRepository::CountEachStar4($course);
    $rating3=StudentCourseRatingRepository::CountEachStar3($course);
    $rating2=StudentCourseRatingRepository::CountEachStar2($course);
    $rating1=StudentCourseRatingRepository::CountEachStar1($course);
    $instructorCourses=StudentCourseContentRepository::moreCourses($course);
    $instructorCoursesRate=StudentCourseRatingRepository::CalculateAverageRatingForAllCourses($instructorCourses);
    $ratingOnce=StudentCourseRatingRepository::ratingOnce($course);
    return view('course::student.show', [
      'course' => $course,
      'contents' => $contents,
      'contentSteps' => $contentSteps,
      'totalLessonTime' => $totalLessonTime,
      'coursestepCount' => $coursestepCount,
      'instructor' => $instructor,
      'courseRate'=> $courseRate,
      'ratingWithComments'=>$ratingWithComments,
      'ratingCount'=>$ratingCount,
      'rating5'=>$rating5,
      'rating4'=>$rating4,
      'rating3'=>$rating3,
      'rating2'=>$rating2,
      'rating1'=>$rating1,
      'instructorCourses'=>$instructorCourses,
      'instructorCoursesRate'=>$instructorCoursesRate,
      'ratingOnce'=>$ratingOnce,
    ]);
  }

  
}
