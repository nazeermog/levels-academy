<?php

namespace DataSource\Http\Controllers\Admin\ResultPractice;

use DataSource\Http\Controllers\BaseController;
use DataSource\Repositories\DB\ResultPractice\Admin\AdminResultPracticeRepository;
use DataSource\Traits\Admin\AdminCRUDControllerActions;

class AdminResultPracticeController extends BaseController
{
    use AdminCRUDControllerActions;

    protected string $module = 'datasource::management.resultPractice';
    protected string $table_name = 'Result Practices';
    protected string $route_name = 'resultPractices';
    protected string $interface = AdminResultPracticeRepository::class;
//    protected string $interface_category = AdminCategoryRepository::class;
//    protected string $store_request = Store::class;
//    protected string $update_request = Update::class;
//    protected $id_request = Id::class;
}
