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
        // Eager-load contents + steps so we don't run a query per course/content (N+1).
        $courses = Course::with('courseContents.courseSteps')->get();
        $courseLessons = [];
        foreach ($courses as $course) {
            $totalLessons = 0;
            foreach ($course->courseContents as $content) {
                $totalLessons += $content->courseSteps->where('stepable_type', 'Lessons')->count();
            }
            $courseLessons[$course->id] = $totalLessons;
        }

        return $courseLessons;
    }

}
