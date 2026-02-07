<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyProfileController extends Controller
{
    public function edit()
    {
        $companyId = auth()->user()->company_id;
        abort_if(!$companyId, 404);

        $company = Company::query()->findOrFail($companyId);

        return view('perusahaan.company.edit', compact('company'));
    }

    public function update(Request $request)
    {
        $companyId = auth()->user()->company_id;
        abort_if(!$companyId, 404);

        $company = Company::findOrFail(auth()->user()->company_id);
        $this->authorize('update', $company);


        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'industri' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:3000'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('logo')) {
            $newPath = $request->file('logo')->store('company-logos', 'public');

            if ($company->logo_path) {
                Storage::disk('public')->delete($company->logo_path);
            }

            $validated['logo_path'] = $newPath;
        }

        unset($validated['logo']);

        $company->update($validated);

        return redirect()
            ->route('perusahaan.company.edit')
            ->with('success', 'Profil perusahaan diperbarui.');
    }
}
