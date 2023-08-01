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
    // Fetch all courses
    $courses = Course::all();

    // Calculate the total number of lessons for each course
    $courseLessons = [];
    foreach ($courses as $course) {
        $totalLessons = 0;
        $contents = $course->courseContents;
        foreach ($contents as $content) {
            $totalLessons += $content->courseSteps()->where('stepable_type', 'Lessons')->count();
        }
        $courseLessons[$course->id] = $totalLessons;
    }

    return [
        'courses' => $courses,
        'courseLessons' => $courseLessons,
    ];
}

}
