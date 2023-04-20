<?php

namespace DataSource\Repositories\DB\Practice\Admin;

use DataSource\Entities\Practice\Practice;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminPracticeRepository
{
    use AdminCRUDGenericRepository;

    protected $model = Practice::class;

    public static function list()
    {
        return Practice::all();
    }

}
