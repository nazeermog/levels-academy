<?php

namespace Modules\Auth\Http\Controllers;


use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Requests\Login;

class AuthController extends Controller
{
    public function index()
    {
        if (\auth()->user()) {
            return redirect()->route(\auth()->user()->role . '.dashboard');
        }
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
            return redirect()->route(\auth()->user()->role . '.dashboard');
        }

    }
}
