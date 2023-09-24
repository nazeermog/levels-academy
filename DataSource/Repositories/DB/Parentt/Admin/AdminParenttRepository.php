<?php

namespace DataSource\Repositories\DB\Parentt\Admin;

use Carbon\Carbon;
use DataSource\Entities\User\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataSource\Entities\Course\Course;
use DataSource\Entities\Lesson\Lesson;
use Illuminate\Support\Facades\Storage;
use DataSource\Entities\Parentt\Parentt;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminParenttRepository
{
    use AdminCRUDGenericRepository;

    protected $model = Parentt::class;

    public static function list()
    {
        return Parentt::all();
    }
    public function store($data)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            $user = new User();
            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->password = bcrypt($data['password']);
            $user->email = $data['email'];
            $user->role = 'parentt';

            $user->save();

            $parent = new Parentt;
            $parent->user_id = $user->id;
            $parent->first_name = $user->first_name;
            $parent->last_name = $user->last_name;
            $parent->save();

            $parentFinded = Parentt::where('user_id', $user->id)->first();
            $parentFinded->students()->attach($data['student_id']);

            DB::commit();

            return $parent;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    public function update($data)
    {
        DB::beginTransaction();
        try {

            $user = User::find($data['model_id']);
            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            if (!empty($data['password']) && Hash::needsRehash($data['password'])) {
                $user->password = bcrypt($data['password']);
            }
            $user->email = $data['email'];
            $user->role = 'parentt';

            $user->save();

            $parent = Parentt::where('user_id', $user->id)->first();
            $parent->user_id = $user->id;
            $parent->first_name = $user->first_name;
            $parent->last_name = $user->last_name;
            $parent->save();

            $parent->students()->detach();
            $parent->students()->attach($data['student_id']);

            DB::commit();

            return $parent;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
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
