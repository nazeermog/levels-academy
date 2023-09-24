<?php

namespace Modules\PracticeType\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;
use DataSource\Http\Requests\Admin\PracticeType\Store;
use DataSource\Http\Requests\Admin\PracticeType\Update;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Repositories\DB\Practice\Admin\AdminPracticeRepository;
use DataSource\Repositories\DB\Practice\Admin\AdminPracticeTypeRepository;
use DataSource\Repositories\DB\Practice\Admin\AdminPracticeLevelRepository;


class PracticeController extends Controller
{
    use AdminCRUDControllerActions;

    protected string $module = 'datasource::management.practice';
    protected string $table_name = 'practice_details';
    protected string $route_name = 'practice-details';
    protected string $interface = AdminPracticeTypeRepository::class;
//    protected string $interface_category = AdminCategoryRepository::class;
    protected string $store_request = Store::class;
    protected string $update_request = Update::class;
//    protected $id_request = Id::class;
    public function index()
    {
        $list  = (new AdminPracticeTypeRepository())->index();
        $route_name = 'practice-details';
        $table_name = 'Practice Type Details';
        return view( 'practicetype::instructor.practiceTypeDetails.index', compact('list', 'route_name', 'table_name'));
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */

    public function create()
    {
        $route_name = 'practice-details';
        $table_name = 'Practice Type Details';
        $practices = AdminPracticeRepository::list();
        $practiceLevels=AdminPracticeLevelRepository::list();
        return view('practicetype::instructor.practiceTypeDetails.create', compact('route_name', 'table_name', 'practices','practiceLevels'));
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $route_name = 'practice-details';
        try {
            DB::beginTransaction();
            (new AdminPracticeTypeRepository())->store($request->all());
            DB::commit();
            return redirect()->route('instructor.' .$route_name . '.index')->withSuccess('created successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }

    }
    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $item = (new AdminPracticeTypeRepository())->find($id);
        $route_name = 'practice-details';
        $table_name = 'Practice Type Details';
        $practices = AdminPracticeRepository::list();
        $practiceLevels=AdminPracticeLevelRepository::list();
        return view('practicetype::instructor.practiceTypeDetails.show', compact('item', 'route_name', 'table_name', 'practices','practiceLevels'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('practicetype::edit');
    }
    public function update()
    {
        try {
            DB::beginTransaction();
            $this->getRepository()->update($this->getUpdateRequest()->validated());
            DB::commit();
            return redirect()->route('instructor.' . $this->route_name . '.index')->withSuccess('Update successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }

}
