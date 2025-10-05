<?php

namespace DataSource\Http\Controllers\Admin\Organization;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use DataSource\Entities\User\User;
use DataSource\Entities\Student\Student;
use DataSource\Entities\Instructor\Instructor;

class OrgAdminDashboardController extends BaseController
{
    public function index(Request $request)
    {
        $org = $request->attributes->get('currentOrganization');
        $stats = [
            'users' => 0,
            'students' => 0,
            'instructors' => 0,
        ];
        if ($org) {
            $stats['users'] = User::where('organization_id', $org->id)->count();
            $stats['students'] = Student::whereHas('user', function ($q) use ($org) {
                $q->where('organization_id', $org->id);
            })->count();
            $stats['instructors'] = Instructor::whereHas('user', function ($q) use ($org) {
                $q->where('organization_id', $org->id);
            })->count();
        }

        return view('datasource::management.org_admin.dashboard', compact('org', 'stats'));
    }
}


