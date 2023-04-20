<?php

namespace DataSource\Traits\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait AdminCRUDControllerActions
{
    private $repository = null;
    private $category_repository = null;

    public function index()
    {
        $list = $this->getRepository()->index();
        $route_name = $this->route_name;
        $table_name = $this->table_name;
        return view($this->module . '.index', compact('list', 'route_name', 'table_name'));
    }

    public function create()
    {
        $route_name = $this->route_name;
        $table_name = $this->table_name;

        return view($this->module . '.create', compact('route_name', 'table_name'));
    }

    public function show($id)
    {
        $item = $this->getRepository()->find($id);
        $route_name = $this->route_name;
        $table_name = $this->table_name;
        return view($this->module . '.show', compact('item', 'route_name', 'table_name'));
    }

    public function store()
    {
        try {
            DB::beginTransaction();
            $this->getRepository()->store($this->getStoreRequest()->validated());
            DB::commit();
            return redirect()->route('admin.' . $this->route_name . '.index')->withSuccess('created successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }

    }

    public function update()
    {
        try {
            DB::beginTransaction();
            $this->getRepository()->update($this->getUpdateRequest()->validated());
            DB::commit();
            return redirect()->route('admin.' . $this->route_name . '.index')->withSuccess('Update successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $this->getRepository()->destroy($id);
            DB::commit();
            return redirect()->route('admin.' . $this->route_name . '.index')->withSuccess('deleted successfully');
        } catch (\Exception $exception) {

            DB::rollBack();
            return redirect()->route('admin.' . $this->route_name . '.index')->withErrors($exception->getMessage());
        }

    }

    public function toggleStatus(): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $this->getRepository()->toggleStatus($this->getIdRequest()->validated());
            DB::commit();
            return response()->json([
                'data' => $data,
                'status' => true,
                'message' => 'Updated successfully',
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'data' => null,
                'status' => false,
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    protected function getRepository()
    {
        if (!is_null($this->repository)) {
            return $this->repository;
        }
        $this->repository = new $this->interface(Auth::user());
        return $this->repository;
    }

    protected function getCategoriesRepository()
    {
        if (!is_null($this->category_repository)) {
            return $this->category_repository;
        }
        $this->category_repository = new $this->interface_category(Auth::user());
        return $this->category_repository;
    }

    protected function getIdRequest()
    {
        if (!isset($this->id_request)) {
            return request();
        }

        if (isset($this->id_request['id'])) {
            return resolve($this->id_request['id']);
        }

        return resolve($this->id_request);
    }

    protected function getUpdateRequest()
    {
        if (!isset($this->update_request)) {
            return request();
        }

        if (isset($this->update_request['update'])) {
            return resolve($this->update_request['update']);
        }

        return resolve($this->update_request);
    }

    protected function getStoreRequest()
    {
        if (!isset($this->store_request)) {
            return request();
        }

        if (isset($this->store_request['store'])) {
            return resolve($this->store_request['store']);
        }

        return resolve($this->store_request);
    }
}
