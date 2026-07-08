<?php

namespace Modules\Instructor\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\CourseProgressService;
use DataSource\Entities\Course\Course;
use DataSource\Entities\Student\Student;
use DataSource\Entities\Inrollment\Inrollment;

/**
 * Lets an instructor see where each enrolled student is in their courses
 * (per-step progress derived by CourseProgressService).
 */
class InstructorCourseProgressController extends Controller
{
    public function index()
    {
        $courses = Course::where('instructor_id', Auth::id())
            ->withCount('inrollments')
            ->get();

        return view('instructor::progress.index', compact('courses'));
    }

    public function show(Course $course, CourseProgressService $progress)
    {
        abort_unless((int) $course->instructor_id === (int) Auth::id(), 403);

        $studentIds = Inrollment::where('course_id', $course->id)
            ->pluck('student_id')
            ->map(fn ($v) => (int) $v)
            ->unique()
            ->values()
            ->all();

        $students = Student::whereIn('user_id', $studentIds)->get()->keyBy('user_id');
        $reports = $progress->reports($course, $studentIds);

        return view('instructor::progress.show', compact('course', 'students', 'reports', 'studentIds'));
    }
}
