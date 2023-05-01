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

}
