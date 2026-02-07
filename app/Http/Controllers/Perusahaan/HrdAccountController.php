<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class HrdAccountController extends Controller
{
    public function index()
    {
        $companyId = auth()->user()->company_id;

        $hrdUsers = User::query()
            ->where('company_id', $companyId)
            ->where('role', 'hrd')
            ->orderBy('name')
            ->paginate(10);

        $activationLinks = [];
        $activationExpiresAt = [];

        foreach ($hrdUsers as $hrd) {
            if (!empty($hrd->email_verified_at)) {
                continue;
            }

            if (empty($hrd->invitation_token) || empty($hrd->invitation_token_hash) || empty($hrd->invited_at)) {
                continue;
            }

            $expiresAt = $hrd->invited_at->copy()->addDays(7);

            if (now()->greaterThan($expiresAt)) {
                continue;
            }

            $token = Crypt::decryptString($hrd->invitation_token);

            $relative = URL::temporarySignedRoute(
                'hrd.activate',
                $expiresAt,
                ['token' => $token],
                false
            );

            $activationLinks[$hrd->id] = url($relative);
            $activationExpiresAt[$hrd->id] = $expiresAt;
        }

        return view('perusahaan.hrd.index', compact('hrdUsers', 'activationLinks', 'activationExpiresAt'));
    }

    public function create()
    {
        return view('perusahaan.hrd.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        ]);

        $token = Str::random(64);
        $tokenHash = hash('sha256', $token);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make(Str::random(32)),
            'role' => 'hrd',
            'company_id' => auth()->user()->company_id,
            'is_active' => true,
            'invitation_token' => Crypt::encryptString($token),
            'invitation_token_hash' => $tokenHash,
            'invited_at' => now(),
        ]);

        return redirect()
            ->route('perusahaan.hrd.index')
            ->with('success', 'Akun HRD dibuat. Copy link aktivasi di daftar HRD.');
    }

    public function regenerateActivationLink(int $id)
    {
        $hrd = $this->findHrdForCompany($id);

        if (!empty($hrd->email_verified_at)) {
            return redirect()
                ->route('perusahaan.hrd.index')
                ->with('success', 'HRD sudah aktif. Tidak perlu link aktivasi.');
        }

        $token = Str::random(64);
        $tokenHash = hash('sha256', $token);

        $hrd->invitation_token = Crypt::encryptString($token);
        $hrd->invitation_token_hash = $tokenHash;
        $hrd->invited_at = now();
        $hrd->save();

        return redirect()
            ->route('perusahaan.hrd.index')
            ->with('success', 'Link aktivasi berhasil dibuat ulang.');
    }

    public function edit(int $id)
    {
        $hrd = $this->findHrdForCompany($id);

        return view('perusahaan.hrd.edit', compact('hrd'));
    }

    public function update(Request $request, int $id)
    {
        $hrd = $this->findHrdForCompany($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($hrd->id),
            ],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $hrd->name = $validated['name'];
        $hrd->email = $validated['email'];

        if (!empty($validated['password'])) {
            $hrd->password = Hash::make($validated['password']);
        }

        $hrd->save();

        return redirect()
            ->route('perusahaan.hrd.index')
            ->with('success', 'Akun HRD berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $hrd = $this->findHrdForCompany($id);
        $hrd->delete();

        return redirect()
            ->route('perusahaan.hrd.index')
            ->with('success', 'Akun HRD berhasil dihapus.');
    }

    private function findHrdForCompany(int $id): User
    {
        $companyId = auth()->user()->company_id;

        return User::query()
            ->where('id', $id)
            ->where('company_id', $companyId)
            ->where('role', 'hrd')
            ->firstOrFail();
    }
}
