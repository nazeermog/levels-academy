<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\UnauthorizedUserException;
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  String $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (Auth::guest()) {
            throw UnauthorizedUserException::notLoggedIn();
        }


        if (! Auth::user()->hasRoles($role)) {
            throw UnauthorizedUserException::forRoles($role);
        }

        return $next($request);
    }
}
