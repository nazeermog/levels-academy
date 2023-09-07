<?php

namespace DataSource\Repositories\DB\Practice\Student;


use DataSource\Entities\PracticeType\PracticeType;
use DataSource\Entities\PracticeType\PracticeTypeDetail;

class StudentPracticeRepository
{
    public static function find($id)
    {
        return PracticeType::find($id);
    }

    public static function findType($id)
    {
        return PracticeTypeDetail::find($id);
    }
    public static function list()
    {
        return PracticeType::all();
    }

    public static function SingleCoursTotalPractice($course)
    {
        $totalpracticeCount = 0;
        $courseContents = $course->courseContents()->with('courseSteps.practiceType')->get();
        foreach ($courseContents as $courseContent) {
            foreach ($courseContent->courseSteps as $step) {
                if ($step->stepable_type === 'Practices') {
                    $totalpracticeCount += 1;
                }
            }
        }
        return $totalpracticeCount;
    }

}
