<?php

namespace Modules\ResultPractice\Http\Controllers;

use DataSource\Repositories\DB\ResultPractice\Admin\AdminResultPracticeRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class ResultPracticeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $list  = (new AdminResultPracticeRepository())->index();
        $route_name = 'result-practice';
        $table_name = 'Result Practice  ';
        return view( 'resultpractice::instructor.index', compact('list', 'route_name', 'table_name'));
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */

    public function create()
    {

    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {


    }
    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('resultpractice::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
