<?php

namespace Modules\Inrollment\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserEventLogger;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\Course\Course;
use DataSource\Entities\Lesson\Lesson;
use DataSource\Entities\Student\Student;
use Illuminate\Contracts\Support\Renderable;
use DataSource\Entities\Course\CourseStudent;
use DataSource\Entities\Inrollment\Inrollment;
use DataSource\Entities\Transaction\Transaction;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Repositories\DB\StudentInrollmentRepository;
use DataSource\Repositories\DB\Lesson\Admin\AdminLessonRepository;
use DataSource\Repositories\DB\Taxonomy\Admin\AdminTaxonomyRepository;
use DataSource\Repositories\DB\Instructor\Admin\AdminInstructorRepository;
use DataSource\Repositories\DB\Course\Student\StudentCourseRatingRepository;


class InrollmentController extends Controller
{
  use AdminCRUDControllerActions;


  public function index()
  {
    $studentId = auth()->user()->id;
    // Eager-load course + taxonomy to avoid N+1 when mapping/grouping below.
    $enrollments = Inrollment::with('course.taxonomy')->where('student_id', $studentId)->get();
    $courses = $enrollments->map(function ($enrollment) {
      return $enrollment->course;
    });
    $coursesByTaxonomy = [];
    foreach ($courses as $course) {
      $taxonomy = $course->taxonomy;
      if ($taxonomy) {
        $coursesByTaxonomy[$taxonomy->id]['taxonomy'] = $taxonomy;
        $coursesByTaxonomy[$taxonomy->id]['courses'][] = $course;
      }
    }
    $courseLessons = StudentInrollmentRepository::inrollmentLessons();
    $totalLessonTime = StudentInrollmentRepository::TotalLessonsHours($enrollments);
    $instructors = StudentInrollmentRepository::InstructorForCourse($enrollments);
    $courseRate = StudentInrollmentRepository::CalculateAverageRatingForAllCourses($enrollments);

    return view('inrollment::index', [
      'coursesByTaxonomy' => $coursesByTaxonomy,
      'courseLessons' => $courseLessons,
      'totalLessonTime' => $totalLessonTime,
      'instructors' => $instructors,
      'courseRate' => $courseRate,
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
    $request->validate([
      'semester_id' => 'required|exists:semesters,id',
    ]);

    DB::beginTransaction();

    try {
      $studentId = Auth::id();
      $semesterId = $request->semester_id;

      $course = Course::findOrFail($courseId);

      // Check if already enrolled
      $enrollment = Inrollment::where('student_id', $studentId)
        ->where('course_id', $courseId)
        ->where('semester_id', $semesterId)
        ->first();

      if ($enrollment) {
        return redirect()->back()->withErrors('You are already enrolled in this course.');
      }

      // Create new enrollment
      $newEnrollment = new Inrollment();
      $newEnrollment->student_id = $studentId;
      $newEnrollment->semester_id = $semesterId;
      $newEnrollment->course_id = $courseId;
      $newEnrollment->save();

      // Log event
      UserEventLogger::log(
        'course enrolled',
        'enrolled in ' . $course->title . ' on semester ' . $newEnrollment->semester->title,
        'course_enrollment'
      );

      $student = Student::findOrFail($studentId);
      $parents = $student->parentts;
      $parent = $parents->first();
      
      Transaction::create([
        'parent_id' => $parent->user_id,
        'course_id' => $course->id,
        'student_id' => $student->user_id,
        'price'     => $course->price,
        'type'      => $course->payment_type,
        'is_credit' => 0,
      ]);
      DB::commit();
      return redirect()->back()->with('success', 'Enrollment successful.');
    } catch (\Exception $e) {
      DB::rollBack();

      return redirect()->back()->withErrors('Something went wrong: ' . $e->getMessage());
    }
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
}
