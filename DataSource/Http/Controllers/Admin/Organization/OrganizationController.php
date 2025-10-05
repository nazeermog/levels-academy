<?php

namespace DataSource\Http\Controllers\Admin\Organization;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use DataSource\Entities\Organization\Organization;

class OrganizationController extends BaseController
{
    public function index()
    {
        $organizations = Organization::orderBy('id', 'desc')->paginate(20);
        return view('datasource::management.organizations.index', compact('organizations'));
    }

    public function create()
    {
        return view('datasource::management.organizations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'subdomain' => 'required|string|max:255|unique:organizations,subdomain',
            'theme_css' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        Organization::create($data);
        return redirect()->route('admin.organizations.index')->with('status', 'Organization created');
    }

    public function edit($id)
    {
        $organization = Organization::findOrFail($id);
        return view('datasource::management.organizations.edit', compact('organization'));
    }

    public function update(Request $request, $id)
    {
        $organization = Organization::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'subdomain' => 'required|string|max:255|unique:organizations,subdomain,' . $organization->id,
            'theme_css' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        $organization->update($data);
        return redirect()->route('admin.organizations.index')->with('status', 'Organization updated');
    }

    public function destroy($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->delete();
        return redirect()->route('admin.organizations.index')->with('status', 'Organization deleted');
    }
}


