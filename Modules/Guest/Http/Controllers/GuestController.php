<?php

namespace Modules\Guest\Http\Controllers;

use Illuminate\Http\Request;
use DataSource\Entities\Blog\Blog;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use DataSource\Repositories\DB\Blog\Admin\AdminBlogRepository;
use DataSource\Repositories\DB\Course\Admin\AdminCourseRepository;
use DataSource\Repositories\DB\Lesson\Admin\AdminLessonRepository;
use DataSource\Repositories\DB\Taxonomy\Admin\AdminTaxonomyRepository;
use DataSource\Repositories\DB\CoursePath\Admin\AdminCoursePathRepository;
use DataSource\Repositories\DB\Instructor\Admin\AdminInstructorRepository;
use DataSource\Repositories\DB\Course\Student\StudentCourseRatingRepository;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $taxonomies = AdminTaxonomyRepository::list();
        $coursePaths = AdminCoursePathRepository::list();
        $coursesCounts = AdminCoursePathRepository::CourseCounter();
        $courses = AdminCourseRepository::list();
        $courseLessons = AdminCourseRepository::courseLessons();
        $totalLessonTime = 0;
        $totalLessonTime = AdminLessonRepository::TotalLessonsHours($courses);
        $instructor = AdminInstructorRepository::InstructorForCourse($courses);
        $courseRate = StudentCourseRatingRepository::CalculateAverageRatingForAllCourses($courses);
        $coursePaths = AdminCoursePathRepository::list();
        $coursesCounts = AdminCoursePathRepository::CourseCounter();
        $blogs = AdminBlogRepository::list();
        foreach ($coursePaths as $coursePath) {
            $totalLessonCount = 0;
            $totalLessonCoursesTime = 0;

            foreach ($coursePath->courses as $course) {
                $totalLessonCount += AdminLessonRepository::SingleCoursTotalLessonCount($course);
                $totalLessonCoursesTime += AdminLessonRepository::SingleCoursTotalLesson($course);
            }

            $coursePath->totalLessonCount = $totalLessonCount;
            $coursePath->totalLessonCoursesTime = $totalLessonCoursesTime;
        }
        return view('guest::index', [
            'courses' => $courses,
            'courseLessons' => $courseLessons,
            'totalLessonTime' => $totalLessonTime,
            'instructor' => $instructor,
            'courseRate' => $courseRate,
            'coursePaths' => $coursePaths,
            'coursesCounts' => $coursesCounts,
            'taxonomies' => $taxonomies,
            'coursePaths' => $coursePaths,
            'coursesCounts' => $coursesCounts,
            'blogs' => $blogs,
        ]);
    }


    public function show_blog($blogid)
    {
        $blog = Blog::findOrFail($blogid);
        return view("guest::show_blog", compact('blog'));
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
        return view('guest::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('guest::edit');
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
