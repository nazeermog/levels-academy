<?php

namespace DataSource\Http\Controllers\Admin\Inrollment;

use Illuminate\Http\Request;
use DataSource\Entities\User\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use DataSource\Entities\Student\Student;
use DataSource\Http\Controllers\BaseController;
use DataSource\Http\Requests\Admin\Student\Store;
use DataSource\Http\Requests\Admin\Student\Update;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Repositories\DB\AdminInrollmentRepository;

class AdminInrollmentController extends BaseController
{
    use AdminCRUDControllerActions;

    protected string $module = 'datasource::management.Inrollment';
    protected string $table_name = 'Inrollments';
    protected string $route_name = 'inrollments';
    protected string $interface = AdminInrollmentRepository::class;
    // protected string $store_request = Store::class;
    // protected string $update_request = Update::class;


}
