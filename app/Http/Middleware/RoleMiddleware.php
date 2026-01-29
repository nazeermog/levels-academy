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
            // Redirect to the user's correct dashboard instead of 403
            switch (Auth::user()->role) {
                case 'student':
                    return redirect()->route('student.dashboard');
                case 'super_admin':
                    return redirect()->route('admin.dashboard');
                case 'admin':
                    return redirect()->route('admin.org.dashboard');
                case 'parent':
                    return redirect()->route('parent.dashboard');
                case 'instructor':
                    return redirect()->route('instructor.dashboard');
                default:
                    return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
