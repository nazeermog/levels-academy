<?php

namespace DataSource\Repositories\DB\Semester\Student;

use DataSource\Entities\Semester\Semester;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class StudentSemesterRepository
{
    use AdminCRUDGenericRepository;

    protected $model = Semester::class;

    public static function list()
    {
        return Semester::all();
    }
    public static function semesteOnDate()
    {
        $semesters = Semester::where('start_date', '<=', now())->where('end_date', '>=', now())->first();
        return $semesters;
    }
}
