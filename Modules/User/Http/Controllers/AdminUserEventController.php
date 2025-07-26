<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataSource\Entities\User\UserEvent;
use DataSource\Entities\User\User;

class AdminUserEventController extends Controller
{
    public function eventindex(Request $request)
    {
        $users = User::orderBy('first_name')->get();
        $types = UserEvent::whereNotNull('type')->distinct()->pluck('type')->filter()->values()->all();
        $roles = User::distinct()->pluck('role')->filter()->values()->all();

        $selectedUserId = $request->user_id;
        $selectedTypes = (array) $request->input('type');
        $selectedRole = $request->role;

        $query = UserEvent::with('user');

        if ($selectedRole) {
            $query->whereHas('user', function ($q) use ($selectedRole) {
                $q->where('role', $selectedRole);
            });
        }

        if ($selectedUserId) {
            $query->where('user_id', $selectedUserId);
        }

        if (!empty($selectedTypes)) {
            $query->whereIn('type', $selectedTypes);
        }

        $events = $query->latest()->paginate(10);

        return view('user::indexEvents', compact(
            'events',
            'users',
            'types',
            'roles',
            'selectedUserId',
            'selectedTypes',
            'selectedRole'
        ));
    }
}
