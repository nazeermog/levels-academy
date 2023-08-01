<?php

namespace DataSource\Http\Controllers\Admin\CourseContent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataSource\Http\Controllers\BaseController;
use DataSource\Http\Requests\Admin\CourseContent\Store;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Repositories\API\Lesson\ApiLessonsRepository;
use DataSource\Repositories\DB\Lesson\Admin\AdminLessonRepository;
use DataSource\Repositories\DB\Practice\Admin\AdminPracticeRepository;
use DataSource\Repositories\DB\Taxonomy\Admin\AdminTaxonomyRepository;
use DataSource\Repositories\DB\Course\Admin\AdminCourseContentRepository;


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

    public function create()
    {
        $lessons = AdminLessonRepository::list();
        $practices = AdminPracticeRepository::list();
        $taxonomies = AdminTaxonomyRepository::list();

        $route_name = $this->route_name;
        $table_name = $this->table_name;
        return view($this->module . '.create', compact('route_name', 'table_name','taxonomies', 'lessons', 'practices'));
    }
    public function store(Request $request)
    {
        $storeRequest = new Store();
        $validatedData = $request->validate($storeRequest->rules());

        $courseContentRepo = $this->getRepository();

        $courseData = json_decode($request->input('boxArr'), true);

        $data = array_merge($validatedData, ['boxArr' => $courseData]);
        //dd($data);
        $course = $courseContentRepo->store($request,$data);

        return redirect()->route('admin.courseContent.index')->withSuccess('Course created successfully');
    }
    
  
    





}
