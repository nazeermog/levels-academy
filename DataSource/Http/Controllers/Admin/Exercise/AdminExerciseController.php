<?php

namespace DataSource\Http\Controllers\Admin\Exercise;

use Illuminate\Http\Request;
use DataSource\Entities\User\User;

use Illuminate\Support\Facades\Validator;
use DataSource\Entities\Exercise\Exercise;
use DataSource\Http\Controllers\BaseController;
use DataSource\Http\Requests\Admin\Exercise\Store;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Repositories\DB\Exercise\Admin\AdminExerciseRepository;
use DataSource\Repositories\DB\Practice\Admin\AdminPracticeRepository;
use DataSource\Repositories\DB\Practice\Admin\AdminPracticeLevelRepository;

class AdminExerciseController extends BaseController
{
    use AdminCRUDControllerActions;

    protected string $module = 'datasource::management.exercises';
    protected string $table_name = 'exercises';
    protected string $route_name = 'exercises';
    protected string $interface = AdminExerciseRepository::class;
    protected string $store_request = Store::class;
    // protected string $update_request = Update::class;

    public function create()
    {
        $route_name = $this->route_name;
        $table_name = $this->table_name;
        $practices = AdminPracticeRepository::list();
        $practiceLevels = AdminPracticeLevelRepository::list();
        return view($this->module . '.create', compact('route_name', 'table_name', 'practices', 'practiceLevels'));
    }
    
}
