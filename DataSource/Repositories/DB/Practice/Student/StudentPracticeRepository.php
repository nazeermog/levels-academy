<?php

namespace DataSource\Repositories\DB\Practice\Student;


use DataSource\Entities\Practice\Practice;
use DataSource\Entities\Practice\PracticeType;

class StudentPracticeRepository
{
    public static function find($id)
    {
        return Practice::find($id);
    }

    public static function findType($id)
    {
        return PracticeType::find($id);
    }

}
