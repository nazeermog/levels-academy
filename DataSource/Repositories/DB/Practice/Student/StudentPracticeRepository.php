<?php

namespace DataSource\Repositories\DB\Practice\Student;


use DataSource\Entities\Practice\PracticeType;
use DataSource\Entities\Practice\PracticeTypeDetail;

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
