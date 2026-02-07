<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HrdAuthController extends Controller
{
    public function showRegister()
    {
        return view('hrd.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'company_nama' => ['required', 'string', 'max:120'],
            'company_email' => ['nullable', 'email', 'max:150'],
            'company_no_hp' => ['nullable', 'string', 'max:30'],
            'company_alamat' => ['nullable', 'string', 'max:255'],

            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:72', 'confirmed'],
        ]);

        $company = Company::create([
            'nama' => $validated['company_nama'],
            'email' => $validated['company_email'] ?? null,
            'no_hp' => $validated['company_no_hp'] ?? null,
            'alamat' => $validated['company_alamat'] ?? null,
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'hrd',
            'company_id' => $company->id,
        ]);

        Auth::login($user);

        return redirect()->route('hrd.company.profile.edit');
    }

    public function showLogin()
    {
        return view('hrd.auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], true)) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        if ((auth()->user()->role ?? null) !== 'hrd') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors(['email' => 'Akun ini bukan akun HRD/perusahaan.'])->onlyInput('email');
        }

        return redirect()->route('hrd.dashboard');
    }
}
