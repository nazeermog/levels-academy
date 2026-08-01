<?php

namespace DataSource\Http\Controllers\Admin\CourseContent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataSource\Entities\Course\CourseStep;
use DataSource\Entities\Course\CourseContent;
use DataSource\Entities\Classroom\ClassSession;
use DataSource\Entities\Instructor\Instructor;
use DataSource\Entities\Worksheet\Worksheet;
use DataSource\Entities\Link\Link;
use DataSource\Http\Controllers\BaseController;
use DataSource\Http\Requests\Admin\CourseContent\Store;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Http\Requests\Admin\CourseContent\update;
use DataSource\Repositories\API\Lesson\ApiLessonsRepository;
use DataSource\Repositories\DB\Lesson\Admin\AdminLessonRepository;
use DataSource\Repositories\DB\Practice\Admin\AdminPracticeRepository;
use DataSource\Repositories\DB\Taxonomy\Admin\AdminTaxonomyRepository;
use DataSource\Repositories\DB\Course\Admin\AdminCourseContentRepository;
use DataSource\Repositories\DB\Practice\Admin\AdminPracticeTypeRepository;


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
        $practices = AdminPracticeTypeRepository::list();
        $taxonomies = AdminTaxonomyRepository::list();
        $instructors = Instructor::all();
        $sessions = $this->classSessionsForBuilder();
        $worksheets = $this->worksheetsForBuilder();
        $links = $this->linksForBuilder();

        $route_name = $this->route_name;
        $table_name = $this->table_name;
        return view($this->module . '.create', compact('route_name', 'table_name','taxonomies', 'lessons', 'practices','instructors','sessions','worksheets','links'));
    }
    
    public function show($courseId)
    {
        $lessons = AdminLessonRepository::list();
        $practices = AdminPracticeTypeRepository::list();
        $taxonomies = AdminTaxonomyRepository::list();
        $instructors = Instructor::all();
        $sessions = $this->classSessionsForBuilder();
        $worksheets = $this->worksheetsForBuilder();
        $links = $this->linksForBuilder();
        $item=$this->getRepository()->find($courseId);

        $route_name = $this->route_name;
        $table_name = $this->table_name;
        return view($this->module . '.show', compact('item','route_name', 'table_name','taxonomies', 'lessons', 'practices','instructors','sessions','worksheets','links'));
    }

    /**
     * Class sessions offered as a source list for classroom-type steps in the builder.
     */
    /**
     * Active worksheets offered as a source list for any step in the builder.
     */
    private function worksheetsForBuilder()
    {
        return Worksheet::active()->orderBy('title')->get();
    }

    /**
     * Saved links offered as a source list for any step in the builder.
     */
    private function linksForBuilder()
    {
        return Link::orderBy('title')->get();
    }

    private function classSessionsForBuilder()
    {
        return ClassSession::normal()
            ->with(['classroom', 'instructor', 'sessionType'])
            ->orderByDesc('held_at')
            ->get();
    }
    public function update(Request $request,$courseId)
    {
        $storeRequest = new update();
        $validatedData = $request->validate($storeRequest->rules());

        $courseContentRepo = $this->getRepository();

        $courseData = json_decode($request->input('boxArr'), true);

        $data = array_merge($validatedData, ['boxArr' => $courseData]);
        // dd($data);
        $course = $courseContentRepo->update($request,$data,$courseId);

        return redirect()->route('admin.courseContent.index')->withSuccess('Course created successfully');
    }
    public function store(Request $request)
    {
        $storeRequest = new Store();
        $validatedData = $request->validate($storeRequest->rules());

        $courseContentRepo = $this->getRepository();

        $courseData = json_decode($request->input('boxArr'), true);

        $data = array_merge($validatedData, ['boxArr' => $courseData]);
        // dd($data);
        $course = $courseContentRepo->store($request,$data);

        return redirect()->route('admin.courseContent.index')->withSuccess('Course created successfully');
    }
  
    
    
  
    





}
