<?php

namespace DataSource\Repositories\DB\Practice\Admin;

use DataSource\Entities\Practice\PracticeType;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminPracticeTypeRepository
{
    use AdminCRUDGenericRepository;

    protected $model = PracticeType::class;
}
