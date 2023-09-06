<?php

namespace DataSource\Repositories\DB\Practice\Admin;

use DataSource\Entities\PracticeType\PracticeTypeDetail;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminPracticeTypeRepository
{
    use AdminCRUDGenericRepository;

    protected $model = PracticeTypeDetail::class;

    public static function list()
    {
        return PracticeTypeDetail::all();
    }

}
