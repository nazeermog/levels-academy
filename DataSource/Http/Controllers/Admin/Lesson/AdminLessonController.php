<?php

namespace DataSource\Http\Controllers\Admin\Lesson;

use Illuminate\Http\Request;
use DataSource\Http\Controllers\BaseController;
use DataSource\Http\Requests\Admin\Lesson\Store;
use DataSource\Http\Requests\Admin\Lesson\Update;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Repositories\DB\Lesson\Admin\AdminLessonRepository;

class AdminLessonController  extends BaseController
{
    use AdminCRUDControllerActions;

    protected string $module = 'datasource::management.lessons';
    protected string $table_name = 'lessons';
    protected string $route_name = 'lessons';
    protected string $interface = AdminLessonRepository::class;
//    protected string $interface_category = AdminCategoryRepository::class;
    protected string $store_request = Store::class;
//    protected string $update_request = Update::class;
//    protected $id_request = Id::class;

    public function store(Request $request)
    {
        $storeRequest = new Store();
        $data = $request->validate($storeRequest->rules());

        $lessonRepo = $this->getRepository();


        //dd($data);
        $course = $lessonRepo->store($request,$data);

        return redirect()->route('admin.lessons.index')->withSuccess('Course created successfully');
    }
    public function update(Request $request)
    {
        $storeRequest = new Update();
        $data = $request->validate($storeRequest->rules());
        $lessonRepo = $this->getRepository();
        $lessonRepo->update($request,$data);
        
        return redirect()->route('admin.lessons.index')->withSuccess('Course created successfully');
    }

}
