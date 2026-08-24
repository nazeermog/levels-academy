<?php

namespace DataSource\Http\Controllers\Admin\Parentt;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\Student\Student;
use DataSource\Entities\Organization\Organization;
use DataSource\Http\Controllers\BaseController;
use DataSource\Http\Requests\Admin\Parentt\Store;
use DataSource\Http\Requests\Admin\Parentt\Update;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Repositories\DB\Parentt\Admin\AdminParenttRepository;

class AdminParenttController extends BaseController
{
    use AdminCRUDControllerActions;

    protected string $module = 'datasource::management.parentt';
    protected string $table_name = 'Parentts';
    protected string $route_name = 'parentts';
    protected string $interface = AdminParenttRepository::class;
    protected string $store_request = Store::class;
    protected string $update_request = Update::class;

    public function create()
    {
        $currentOrg = request()->attributes->get('currentOrganization');
        $students = Student::when($currentOrg && Auth::user()?->role !== 'super_admin', fn($query) => $query->whereHas('user', fn($userQuery) => $userQuery->where('organization_id', $currentOrg->id)))->get();
        $organizations = Organization::when($currentOrg && Auth::user()?->role !== 'super_admin', fn($query) => $query->whereKey($currentOrg->id))->orderBy('name')->get();
        $route_name = $this->route_name;
        $table_name = $this->table_name;
        return view($this->module . '.create', compact('route_name', 'table_name', 'students', 'organizations'));
    }
    public function show($user_id)
    {
        $currentOrg = request()->attributes->get('currentOrganization');
        $students = Student::when($currentOrg && Auth::user()?->role !== 'super_admin', fn($query) => $query->whereHas('user', fn($userQuery) => $userQuery->where('organization_id', $currentOrg->id)))->get();
        $organizations = Organization::when($currentOrg && Auth::user()?->role !== 'super_admin', fn($query) => $query->whereKey($currentOrg->id))->orderBy('name')->get();
        $route_name = $this->route_name;
        $table_name = $this->table_name;
        $item = $this->getRepository()->find($user_id);
        return view($this->module . '.show', compact('route_name', 'table_name', 'students', 'organizations', 'item'));
    }

    public function store(Request $request)
    {
        $storeRequest = new Store();
        $data = $request->validate($storeRequest->rules());

        $organizationId = $this->organizationId($request);
        $studentIds = collect($data['student_id'])->map(fn($id) => (int) $id)->all();
        $validStudentCount = Student::whereIn('user_id', $studentIds)
            ->whereHas('user', fn($query) => $query->where('organization_id', $organizationId))
            ->count();
        if ($validStudentCount !== count($studentIds)) {
            return back()->withErrors(['student_id' => 'All selected students must belong to the selected organization.'])->withInput();
        }
        $data['organization_id'] = $organizationId;

        // dd($data);
        $ParentRepo = $this->getRepository();

        $ParentRepo->store($data);

        return redirect()->route('admin.parentts.index')->withSuccess('parent created successfully');
    }
    public function update(Request $request)
    {
        $storeRequest = new Update();
        $data = $request->validate($storeRequest->rules());

        $organizationId = $this->organizationId($request);
        $studentIds = collect($data['student_id'])->map(fn($id) => (int) $id)->all();
        $validStudentCount = Student::whereIn('user_id', $studentIds)
            ->whereHas('user', fn($query) => $query->where('organization_id', $organizationId))
            ->count();
        if ($validStudentCount !== count($studentIds)) {
            return back()->withErrors(['student_id' => 'All selected students must belong to the selected organization.'])->withInput();
        }
        $data['organization_id'] = $organizationId;

        // dd($data);
        $ParentRepo = $this->getRepository();

        $ParentRepo->update($data);

        return redirect()->route('admin.parentts.index')->withSuccess('parent updated successfully');
    }

    private function organizationId(Request $request): ?int
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        return $currentOrg && Auth::user()?->role !== 'super_admin'
            ? (int) $currentOrg->id
            : ($request->input('organization_id') ?: null);
    }
}
