<?php

namespace Modules\DataResource\Repositories\DB\Course\Student;

use Modules\DataResource\Entities\Course\Course;

class StudentCoursesRepository
{
    public function getCourses($categoryId)
    {
        $courses = Course::where('is_active', 1)
            ->where('taxonomy_id', $categoryId)
            ->get();
        return [
            'data' => [
                'data' => $courses,
                'status' => true,
                'message' => 'success'
            ],
            'code' => 200
        ];
    }
}
