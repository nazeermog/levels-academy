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

      $intended = session()->pull('url.intended');

      if ($intended) {
        return redirect()->to($intended);
      }

      switch (auth()->user()->role) {
        case 'student':
          return redirect()->route('student.index.Bookexercise.pages.qr');
        case 'super_admin':
          return redirect()->route('admin.dashboard');
        case 'admin':
          return redirect()->route('admin.org.dashboard');
        case 'parent':
          return redirect()->route('parent.dashboard');
        default:
          return redirect()->route('login');
      }
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
