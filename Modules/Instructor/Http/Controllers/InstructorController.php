<?php

namespace Modules\Instructor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\Course\Course;
use DataSource\Entities\User\UserEvent;
use DataSource\Entities\Student\Student;
use Illuminate\Contracts\Support\Renderable;
use DataSource\Entities\Inrollment\Inrollment;
use DataSource\Entities\Instructor\Instructor;
use DataSource\Entities\Course\CourseTranslation;
use DataSource\Entities\StudentScore\StudentScore;
use DataSource\Entities\Semester\SemesterTranslation;
use DataSource\Repositories\DB\StudentInrollmentRepository;
use DataSource\Repositories\DB\Course\Admin\AdminCourseRepository;
use DataSource\Entities\PracticeType\PracticeTypeDetailTranslation;
use DataSource\Repositories\DB\Semester\Admin\AdminSemesterRepository;
use DataSource\Repositories\DB\Instructor\Admin\AdminInstructorRepository;
use DataSource\Repositories\DB\Practice\Admin\AdminPracticeTypeRepository;
use DataSource\Repositories\DB\Course\Student\StudentCourseRatingRepository;
use DataSource\Repositories\DB\StudentScore\Instructor\AdminStudentScoreRepository;

class InstructorController extends Controller
{
  /**
   * Display a listing of the resource.
   * @return Renderable
   */
  public function index()
  {
    return view('instructor::dashboard');
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    return view('instructor::create');
  }

  /**
   * Store a newly created resource in storage.
   * @param Request $request
   * @return Renderable
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Show the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function show($id)
  {
    return view('instructor::show');
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function edit($id)
  {
    return view('instructor::edit');
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

  public function showInrollmentCourses()
  {
    $list  = (new StudentInrollmentRepository())->index();
    $route_name = 'inrollments';
    $table_name = 'inrollment Courses';
    return view('instructor::InrollmentCourses', compact('list', 'route_name', 'table_name'));
  }

  public function showStudentScoreBoard()
  {
    $list = StudentScore::select('student_id')
      ->selectRaw('SUM(coin) as total_coin')
      ->groupBy('student_id')
      ->orderByDesc('total_coin')
      ->with('student') // eager-load names in one query (the view reads $item->student)
      ->get();
    $courses = AdminCourseRepository::list();
    $practices = AdminPracticeTypeRepository::list();
    $semesters = AdminSemesterRepository::list();
    $totalCoins = AdminStudentScoreRepository::TotalCoins();
    $route_name = 'studentScore';
    $table_name = 'Student Score';
    return view(
      'instructor::StudentScore',
      compact('list', 'route_name', 'table_name', 'totalCoins', 'courses', 'practices', 'semesters')
    );
  }
  public function showStudentScoreBoardByFilter(Request $request)
  {
    $courseId = $request->input('courseId');
    $semesterId = $request->input('semesterId');
    $practiceId = $request->input('practiceId');
    $type = $request->input('type'); // New type filter input

    $list = StudentScore::select('student_id')
      ->when($courseId !== null, function ($query) use ($courseId) {
        return $query->where('course_id', $courseId);
      })
      ->when($semesterId !== null, function ($query) use ($semesterId) {
        return $query->where('semester_id', $semesterId);
      })
      ->when($practiceId !== null, function ($query) use ($practiceId) {
        return $query->where('practice_id', $practiceId);
      })
      ->when($type !== null, function ($query) use ($type) { // Filter by type
        return $query->where('type', $type);
      })
      ->selectRaw('MIN(course_id) as course_id')
      ->selectRaw('MIN(semester_id) as semester_id')
      ->selectRaw('MIN(practice_id) as practice_id')
      ->selectRaw('SUM(coin) as total_coin')
      ->groupBy('student_id')
      ->orderByDesc('total_coin')
      ->get();

    $courseTitles = CourseTranslation::whereIn('course_id', $list->pluck('course_id'))->where('locale', 'en')->pluck('title', 'course_id');
    $semesterTitles = SemesterTranslation::whereIn('semester_id', $list->pluck('semester_id'))->where('locale', 'en')->pluck('title', 'semester_id');
    $practiceTitles = PracticeTypeDetailTranslation::whereIn('practice_type_id', $list->pluck('practice_id'))->where('locale', 'en')->pluck('title', 'practice_type_id');
    $studentAvatars = Student::whereIn('user_id', $list->pluck('student_id'))->pluck('avatar', 'user_id');
    $studentFirstNames = Student::whereIn('user_id', $list->pluck('student_id'))->pluck('first_name', 'user_id');
    $studentLastNames = Student::whereIn('user_id', $list->pluck('student_id'))->pluck('last_name', 'user_id');

    $list = $list->map(function ($item) use ($courseTitles, $semesterTitles, $practiceTitles, $studentFirstNames, $studentLastNames, $studentAvatars, $courseId, $semesterId, $practiceId) {
      if ($courseId !== null) {
        $item->course_title = $courseTitles[$item->course_id];
      }
      if ($semesterId !== null) {
        $item->semester_title = $semesterTitles[$item->semester_id];
      }
      if ($practiceId !== null) {
        $item->practice_title = $practiceTitles[$item->practice_id];
      }
      $item->student_name = $studentFirstNames[$item->student_id] . ' ' . $studentLastNames[$item->student_id] ?? 'N/A';
      $item->student_avatar = asset($studentAvatars[$item->student_id]);
      return $item;
    });

    return response()->json(['list' => $list], 200);
  }
  public function showProfile($instructorId)
  {
    $instructor = Instructor::where('user_id', $instructorId)->first();
    $instructorCourses = Course::where('instructor_id', $instructorId)->get();
    $instructorCoursesRate = StudentCourseRatingRepository::CalculateAverageRatingForAllCourses($instructorCourses);
    return view(
      'instructor::InstructorProfile',
      compact('instructor', 'instructorCourses', 'instructorCoursesRate')
    );
  }
  public function enrolledStudentsEvents(Request $request)
  {
    $userInstructor = Auth::user();
    $instructor = Instructor::where('user_id', $userInstructor->id)->first();

    if (!$instructor) {
      abort(403, 'Unauthorized');
    }

    $courseIds = Course::where('instructor_id', $instructor->user_id)->pluck('id');

    if ($courseIds->isEmpty()) {
      $students = collect();
      $events = collect();
      $selectedStudentId = $request->input('student_id');
      $types = collect();
      $roles = collect();
      return view('instructor::instructorEvents', compact('events', 'students', 'selectedStudentId', 'types', 'roles'));
    }

    $studentIds = Inrollment::whereIn('course_id', $courseIds)->pluck('student_id')->unique();

    $students = User::whereIn('id', $studentIds)->get();

    $types = UserEvent::whereIn('user_id', $studentIds)
      ->whereNotNull('type')
      ->distinct()
      ->pluck('type');

    $roles = UserEvent::whereIn('user_id', $studentIds)
      ->whereNotNull('role')
      ->distinct()
      ->pluck('role');

    $eventsQuery = UserEvent::query();

    if ($request->filled('student_id')) {
      if ($studentIds->contains($request->input('student_id'))) {
        $eventsQuery->where('user_id', $request->input('student_id'));
      } else {
        $eventsQuery->whereRaw('1=0'); 
      }
    } else {
      $eventsQuery->whereIn('user_id', $studentIds);
    }

    if ($request->filled('type') && is_array($request->input('type'))) {
      $eventsQuery->whereIn('type', $request->input('type'));
    }

    if ($request->filled('role')) {
      $eventsQuery->where('role', $request->input('role'));
    }

    $events = $eventsQuery->with('user')->latest()->paginate(5);

    return view('instructor::instructorEvents', compact('events', 'students', 'types', 'roles'));
  }
}
