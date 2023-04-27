<?php

namespace DataSource\Repositories\DB\ResultPractice\Student;

use DataSource\Entities\ResultPractice\ResultPractice;
use DataSource\Entities\ResultPractice\ResultPracticeType;
use DataSource\Repositories\DB\Practice\Student\StudentPracticeRepository;

class StudentResultPracticeRepository
{
    public static function sendResult($data)
    {

        $result = new ResultPractice();
        $result->practice_id = $data['practice_id'];
        $result->student_id = 0;//$data['student_id'];
        $result->is_true = $data['is_true'] == 'false' ? 0 : 1;
        $result->result_true = $data['result_true'];
        $result->result_student = $data['result_student'];
        $result->level_title = $data['level_title'];
        $result->save();

        //todo::يجب هنا ان نعرف نوع التمرين القادم من عند الطالب وبناء عليه نحدد حقول النوع
        $resultType = new ResultPracticeType();
        $resultType->result_practice_id = $result->id;
        $resultType->seconds_speed = $data['seconds_speed'];
        $resultType->card_number = $data['card_number'];
        $resultType->range_number_from = $data['range_number_from'];
        $resultType->range_number_to = $data['range_number_to'];
        $resultType->save();
        return $result;
    }
}
