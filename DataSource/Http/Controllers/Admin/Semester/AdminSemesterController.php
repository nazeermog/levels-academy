<?php

namespace DataSource\Http\Controllers\Admin\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataSource\Http\Controllers\BaseController;
use DataSource\Http\Requests\Admin\Semester\Store;
use DataSource\Http\Requests\Admin\Semester\Update;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Repositories\DB\Semester\Admin\AdminSemesterRepository;

class AdminSemesterController extends BaseController
{
    use AdminCRUDControllerActions;

    protected string $module = 'datasource::management.Semester';
    protected string $table_name = 'Semesters';
    protected string $route_name = 'semesters';
    protected string $interface = AdminSemesterRepository::class;
    protected string $store_request = Store::class;
    protected string $update_request = Update::class;

}
