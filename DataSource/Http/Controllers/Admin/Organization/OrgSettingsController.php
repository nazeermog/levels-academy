<?php

namespace DataSource\Http\Controllers\Admin\Organization;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use DataSource\Entities\Organization\Organization;

class OrgSettingsController extends BaseController
{
    public function edit(Request $request)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        if (!$currentOrg) {
            // fallback via auth user
            $currentOrg = optional(auth()->user())->organization;
        }
        abort_if(!$currentOrg, 404);
        return view('datasource::management.organizations.settings', ['organization' => $currentOrg]);
    }

    public function update(Request $request)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        if (!$currentOrg) {
            $currentOrg = optional(auth()->user())->organization;
        }
        abort_if(!$currentOrg, 404);

        $data = $request->validate([
            'absence_free_hours' => 'required|integer|min:0|max:168',
        ]);

        $org = Organization::findOrFail($currentOrg->id);
        $org->absence_free_hours = (int) $data['absence_free_hours'];
        $org->save();

        return redirect()->route('admin.org.settings.edit')->with('success', 'Settings updated.');
    }
}

?>


