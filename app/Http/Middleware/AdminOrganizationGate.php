<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminOrganizationGate
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        // Super admin bypasses org restrictions
        if ($user->role === 'super_admin') {
            return $next($request);
        }

        // Regular admin must belong to the current organization
        $currentOrg = $request->attributes->get('currentOrganization');
        if ($user->role === 'admin') {
            if ($currentOrg && (int) $user->organization_id === (int) $currentOrg->id) {
                return $next($request);
            }
            abort(403, 'You are not authorized for this organization.');
        }

        abort(403, 'Unauthorized.');
    }
}


