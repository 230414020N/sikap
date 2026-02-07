<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'role' => ['nullable', 'in:pelamar,hrd,perusahaan,admin'],
            'status' => ['nullable', 'in:active,inactive'],
            'company_id' => ['nullable', 'integer', 'min:1'],
            'sort' => ['nullable', 'in:latest,oldest'],
        ]);

        $query = User::query()->with('company');

        if (!empty($validated['q'])) {
            $q = trim($validated['q']);
            $like = '%' . $this->escapeLike($q) . '%';

            $query->where(function ($w) use ($like) {
                $w->where('name', 'like', $like)
                    ->orWhere('email', 'like', $like);
            });
        }

        if (!empty($validated['role'])) {
            $query->where('role', $validated['role']);
        }

        if (!empty($validated['status'])) {
            $query->where('is_active', $validated['status'] === 'active');
        }

        if (!empty($validated['company_id'])) {
            $query->where('company_id', $validated['company_id']);
        }

        $sort = $validated['sort'] ?? 'latest';
        $query->orderBy('created_at', $sort === 'oldest' ? 'asc' : 'desc');

        $users = $query->paginate(12)->withQueryString();

        $companies = Company::query()
            ->orderBy('nama')
            ->get(['id', 'nama']);

        return view('admin.users.index', compact('users', 'companies'));
    }

    public function create()
    {
        $companies = Company::query()->orderBy('nama')->get(['id', 'nama']);
        return view('admin.users.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'role' => ['required', 'in:pelamar,hrd,perusahaan,admin'],
            'company_id' => [
                'nullable',
                'integer',
                'min:1',
                Rule::requiredIf(fn () => in_array($request->input('role'), ['hrd', 'perusahaan'], true)),
                'exists:companies,id',
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $role = $validated['role'];
        $companyId = in_array($role, ['hrd', 'perusahaan'], true) ? ($validated['company_id'] ?? null) : null;

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $role,
            'company_id' => $companyId,
            'is_active' => (bool) ($validated['is_active'] ?? true),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $companies = Company::query()->orderBy('nama')->get(['id', 'nama']);
        return view('admin.users.edit', compact('user', 'companies'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'role' => ['required', 'in:pelamar,hrd,perusahaan,admin'],
            'company_id' => [
                'nullable',
                'integer',
                'min:1',
                Rule::requiredIf(fn () => in_array($request->input('role'), ['hrd', 'perusahaan'], true)),
                'exists:companies,id',
            ],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($user->id === auth()->id() && ($validated['role'] !== 'admin')) {
            return back()->with('error', 'Akun kamu sendiri tidak bisa diubah menjadi non-admin.')->withInput();
        }

        $role = $validated['role'];
        $companyId = in_array($role, ['hrd', 'perusahaan'], true) ? ($validated['company_id'] ?? null) : null;

        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $role,
            'company_id' => $companyId,
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ];

        if (!empty($validated['password'])) {
            $payload['password'] = $validated['password'];
        }

        if ($user->role === 'admin' && $payload['is_active'] === false) {
            if (!$this->hasAnotherActiveAdmin($user->id)) {
                return back()->with('error', 'Minimal harus ada 1 admin aktif.')->withInput();
            }
        }

        $user->update($payload);

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil diperbarui.');
    }

    public function updateStatus(Request $request, User $user)
    {
        $validated = $request->validate([
            'is_active' => ['required', 'boolean'],
        ]);

        if ($user->id === auth()->id() && $validated['is_active'] === false) {
            return back()->with('error', 'Akun kamu sendiri tidak bisa dinonaktifkan.');
        }

        if ($user->role === 'admin' && $validated['is_active'] === false) {
            if (!$this->hasAnotherActiveAdmin($user->id)) {
                return back()->with('error', 'Minimal harus ada 1 admin aktif.');
            }
        }

        $user->update(['is_active' => (bool) $validated['is_active']]);

        return back()->with('success', 'Status akun diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Akun kamu sendiri tidak bisa dihapus.');
        }

        if ($user->role === 'admin') {
            if (!$this->hasAnotherAdmin($user->id)) {
                return back()->with('error', 'Minimal harus ada 1 admin tersisa.');
            }
        }

        $user->delete();

        return back()->with('success', 'Akun berhasil dihapus.');
    }

    private function hasAnotherActiveAdmin(int $excludeId): bool
    {
        return User::query()
            ->where('role', 'admin')
            ->where('is_active', true)
            ->where('id', '!=', $excludeId)
            ->exists();
    }

    private function hasAnotherAdmin(int $excludeId): bool
    {
        return User::query()
            ->where('role', 'admin')
            ->where('id', '!=', $excludeId)
            ->exists();
    }

    private function escapeLike(string $value): string
    {
        return addcslashes($value, "\\%_");
    }
}
