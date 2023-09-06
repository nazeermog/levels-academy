<?php

namespace DataSource\Repositories\DB\Semester\Admin;

use DataSource\Entities\Semester\Semester;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminSemesterRepository
{
    use AdminCRUDGenericRepository;

    protected $model = Semester::class;

    public static function list()
    {
        return Semester::all();
    }
}
