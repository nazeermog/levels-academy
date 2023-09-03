<?php

namespace DataSource\Repositories\DB\Course\Student;

use DataSource\Entities\Course\Course;
use Modules\DataResource\Entities\Course\CourseContent;
use Modules\DataResource\Responses\Course\Student\StudentCourseContentResource;

class StudentCourseContentRepository
{
    public function getCourseContent($courseId)
    {
        $courseContent = CourseContent::orderBy('ordering', 'asc')
            ->where('course_id', $courseId)
            ->get();
        return [
            'data' => [
                'data' => StudentCourseContentResource::collection($courseContent),
                'status' => true,
                'message' => 'success'
            ],
            'code' => 200
        ];
    }

    public function getContent($contentId)
    {
        $content = CourseContent::where('course_id', $contentId)
            ->first();
//        if ($content->content_type == 'Lesson')
//            return [
//                'data' => [
//                    'data' => $content->media,
//                    'status' => true,
//                    'message' => 'success'
//                ],
//                'code' => 200
//            ];
//        else
        return [
            'data' => [
                'data' => $content->content,
                'status' => true,
                'message' => 'success'
            ],
            'code' => 200
        ];
    }

    public static function moreCourses($course){

        $instructorCourses = Course::where('instructor_id', $course->instructor_id)->where('id', '!=', $course->id)->get(); 
        return $instructorCourses;
      }
    

}
