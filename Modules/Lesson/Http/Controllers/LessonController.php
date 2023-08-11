<?php

namespace Modules\Lesson\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataSource\Entities\Course\Course;
use DataSource\Entities\Lesson\Lesson;
use DataSource\Entities\Course\CourseStep;
use Illuminate\Contracts\Support\Renderable;
use DataSource\Entities\Course\CourseContent;
use DataSource\Repositories\DB\Lesson\Admin\AdminLessonRepository;
use DataSource\Repositories\DB\Taxonomy\Admin\AdminTaxonomyRepository;
use DataSource\Repositories\DB\CoursePath\Admin\AdminCoursePathRepository;
use DataSource\Repositories\DB\Instructor\Admin\AdminInstructorRepository;

class LessonController extends Controller
{
    public function show($lessonId,$courseId)
    {  
        $lesson = Lesson::findOrFail($lessonId);
        
        $course = Course::findOrFail($courseId);

        
        $totalLessonTime=AdminLessonRepository::SingleCoursTotalLesson($course);
        $instructor=AdminInstructorRepository::InstructorForOneCourse($course);

        return view('lesson::student.show', [
            'lesson' => $lesson,
            'course' => $course,
            'totalLessonTime'=>$totalLessonTime,
            'instructor'=>$instructor,
        ]);
    }
    
}
