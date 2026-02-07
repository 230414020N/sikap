<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class AdminCompanyController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $verified = (string) $request->query('verified', 'all');
        $active = (string) $request->query('active', 'all');

        $companies = Company::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    if (Schema::hasColumn('companies', 'nama')) {
                        $sub->orWhere('nama', 'like', "%{$q}%");
                    }
                    if (Schema::hasColumn('companies', 'industri')) {
                        $sub->orWhere('industri', 'like', "%{$q}%");
                    }
                });
            })
            ->when($verified !== 'all', function ($query) use ($verified) {
                $query->where('is_verified', $verified === 'verified');
            })
            ->when($active !== 'all', function ($query) use ($active) {
                $query->where('is_active', $active === 'active');
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.companies.index', compact('companies', 'q', 'verified', 'active'));
    }

    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $rules = [
            'is_verified' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'verification_note' => ['nullable', 'string', 'max:255'],
        ];

        if (Schema::hasColumn('companies', 'nama')) {
            $rules['nama'] = ['nullable', 'string', 'max:255'];
        }
        if (Schema::hasColumn('companies', 'industri')) {
            $rules['industri'] = ['nullable', 'string', 'max:255'];
        }
        if (Schema::hasColumn('companies', 'alamat')) {
            $rules['alamat'] = ['nullable', 'string'];
        }
        if (Schema::hasColumn('companies', 'deskripsi')) {
            $rules['deskripsi'] = ['nullable', 'string'];
        }

        $validated = $request->validate($rules);

        $payload = collect($validated)->only([
            'nama', 'industri', 'alamat', 'deskripsi', 'verification_note',
        ])->toArray();

        $isVerified = $request->has('is_verified') ? $request->boolean('is_verified') : $company->is_verified;
        $isActive = $request->has('is_active') ? $request->boolean('is_active') : $company->is_active;

        $payload['is_verified'] = $isVerified;
        $payload['is_active'] = $isActive;

        if ($isVerified) {
            $payload['verified_at'] = $company->verified_at ?? now();
            $payload['verified_by'] = auth()->id();
        } else {
            $payload['verified_at'] = null;
            $payload['verified_by'] = null;
        }

        $company->update($payload);

        return redirect()->route('admin.companies.index')->with('success', 'Perusahaan diperbarui.');
    }

    public function verify(Request $request, Company $company)
    {
        $request->validate([
            'verification_note' => ['nullable', 'string', 'max:255'],
        ]);

        $company->update([
            'is_verified' => true,
            'verified_at' => now(),
            'verified_by' => auth()->id(),
            'verification_note' => $request->input('verification_note'),
        ]);

        return redirect()->back()->with('success', 'Perusahaan diverifikasi.');
    }

    public function unverify(Request $request, Company $company)
    {
        $request->validate([
            'verification_note' => ['nullable', 'string', 'max:255'],
        ]);

        $company->update([
            'is_verified' => false,
            'verified_at' => null,
            'verified_by' => null,
            'verification_note' => $request->input('verification_note'),
        ]);

        return redirect()->back()->with('success', 'Status verifikasi dibatalkan.');
    }

    public function toggleActive(Company $company)
    {
        $company->update([
            'is_active' => !$company->is_active,
        ]);

        return redirect()->back()->with('success', 'Status aktif diperbarui.');
    }

    public function destroy(Company $company)
    {
        $hasUsers = User::query()->where('company_id', $company->id)->exists();
        $hasJobs = Job::query()->where('company_id', $company->id)->exists();

        if ($hasUsers || $hasJobs) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus: masih ada data terkait (akun atau lowongan).');
        }

        $company->delete();

        return redirect()->route('admin.companies.index')->with('success', 'Perusahaan dihapus.');
    }
}
