<?php

namespace DataSource\Http\Controllers\Admin\Practice;

use DataSource\Http\Controllers\BaseController;
use DataSource\Http\Requests\Admin\PracticeType\Store;
use DataSource\Repositories\DB\Practice\Admin\AdminPracticeTypeRepository;
use DataSource\Traits\Admin\AdminCRUDControllerActions;

class AdminPracticeTypeController extends BaseController
{
    use AdminCRUDControllerActions;

    protected string $module = 'datasource::management.practiceType';
    protected string $table_name = 'Practices Type';
    protected string $route_name = 'practicesType';
    protected string $interface = AdminPracticeTypeRepository::class;
    protected string $store_request = Store::class;
//    protected string $update_request = Update::class;
//    protected $id_request = Id::class;
}
