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
            // إذا المستخدم غير مسجل دخول، أعد توجيهه إلى صفحة تسجيل الدخول
            return redirect()->route('login');
        }

        if (! Auth::user()->hasRoles($role)) {
            switch (Auth::user()->role) {
                case 'student':
                    return redirect()->route('student.dashboard');
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'parent':
                    return redirect()->route('parent.dashboard');
                default:
                    abort(403, 'User does not have the right roles.');
            }
        }

        return $next($request);
    }
}
