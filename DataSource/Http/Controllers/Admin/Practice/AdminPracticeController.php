<?php

namespace DataSource\Http\Controllers\Admin\Practice;

use DataSource\Http\Controllers\BaseController;
use DataSource\Http\Requests\Admin\Practice\Store;
use DataSource\Http\Requests\Admin\Practice\Update;
use DataSource\Repositories\DB\Practice\Admin\AdminPracticeRepository;
use DataSource\Traits\Admin\AdminCRUDControllerActions;

class AdminPracticeController  extends BaseController
{
    use AdminCRUDControllerActions;

    protected string $module = 'datasource::management.practice';
    protected string $table_name = 'Practices';
    protected string $route_name = 'practices';
    protected string $interface = AdminPracticeRepository::class;
//    protected string $interface_category = AdminCategoryRepository::class;
    protected string $store_request = Store::class;
    protected string $update_request = Update::class;
//    protected $id_request = Id::class;
}
