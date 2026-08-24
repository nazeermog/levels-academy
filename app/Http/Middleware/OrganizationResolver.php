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
            // Brand the whole request as this org: everything using config('app.name')
            // (page titles, meta, etc.) then renders the org name instead of "Levels Academy".
            if ($organization->name) {
                config(['app.name' => $organization->name]);
            }
        }

        // Brand logo + name available to every view (favicons, layouts) — the org's
        // logo on an org subdomain, the Levels logo otherwise.
        View::share('brandLogo', $organization
            ? asset('images/logo/' . $organization->subdomain . '.png')
            : asset('images/logo/Levels-logo.png'));
        View::share('brandName', $organization && $organization->name
            ? $organization->name
            : config('app.name', 'Levels Academy'));

        return $next($request);
    }
}


