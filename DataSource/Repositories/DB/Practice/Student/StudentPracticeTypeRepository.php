<?php

namespace DataSource\Repositories\DB\Practice\Student;


use DataSource\Entities\PracticeType\PracticeTypeDetail;

class StudentPracticeTypeRepository
{
    public static function find($id)
    {
        return PracticeTypeDetail::find($id);
    }


}
