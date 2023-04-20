<?php

namespace DataSource\Repositories\DB\Practice\Student;


use DataSource\Entities\Practice\PracticeType;

class StudentPracticeTypeRepository
{
    public static function find($id)
    {
        return PracticeType::find($id);
    }
}
