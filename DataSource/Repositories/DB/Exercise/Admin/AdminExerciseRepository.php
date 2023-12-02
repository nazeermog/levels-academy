<?php

namespace DataSource\Repositories\DB\Exercise\Admin;

use DataSource\Entities\Exercise\Exercise;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminExerciseRepository
{
    use AdminCRUDGenericRepository;

    protected $model = Exercise::class;

    public static function list()
    {
        return Exercise::all();
    }

}
