<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HrdCompanyProfileController extends Controller
{
    public function edit()
    {
        $company = auth()->user()->company;

        abort_if(!$company, 404);

        return view('hrd.company.profile', compact('company'));
    }

    public function update(Request $request)
    {
        $company = auth()->user()->company;

        abort_if(!$company, 404);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:150'],
            'no_hp' => ['nullable', 'string', 'max:30'],
            'website' => ['nullable', 'string', 'max:150'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:5000'],
            'industri' => ['nullable', 'string', 'max:120'],
            'ukuran' => ['nullable', 'string', 'max:80'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('logo')) {
            if ($company->logo_path) {
                Storage::disk('public')->delete($company->logo_path);
            }

            $validated['logo_path'] = $request->file('logo')->store('companies/logos', 'public');
        }

        unset($validated['logo']);

        $company->update($validated);

        return back()->with('success', 'Profil perusahaan berhasil diperbarui.');
    }
}
