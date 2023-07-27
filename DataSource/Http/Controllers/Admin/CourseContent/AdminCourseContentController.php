<?php

namespace DataSource\Http\Controllers\Admin\CourseContent;

use DataSource\Repositories\API\Lesson\ApiLessonsRepository;
use DataSource\Repositories\DB\Course\Admin\AdminCourseContentRepository;
use DataSource\Repositories\DB\Lesson\Admin\AdminLessonRepository;
use DataSource\Repositories\DB\Practice\Admin\AdminPracticeRepository;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Http\Controllers\BaseController;
use DataSource\Http\Requests\Admin\CourseContent\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


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

        $route_name = $this->route_name;
        $table_name = $this->table_name;
        return view($this->module . '.create', compact('route_name', 'table_name', 'lessons', 'practices'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title-en' => 'required|string|max:255',
            'title-ar' => 'required|string|max:255',
            'slug-en' => 'required|string|max:255',
            'slug-ar' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $courseContentRepo = new AdminCourseContentRepository();
       // $courseContentRepo = $this->getRepository();

        //$formdata2 = $request->input('boxArr');
        $courseData = json_decode($request->input('boxArr'), true);

        // Merge the validated data with the form data
        $data = array_merge($validatedData, ['boxArr' => $courseData]);
        //dd($data);
        $course = $courseContentRepo->store($data);

        return redirect()->route('admin.courseContent.index')->withSuccess('Course created successfully');
    }





}
