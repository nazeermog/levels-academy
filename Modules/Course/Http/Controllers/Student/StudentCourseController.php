<?php

namespace Modules\Course\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use DataSource\Entities\Course\Course;
use DataSource\Entities\Course\CourseStep;
use DataSource\Entities\Course\CourseContent;
use DataSource\Repositories\DB\Course\Admin\AdminCourseRepository;
use DataSource\Repositories\DB\Taxonomy\Admin\AdminTaxonomyRepository;

class StudentCourseController extends Controller
{

    public function index()
{
    $taxonomies = AdminTaxonomyRepository::list();
    $courseList = AdminCourseRepository::list();
    $courses = $courseList['courses'];
    $courseLessons = $courseList['courseLessons'];

    return view('course::student.index', [
        'taxonomies' => $taxonomies,
        'courses' => $courses,
        'courseLessons' => $courseLessons,
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
        }   

        return view('course::student.show', [
            'course' => $course,
            'contents' => $contents,
            'contentSteps' => $contentSteps,
        ]);
    }

}
