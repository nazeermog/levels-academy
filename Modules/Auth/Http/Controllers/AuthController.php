<?php

namespace Modules\Auth\Http\Controllers;


use Illuminate\Http\Request;
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
      return redirect()->route(auth()->user()->role . '.dashboard');
    }
    return redirect()->route('login')->withErrors([
      'email' => 'The provided credentials do not match our records.',
    ]);
  }
  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
  }
}
