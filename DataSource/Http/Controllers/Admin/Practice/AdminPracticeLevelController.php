<?php

namespace DataSource\Http\Controllers\Admin\Practice;

use DataSource\Http\Controllers\BaseController;
use DataSource\Http\Requests\Admin\Practice\Store;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Repositories\DB\Practice\Admin\AdminPracticeLevelRepository;

class AdminPracticeLevelController  extends BaseController
{
    use AdminCRUDControllerActions;

    protected string $module = 'datasource::management.PracticeLevel';
    protected string $table_name = 'practice_levels';
    protected string $route_name = 'Practiceslevels';
    protected string $interface = AdminPracticeLevelRepository::class;
//    protected string $interface_category = AdminCategoryRepository::class;
    protected string $store_request = Store::class;
//    protected string $update_request = Update::class;
//    protected $id_request = Id::class;
}
