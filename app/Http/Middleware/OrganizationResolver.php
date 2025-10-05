<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use DataSource\Entities\Organization\Organization;

class OrganizationResolver
{
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();
        $subdomain = null;

        // Extract subdomain: e.g. yasmine.example.com => yasmine
        $parts = explode('.', $host);
        if (count($parts) > 2) {
            $subdomain = $parts[0];
        }

        $organization = null;
        if ($subdomain) {
            $organization = Organization::where('subdomain', $subdomain)->first();
        }

        // Share with all views and attach to request for downstream middleware
        View::share('currentOrganization', $organization);
        if ($organization) {
            $request->attributes->set('currentOrganization', $organization);
        }

        return $next($request);
    }
}


