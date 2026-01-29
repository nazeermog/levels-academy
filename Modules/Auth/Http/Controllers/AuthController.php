<?php

namespace Modules\Auth\Http\Controllers;


use Illuminate\Http\Request;
use App\Services\UserEventLogger;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Requests\Login;

class AuthController extends Controller
{
  public function index()
  {
    if (\auth()->user())
      return redirect()->route(\auth()->user()->role . '.dashboard');

    return view('auth::login');
  }

  public function login(Login $request)
  {
    $credentials = [
      'email' => $request->validated('email'),
      'password' => $request->validated('password'),
    ];

    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
      UserEventLogger::log('login', null, 'auth');

      $currentOrg = $request->attributes->get('currentOrganization');
      if ($currentOrg) {
        $user = auth()->user();
        if ($user && $user->role !== 'super_admin' && (int) $user->organization_id !== (int) $currentOrg->id) {
          Auth::logout();
          $request->session()->invalidate();
          $request->session()->regenerateToken();
          return redirect()->route('login')->withErrors([
            'email' => 'You cannot log in to this organization.',
          ]);
        }
      }

      // Redirect to intended URL if present, otherwise role-based fallback
      $role = auth()->user()->role;
      $fallback = match ($role) {
        'student' => route('student.index.Bookexercise.books.qr'),
        'super_admin' => route('admin.dashboard'),
        'admin' => route('admin.org.dashboard'),
        'parent' => route('parent.dashboard'),
        'instructor' => route('instructor.dashboard'),
        default => route('login'),
      };
      return redirect()->intended($fallback);
    }

    return redirect()->route('login')->withErrors([
      'email' => 'The provided credentials do not match our records.',
    ]);
  }
  public function logout(Request $request)
  {
    UserEventLogger::log('logout', null, 'auth');
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
  }
}
