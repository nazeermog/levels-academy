<?php

namespace DataSource\Http\Controllers\Admin\Parentt;

use Illuminate\Http\Request;
use DataSource\Entities\Student\Student;
use DataSource\Http\Controllers\BaseController;
use DataSource\Http\Requests\Admin\Parentt\Store;
use DataSource\Http\Requests\Admin\Parentt\Update;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Repositories\DB\Parentt\Admin\AdminParenttRepository;

class AdminParenttController extends BaseController
{
    use AdminCRUDControllerActions;

    protected string $module = 'datasource::management.Parentt';
    protected string $table_name = 'Parentts';
    protected string $route_name = 'parentts';
    protected string $interface = AdminParenttRepository::class;
    protected string $store_request = Store::class;
    protected string $update_request = Update::class;

    public function create()
    {
        $students = Student::all();
        $route_name = $this->route_name;
        $table_name = $this->table_name;
        return view($this->module . '.create', compact('route_name', 'table_name','students'));
    }
    public function show($user_id)
    {
        $students = Student::all();
        $route_name = $this->route_name;
        $table_name = $this->table_name;
        $item= $this->getRepository()->find($user_id);
        return view($this->module . '.show', compact('route_name', 'table_name','students','item'));
    }

    public function store(Request $request)
    {
        $storeRequest = new Store();
        $data = $request->validate($storeRequest->rules());        

        // dd($data);
        $ParentRepo = $this->getRepository();

        $ParentRepo->store($data);

        return redirect()->route('admin.parentts.index')->withSuccess('parent created successfully');
    }
    public function update(Request $request)
    {
        $storeRequest = new Update();
        $data = $request->validate($storeRequest->rules());        

        // dd($data);
        $ParentRepo = $this->getRepository();

        $ParentRepo->update($data);

        return redirect()->route('admin.parentts.index')->withSuccess('parent updated successfully');
    }
    

}
