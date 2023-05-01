<?php

namespace DataSource\Repositories\DB\Practice\Admin;

use DataSource\Entities\Practice\PracticeTypeDetail;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminPracticeTypeRepository
{
    use AdminCRUDGenericRepository;

    protected $model = PracticeTypeDetail::class;
}
