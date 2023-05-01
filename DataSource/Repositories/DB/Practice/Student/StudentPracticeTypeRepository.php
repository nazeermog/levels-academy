<?php

namespace DataSource\Repositories\DB\Practice\Student;


use DataSource\Entities\Practice\PracticeTypeDetail;

class StudentPracticeTypeRepository
{
    public static function find($id)
    {
        return PracticeTypeDetail::find($id);
    }


}
