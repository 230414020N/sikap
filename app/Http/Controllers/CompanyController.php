<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function edit()
    {
        $company = auth()->user()->company;
        return view('hrd.company.edit', compact('company'));
    }

    public function update(Request $request)
    {
        $company = auth()->user()->company;

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'industri' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string|max:3000',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($company->logo_path) {
                Storage::delete($company->logo_path);
            }
            $validated['logo_path'] = $request->file('logo')->store('company_logos');
        }

        $company->update($validated);

        return back()->with('success', 'Profil perusahaan diperbarui!');
    }
}
