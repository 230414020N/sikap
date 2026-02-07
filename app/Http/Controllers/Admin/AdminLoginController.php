<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function create()
    {
        return view('admin.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return back()
                ->withErrors(['email' => 'Email atau password tidak sesuai.'])
                ->onlyInput('email');
        if (auth()->user()->role !== 'admin') {
                auth()->logout();
                return back()->withErrors([
                    'email' => 'Akun ini bukan admin.',
                ]);
            }

            return redirect()->route('admin.dashboard');

        }

        $request->session()->regenerate();

        if (auth()->user()->role !== 'admin') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors(['email' => 'Akun ini bukan akun admin.'])
                ->onlyInput('email');
        }

        return redirect()->intended(route('admin.dashboard'));
    }
}
