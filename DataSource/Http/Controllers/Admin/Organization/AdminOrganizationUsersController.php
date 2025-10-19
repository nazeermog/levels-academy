<?php

namespace DataSource\Http\Controllers\Admin\Organization;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use DataSource\Entities\User\User;

class AdminOrganizationUsersController extends BaseController
{
    public function index(Request $request)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        $users = collect();
        if ($currentOrg) {
            $users = User::query()->inOrganization($currentOrg->id)->orderBy('id', 'desc')->paginate(25);
        }

        return view('datasource::management.org_admin.users.index', compact('users', 'currentOrg'));
    }
}


