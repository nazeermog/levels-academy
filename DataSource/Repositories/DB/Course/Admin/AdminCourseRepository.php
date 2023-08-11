<?php

namespace DataSource\Repositories\DB\Course\Admin;

use DataSource\Entities\Course\Course;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminCourseRepository
{
    use AdminCRUDGenericRepository;

    protected $model = Course::class;

    public static function list()
    {
            return Course::all();
    }

    public static function courseLessons()
    {
            $courses = Course::all();
        $courseLessons = [];
            foreach ($courses as $course) {
                $totalLessons = 0;
                $contents = $course->courseContents;
                foreach ($contents as $content) {
                    $totalLessons += $content->courseSteps()->where('stepable_type', 'Lessons')->count();
                }
                $courseLessons[$course->id] = $totalLessons;
            }

            return  $courseLessons;
            
        }

}
