<?php

namespace Modules\Course\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\Course\Course;
use DataSource\Entities\Course\CourseStep;
use DataSource\Entities\Course\CourseContent;
use DataSource\Entities\Classroom\ClassSessionStudent;
use DataSource\Repositories\DB\StudentInrollmentRepository;
use DataSource\Repositories\DB\Course\Admin\AdminCourseRepository;
use DataSource\Repositories\DB\Lesson\Admin\AdminLessonRepository;
use DataSource\Repositories\DB\Taxonomy\Admin\AdminTaxonomyRepository;
use DataSource\Repositories\DB\Course\Student\StudentCoursesRepository;
use DataSource\Repositories\DB\CoursePath\Admin\AdminCoursePathRepository;
use DataSource\Repositories\DB\Instructor\Admin\AdminInstructorRepository;
use DataSource\Repositories\DB\Semester\Student\StudentSemesterRepository;
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
    $courseRate = StudentCourseRatingRepository::CalculateAverageRatingForAllCourses($courses);
    $coursePaths = AdminCoursePathRepository::list();
    $coursesCounts = AdminCoursePathRepository::CourseCounter();
    return view('course::student.index', [
      'taxonomies' => $taxonomies,
      'courses' => $courses,
      'courseLessons' => $courseLessons,
      'totalLessonTime' => $totalLessonTime,
      'instructor' => $instructor,
      'courseRate' => $courseRate,
      'coursePaths' => $coursePaths,
      'coursesCounts' => $coursesCounts,
    ]);
  }

  public function show($courseId, \App\Services\CourseProgressService $progress)
  {
    $course = Course::findOrFail($courseId);
    $contents = CourseContent::where('course_id', $course->id)->orderBy('ordering')->get();
    $contentSteps = [];

    // The logged-in student's own step-based progress for this course.
    $myProgress = $progress->report($course, (int) Auth::id());

    foreach ($contents as $content) {
      $steps = $content->courseSteps()
        ->with(['practiceType', 'classSession.classroom', 'worksheet', 'link'])
        ->orderBy('ordering')
        ->get()
        ->filter(function ($step) {
          // Class-session steps are shown to every enrolled student, just like
          // lessons/worksheets/links — the student no longer has to belong to the
          // session's classroom. We only hide a step whose session row was deleted.
          // Per-student "given"/notes still come from the student's own attendance row.
          if ($step->stepable_type !== 'ClassSessions') {
            return true;
          }
          return (bool) $step->classSession;
        })
        ->values();
      $contentSteps[$content->id] = $steps;
      $coursestepCount[$content->id] = $steps->count();
    }

    // The logged-in student's per-session participation (given + notes), keyed by session id.
    $sessionStepIds = [];
    foreach ($contentSteps as $stepsCol) {
      foreach ($stepsCol as $st) {
        if ($st->stepable_type === 'ClassSessions') {
          $sessionStepIds[] = (int) $st->stepable_id;
        }
      }
    }
    $myAttendance = ClassSessionStudent::where('student_id', Auth::id())
      ->whereIn('class_session_id', $sessionStepIds)
      ->get()
      ->keyBy('class_session_id');

    // Worksheets this student has already opened (read) in this course.
    $myWorksheetReads = \DataSource\Entities\Course\CourseStudent::where('student_id', Auth::id())
      ->where('course_id', $course->id)
      ->whereNotNull('worksheet_id')
      ->pluck('worksheet_id')
      ->map(fn ($v) => (int) $v)
      ->all();

    // Links this student has already clicked in this course.
    $myLinkReads = \DataSource\Entities\Course\CourseStudent::where('student_id', Auth::id())
      ->where('course_id', $course->id)
      ->whereNotNull('link_id')
      ->pluck('link_id')
      ->map(fn ($v) => (int) $v)
      ->all();

    $instructor = AdminInstructorRepository::InstructorForOneCourse($course);
    $totalLessonTime = AdminLessonRepository::SingleCoursTotalLesson($course);
    $courseRate = StudentCourseRatingRepository::CalculateAverageRatingForCourse($course);
    $ratingWithComments = StudentCourseRatingRepository::ratingWithComments($course);
    $ratingCount = StudentCourseRatingRepository::RatingCount($course);
    $rating5 = StudentCourseRatingRepository::CountEachStar5($course);
    $rating4 = StudentCourseRatingRepository::CountEachStar4($course);
    $rating3 = StudentCourseRatingRepository::CountEachStar3($course);
    $rating2 = StudentCourseRatingRepository::CountEachStar2($course);
    $rating1 = StudentCourseRatingRepository::CountEachStar1($course);
    $instructorCourses = StudentCourseContentRepository::moreCourses($course);
    $instructorCoursesRate = StudentCourseRatingRepository::CalculateAverageRatingForAllCourses($instructorCourses);
    $ratingOnce = StudentCourseRatingRepository::ratingOnce($course);
    $semester = StudentSemesterRepository::semesteOnDate();
    $isAuthInroll = StudentInrollmentRepository::isAuthInroll($course, $semester);
    if (!$semester) {
      return redirect()->back()->with('error', 'there is no semesters for that course');
    }
    return view('course::student.show', compact(
      'course',
      'contents',
      'contentSteps',
      'myProgress',
      'myAttendance',
      'myWorksheetReads',
      'myLinkReads',
      'totalLessonTime',
      'coursestepCount',
      'instructor',
      'courseRate',
      'ratingWithComments',
      'ratingCount',
      'instructorCourses',
      'rating5',
      'rating4',
      'rating3',
      'rating2',
      'rating1',
      'instructorCoursesRate',
      'ratingOnce',
      'semester',
      'isAuthInroll',
    ));
  }
}
