<?php

namespace DataSource\Http\Controllers\Admin\Instructor;

use Illuminate\Http\Request;

use DataSource\Entities\User\User;
use DataSource\Http\Controllers\BaseController;
use DataSource\Http\Requests\Admin\Instructor\Store;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Repositories\DB\Instructor\Admin\AdminInstructorRepository;

class AdminInstructorController extends BaseController
{
    use AdminCRUDControllerActions;

    protected string $module = 'datasource::management.Instructors';
    protected string $table_name = 'instructors';
    protected string $route_name = 'instructors';
    protected string $interface = AdminInstructorRepository::class;
    // protected string $store_request = Store::class;
    public function create()
    {
        $users = User::all();
        $route_name = $this->route_name;
        $table_name = $this->table_name;
        return view($this->module . '.create', compact('route_name', 'table_name','users'));
    }
    
    public function store(Request $request)
    {
        $storeRequest = new Store();
        $data = $request->validate($storeRequest->rules());

        $lessonRepo = $this->getRepository();


        //dd($data);
        $course = $lessonRepo->store($request,$data);

        return redirect()->route('admin.instructors.index')->withSuccess('instructor created successfully');
    }
}
