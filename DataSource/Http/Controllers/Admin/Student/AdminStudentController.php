<?php

namespace DataSource\Http\Controllers\Admin\Student;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use DataSource\Entities\User\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\Course\Course;
use Illuminate\Support\Facades\Storage;
use DataSource\Entities\Parentt\Parentt;
use DataSource\Entities\Student\Student;
use DataSource\Entities\Organization\Organization;
use DataSource\Entities\Inrollment\Inrollment;
use DataSource\Http\Controllers\BaseController;
use DataSource\Http\Requests\Admin\Student\Store;
use DataSource\Http\Requests\Admin\Student\Update;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Repositories\DB\Student\Admin\AdminStudentRepository;

class AdminStudentController extends BaseController
{
    use AdminCRUDControllerActions;

    protected string $module = 'datasource::management.student';
    protected string $table_name = 'Students';
    protected string $route_name = 'students';
    protected string $interface = AdminStudentRepository::class;
    protected string $store_request = Store::class;
    protected string $update_request = Update::class;

    public function create()
    {
        $route_name = $this->route_name;
        $table_name = $this->table_name;
        $currentOrg = request()->attributes->get('currentOrganization');
        $organizations = Organization::when($currentOrg && Auth::user()?->role !== 'super_admin', fn($query) => $query->whereKey($currentOrg->id))
            ->orderBy('name')->get();
        return view($this->module . '.create', compact('route_name', 'table_name', 'organizations'));
    }

    public function show($user_id)
    {
        $route_name = $this->route_name;
        $table_name = $this->table_name;
        $item = $this->getRepository()->find($user_id);
        $currentOrg = request()->attributes->get('currentOrganization');
        $organizations = Organization::when($currentOrg && Auth::user()?->role !== 'super_admin', fn($query) => $query->whereKey($currentOrg->id))
            ->orderBy('name')->get();
        return view($this->module . '.show', compact('route_name', 'table_name', 'item', 'organizations'));
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
            $user->organization_id = $this->organizationId($request);
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
            $user->organization_id = $this->organizationId($request);
            // Don't change role on edit — trial students are promoted only via the
            // explicit "Promote to student" action, not by editing their details.

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
    /**
     * Upgrade a trial student (created via the register API) to a full student.
     */
    public function promote($userId)
    {
        $user = User::findOrFail($userId);

        if ($user->role !== 'trial_student') {
            return back()->withErrors(['error' => 'This account is not a trial student.']);
        }

        $user->role = 'student';
        $user->save();

        return back()->withSuccess('Trial student upgraded to a full student.');
    }

    private function organizationId(Request $request): ?int
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        return $currentOrg && Auth::user()?->role !== 'super_admin'
            ? (int) $currentOrg->id
            : ($request->input('organization_id') ?: null);
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
    public function importform()
    {
        $currentOrg = request()->attributes->get('currentOrganization');
        $organizations = Organization::when($currentOrg && Auth::user()?->role !== 'super_admin', fn($query) => $query->whereKey($currentOrg->id))
            ->orderBy('name')->get();
        return view('datasource::management.student.import', compact('organizations'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
            'organization_id' => 'required|exists:organizations,id',
        ]);

        $organizationId = $this->organizationId($request);

        $file = $request->file('file');
        $allData = [];

        if (($handle = fopen($file->getRealPath(), "r")) !== FALSE) {
            $header = fgetcsv($handle, 1000, ",");
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $allData[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        if (!$allData) {
            return back()->with('error', 'CSV file is empty or invalid.');
        }

        $exportData = [];
        DB::beginTransaction();
        try {
            foreach ($allData as $data) {
                $plainPassword = Str::random(8);

                // Create or update user
                $user = User::updateOrCreate(
                    ['email' => $data['email']], // search by email
                    [
                        'first_name' => $data['first_name'] ?? '',
                        'last_name'  => $data['last_name'] ?? '',
                        'password'   => Hash::make($plainPassword),
                        'organization_id' => $organizationId,
                    ]
                );

                // Create or update student
                Student::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'first_name' => $data['first_name'] ?? '',
                        'last_name'  => $data['last_name'] ?? '',
                        'country'    => $data['country'] ?? '',
                        'city'       => $data['city'] ?? '',
                    ]
                );

                // Collect plain password for manager export
                $exportData[] = [
                    'email'      => $data['email'],
                    'first_name' => $data['first_name'] ?? '',
                    'last_name'  => $data['last_name'] ?? '',
                    'country'    => $data['country'] ?? '',
                    'city'       => $data['city'] ?? '',
                    'password'   => $plainPassword,
                ];
            }

            // Save manager CSV
            $filename = 'students_import_' . now()->format('Y_m_d_His') . '.csv';
            $path = storage_path("app/imports/{$filename}");
            if (!is_dir(storage_path("app/imports"))) {
                mkdir(storage_path("app/imports"), 0777, true);
            }

            $handle = fopen($path, 'w');
            fputcsv($handle, array_keys($exportData[0])); // headers
            foreach ($exportData as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }

        return back()->with('success', "Students imported successfully! Manager CSV: {$filename}");
    }
}
