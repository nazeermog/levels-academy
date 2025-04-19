<?php

namespace DataSource\Repositories\DB\Student\Admin;

use DataSource\Entities\User\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use DataSource\Entities\Student\Student;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminStudentRepository
{
    use AdminCRUDGenericRepository;

    protected $model = Student::class;

    public static function list()
    {
        return Student::all();
    }
    public function index()
    {
        return $this->getModel()->orderBy('user_id', 'desc')->paginate(20);
    }

    public function destroy($user_id)
    {
        return $this->getModel()->destroy($user_id);
    }
}
