<?php

namespace DataSource\Http\Controllers\Admin\CoursePath;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataSource\Http\Controllers\BaseController;

use DataSource\Http\Requests\Admin\CoursePath\Store;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Repositories\DB\Course\Admin\AdminCourseRepository;
use DataSource\Repositories\DB\Taxonomy\Admin\AdminTaxonomyRepository;
use DataSource\Repositories\DB\CoursePath\Admin\AdminCoursePathRepository;

class AdminCoursePathController extends BaseController
{
    use AdminCRUDControllerActions;

    protected string $module = 'datasource::management.CoursePath';
    protected string $table_name = 'coursePath';
    protected string $route_name = 'coursePath';
    protected string $interface = AdminCoursePathRepository::class;
    protected string $store_request = Store::class;

    public function create()
    {
        $taxonomies = AdminTaxonomyRepository::list();
        $courses = AdminCourseRepository::list();
        $route_name = $this->route_name;
        $table_name = $this->table_name;
        return view($this->module . '.create', compact('route_name', 'table_name','taxonomies', 'courses', 'taxonomies'));
    }
    public function store(Request $request)
    {
        $storeRequest = new Store();
        $data = $request->validate($storeRequest->rules());

        $coursepathRepo = $this->getRepository();


        //dd($data);
        $course = $coursepathRepo->store($request,$data);

        return redirect()->route('admin.coursePath.index')->withSuccess('Course created successfully');
    }
}
