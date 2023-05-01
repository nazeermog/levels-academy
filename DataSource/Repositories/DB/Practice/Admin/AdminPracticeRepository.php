<?php

namespace DataSource\Repositories\DB\Practice\Admin;

use DataSource\Entities\Practice\PracticeType;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminPracticeRepository
{
    use AdminCRUDGenericRepository;

    protected $model = PracticeType::class;

    public static function list()
    {
        return PracticeType::all();
    }

}
