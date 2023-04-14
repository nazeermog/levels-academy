<?php

namespace DataSource\Http\Controllers\Admin\CourseContent;

use DataSource\Repositories\DB\Course\Admin\AdminCourseContentRepository;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Http\Controllers\BaseController;
use DataSource\Http\Requests\Admin\CourseContent\Store;


class AdminCourseContentController extends BaseController
{
    use AdminCRUDControllerActions;

    protected string $module = 'datasource::management.courseContent';
    protected string $table_name = 'CourseContent';
    protected string $route_name = 'courseContent';
    protected string $interface = AdminCourseContentRepository::class;
//    protected string $interface_category = AdminCategoryRepository::class;
    protected string $store_request = Store::class;
//    protected string $update_request = Update::class;
//    protected $id_request = Id::class;

}
