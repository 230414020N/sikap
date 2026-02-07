<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HrdActivationController extends Controller
{
    public function show(Request $request, string $token)
    {
        $user = $this->resolveUser($token);
        $expiresAt = $user->invited_at->copy()->addDays(7);

        if (now()->greaterThan($expiresAt)) {
            abort(410);
        }

        if (!empty($user->email_verified_at)) {
            return redirect()->route('login.hrd')->with('success', 'Akun sudah aktif. Silakan login.');
        }

        return view('auth.hrd-activate', [
            'token' => $token,
            'user' => $user,
            'expiresAt' => $expiresAt,
            'signedExpires' => (string) $request->query('expires'),
            'signedSignature' => (string) $request->query('signature'),
        ]);
    }

    public function store(Request $request, string $token)
    {
        $user = $this->resolveUser($token);
        $expiresAt = $user->invited_at->copy()->addDays(7);

        if (now()->greaterThan($expiresAt)) {
            abort(410);
        }

        if (!empty($user->email_verified_at)) {
            return redirect()->route('login.hrd')->with('success', 'Akun sudah aktif. Silakan login.');
        }

        $validated = $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user->password = Hash::make($validated['password']);
        $user->email_verified_at = now();
        $user->is_active = true;
        $user->invitation_token = null;
        $user->invitation_token_hash = null;
        $user->invited_at = null;
        $user->save();

        Auth::login($user);

        return redirect()->route('hrd.dashboard');
    }

    private function resolveUser(string $token): User
    {
        $hash = hash('sha256', $token);

        return User::query()
            ->where('role', 'hrd')
            ->where('invitation_token_hash', $hash)
            ->whereNotNull('invited_at')
            ->firstOrFail();
    }
}
