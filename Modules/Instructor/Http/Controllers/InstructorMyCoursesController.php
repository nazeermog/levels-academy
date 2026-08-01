<?php

namespace Modules\Instructor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\Course\Course;
use DataSource\Entities\Instructor\Instructor;
use DataSource\Entities\Worksheet\Worksheet;
use DataSource\Entities\Link\Link;
use DataSource\Entities\Classroom\ClassSession;
use DataSource\Http\Requests\Admin\CourseContent\Update as UpdateRequest;
use DataSource\Repositories\DB\Course\Admin\AdminCourseContentRepository;
use DataSource\Repositories\DB\Lesson\Admin\AdminLessonRepository;
use DataSource\Repositories\DB\Taxonomy\Admin\AdminTaxonomyRepository;
use DataSource\Repositories\DB\Practice\Admin\AdminPracticeTypeRepository;

/**
 * Lets an instructor manage the courses they teach — the same course builder the
 * admin uses, but scoped to (and ownership-checked against) their own courses.
 */
class InstructorMyCoursesController extends Controller
{
    public function index()
    {
        $courses = Course::where('instructor_id', Auth::id())->get();

        return view('instructor::courses.my', compact('courses'));
    }

    public function edit($courseId)
    {
        $item = Course::findOrFail($courseId);
        abort_unless((int) $item->instructor_id === (int) Auth::id(), 403);

        $lessons     = AdminLessonRepository::list();
        $practices   = AdminPracticeTypeRepository::list();
        $taxonomies  = AdminTaxonomyRepository::list();
        $instructors = Instructor::all();
        $sessions    = ClassSession::normal()->with(['classroom', 'instructor', 'sessionType'])->orderByDesc('held_at')->get();
        $worksheets  = Worksheet::active()->orderBy('title')->get();
        $links       = Link::orderBy('title')->get();

        return view('instructor::courses.edit', compact('item', 'lessons', 'practices', 'taxonomies', 'instructors', 'sessions', 'worksheets', 'links'));
    }

    public function update(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);
        abort_unless((int) $course->instructor_id === (int) Auth::id(), 403);

        $validated = $request->validate((new UpdateRequest())->rules());
        $data = array_merge($validated, ['boxArr' => json_decode($request->input('boxArr'), true)]);
        // The course stays owned by this instructor regardless of any posted value.
        $data['instructor_id'] = (int) Auth::id();

        (new AdminCourseContentRepository())->update($request, $data, $courseId);

        return redirect()->route('instructor.mycourses.index')->withSuccess('Course updated successfully.');
    }
}
