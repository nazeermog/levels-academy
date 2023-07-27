<?php

namespace DataSource\Repositories\DB\ResultPractice\Admin;

use DataSource\Entities\ResultPractice\ResultPractice;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminResultPracticeRepository
{
    use AdminCRUDGenericRepository;

    protected $model = ResultPractice::class;
    

}
