<?php

namespace DataSource\Http\Controllers\Admin\Student;

use Illuminate\Http\Request;
use DataSource\Entities\User\User;
use Illuminate\Support\Facades\DB;
use DataSource\Entities\Course\Course;
use Illuminate\Support\Facades\Storage;
use DataSource\Entities\Student\Student;
use DataSource\Entities\Inrollment\Inrollment;
use DataSource\Entities\Parentt\Parentt;
use DataSource\Http\Controllers\BaseController;
use DataSource\Http\Requests\Admin\Student\Store;
use DataSource\Http\Requests\Admin\Student\Update;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Repositories\DB\Student\Admin\AdminStudentRepository;

class AdminStudentController extends BaseController
{
    use AdminCRUDControllerActions;

    protected string $module = 'datasource::management.Student';
    protected string $table_name = 'Students';
    protected string $route_name = 'students';
    protected string $interface = AdminStudentRepository::class;
    protected string $store_request = Store::class;
    protected string $update_request = Update::class;

    public function create()
    {
        $route_name = $this->route_name;
        $table_name = $this->table_name;
        return view($this->module . '.create', compact('route_name', 'table_name'));
    }

    public function show($user_id)
    {
        $route_name = $this->route_name;
        $table_name = $this->table_name;
        $item = $this->getRepository()->find($user_id);
        return view($this->module . '.show', compact('route_name', 'table_name', 'item'));
    }

    public function store(Request $request)
    {
        $storeRequest = new Store();
        $request->validate($storeRequest->rules()); // Validate but don't assign to $data

        DB::beginTransaction();

        try {
            $user = new User();
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->role = 'student';
            $user->save();

            $student = new Student();
            $student->user_id = $user->id;
            $student->first_name = $user->first_name;
            $student->last_name = $user->last_name;
            $student->city = $request->input('city');
            $student->country = $request->input('country');

            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('public/photos');
                $student->avatar = Storage::url($avatarPath);
            }

            $student->save();

            DB::commit();

            return redirect()->route('admin.students.index')->withSuccess('Student created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Something went wrong!']);
        }
    }
    public function update(Request $request)
    {
        $updateRequest = new Update();
        $request->validate($updateRequest->rules()); // Validate only

        DB::beginTransaction();

        try {
            $user = User::findOrFail($request->input('model_id'));
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->role = 'student';

            if (!empty($request->input('password'))) {
                $user->password = bcrypt($request->input('password'));
            }
            $user->save();

            $student = Student::where('user_id', $user->id)->firstOrFail();
            $student->first_name = $user->first_name;
            $student->last_name = $user->last_name;
            $student->city = $request->input('city');
            $student->country = $request->input('country');

            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('public/photos');
                $student->avatar = Storage::url($avatarPath);
            }

            $student->save();

            DB::commit();

            return redirect()->route('admin.students.index')->withSuccess('Student updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Something went wrong during update!']);
        }
    }
    public function tiles()
    {
        $studentsCount = Student::count();
        $coursesCount = Course::count();
        $parents = Parentt::count();
        $inrollmentsCount = Inrollment::count();
        $completedEnrollments = Inrollment::where('progress_lesson', 100)->count();
        $ongoingEnrollments = Inrollment::where('progress_lesson', '<', 100)->count();

        return view('datasource::management.student.tiles', compact(
            'studentsCount',
            'coursesCount',
            'parents',
            'inrollmentsCount',
            'completedEnrollments',
            'ongoingEnrollments'
        ));
    }
}
