<?php

namespace DataSource\Http\Controllers\Admin\Course;

use Illuminate\Routing\Controller as BaseController;
use App\Services\CourseProgressService;
use DataSource\Entities\Course\Course;
use DataSource\Entities\Student\Student;
use DataSource\Entities\Inrollment\Inrollment;

/**
 * Admin view of per-student, per-step course progress. The admin can see every
 * course and how far each enrolled student has progressed.
 */
class AdminCourseProgressController extends BaseController
{
    public function index()
    {
        $courses = Course::withCount('inrollments')->get();

        return view('datasource::management.course_progress.index', compact('courses'));
    }

    public function show(Course $course, CourseProgressService $progress)
    {
        $studentIds = Inrollment::where('course_id', $course->id)
            ->pluck('student_id')
            ->map(fn ($v) => (int) $v)
            ->unique()
            ->values()
            ->all();

        $students = Student::whereIn('user_id', $studentIds)->get()->keyBy('user_id');
        $reports = $progress->reports($course, $studentIds);

        return view('datasource::management.course_progress.show', compact('course', 'students', 'reports', 'studentIds'));
    }
}
