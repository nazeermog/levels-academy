<?php

namespace DataSource\Http\Controllers\Admin\Classroom;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use DataSource\Entities\Classroom\ClassSessionType;

class AdminClassSessionTypeController extends BaseController
{
    public function index(Request $request)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        $types = ClassSessionType::when($currentOrg, fn($q) => $q->inOrganization($currentOrg->id))
            ->orderBy('name')
            ->paginate(20);
        return view('datasource::management.class_session_types.index', compact('types', 'currentOrg'));
    }

    public function create(Request $request)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        return view('datasource::management.class_session_types.create', compact('currentOrg'));
    }

    public function store(Request $request)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);
        ClassSessionType::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'organization_id' => $currentOrg ? $currentOrg->id : null,
        ]);
        return redirect()->route('admin.org.class_session_types.index')->with('success', 'Type created.');
    }

    public function edit(Request $request, ClassSessionType $class_session_type)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        if ($currentOrg && (int) $class_session_type->organization_id !== (int) $currentOrg->id) {
            abort(403);
        }
        return view('datasource::management.class_session_types.edit', [
            'type' => $class_session_type,
            'currentOrg' => $currentOrg,
        ]);
    }

    public function update(Request $request, ClassSessionType $class_session_type)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        if ($currentOrg && (int) $class_session_type->organization_id !== (int) $currentOrg->id) {
            abort(403);
        }
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);
        $class_session_type->update($data);
        return redirect()->route('admin.org.class_session_types.index')->with('success', 'Type updated.');
    }

    public function destroy(Request $request, ClassSessionType $class_session_type)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        if ($currentOrg && (int) $class_session_type->organization_id !== (int) $currentOrg->id) {
            abort(403);
        }
        $class_session_type->delete();
        return redirect()->route('admin.org.class_session_types.index')->with('success', 'Type deleted.');
    }
}


