<?php

namespace DataSource\Repositories\DB\Exercise\Student;

use DataSource\Entities\Course\Course;
use DataSource\Entities\Exercise\Exercise;
use Illuminate\Support\Facades\Storage;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class StudentExerciseRepository
{
    use AdminCRUDGenericRepository;

    protected $model = Exercise::class;

    public static function list()
    {
        return Exercise::all();
    }
    public static function find($id)
    {
        return Exercise::find($id);
    }
    public static function findByCode($code)
    {
        return Exercise::where('code',$code)->first();
    }
}
