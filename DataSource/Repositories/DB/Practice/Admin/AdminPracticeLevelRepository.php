<?php

namespace DataSource\Repositories\DB\Practice\Admin;

use DataSource\Entities\PracticeLevel\PracticeLevel;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminPracticeLevelRepository
{
    use AdminCRUDGenericRepository;

    protected $model = PracticeLevel::class;

    public static function list()
    {
        return PracticeLevel::all();
    }

}
