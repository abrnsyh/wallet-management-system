<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function showLogin()
    {
        return view("auth.login");
    }

    public function login(LoginRequest $request)
    {

        // Check throttle per-email
        $request->ensureIsNotRateLimited();

        // Attempt login
        if (! Auth::attempt($request->only('email', 'password'), $request->remember)) {
            // Tambah attempt buruk
            $request->hitRateLimit();

            return back()
                ->withErrors(['email' => 'Email not found!'])
                ->withInput();
        }

        // Login sukses → clear throttle
        $request->clearRateLimit();

        return redirect()->intended('dashboard');

    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
