<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        if (!$user || !$user->company_id) {
            abort(403);
        }

        $company = Company::query()->findOrFail($user->company_id);

        return view('perusahaan.company.edit', compact('company'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        if (!$user || !$user->company_id) {
            abort(403);
        }

        $company = Company::query()->findOrFail($user->company_id);

        $validated = $request->validate([
            'nama' => ['nullable', 'string', 'max:255'],
            'industri' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $company->update($validated);

        return redirect()
            ->route('perusahaan.company.edit')
            ->with('success', 'Profil perusahaan berhasil diperbarui.');
    }
}
