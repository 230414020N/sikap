<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class CompanyRegistrationController extends Controller
{
    public function create(): View
    {
        return view('perusahaan.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // data perusahaan
            'company_nama'     => ['required', 'string', 'max:255'],
            'company_industri' => ['nullable', 'string', 'max:255'],
            'company_website'  => ['nullable', 'string', 'max:255'],
            'company_lokasi'   => ['nullable', 'string', 'max:255'],
            'company_deskripsi'=> ['nullable', 'string', 'max:3000'],

            // data akun perusahaan (admin perusahaan)
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = DB::transaction(function () use ($validated) {
            $company = Company::create([
                'nama'     => $validated['company_nama'],
                'industri' => $validated['company_industri'] ?? null,
                'website'  => $validated['company_website'] ?? null,
                'lokasi'   => $validated['company_lokasi'] ?? null,
                'deskripsi'=> $validated['company_deskripsi'] ?? null,
            ]);

            return User::create([
                'name'       => $validated['name'],
                'email'      => $validated['email'],
                'password'   => Hash::make($validated['password']),
                'role'       => 'perusahaan',
                'company_id' => $company->id,
            ]);
        });

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('perusahaan.dashboard');
    }
}
