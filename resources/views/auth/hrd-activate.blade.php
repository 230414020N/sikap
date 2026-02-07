@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white border border-gray-200 rounded-[28px] shadow-sm overflow-hidden">
            <div class="p-6 sm:p-8 border-b border-gray-200">
                <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Aktivasi Akun HRD</h1>
                <p class="mt-1 text-sm text-gray-600">Buat password untuk mulai menggunakan akun HRD.</p>
                <p class="mt-3 text-sm text-gray-900 font-medium">{{ $user->email }}</p>
                <p class="mt-1 text-xs text-gray-500">Berlaku sampai: {{ $expiresAt->format('d M Y, H:i') }}</p>
            </div>

            <div class="p-6 sm:p-8">
                @if ($errors->any())
                    <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 p-5">
                        <p class="text-sm font-semibold text-red-800">Periksa input kamu:</p>
                        <ul class="mt-2 list-disc pl-5 text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('hrd.activate.store', ['token' => $token, 'expires' => $signedExpires, 'signature' => $signedSignature]) }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-900">Password</label>
                        <input type="password" name="password"
                               class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition"
                               placeholder="Minimal 8 karakter" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                               class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition"
                               placeholder="Ulangi password" />
                    </div>

                    <button type="submit"
                            class="w-full inline-flex items-center justify-center rounded-2xl bg-gray-900 px-5 py-3 text-sm font-medium text-white hover:bg-black transition shadow-sm">
                        Aktifkan & Masuk
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('login.hrd') }}" class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700">
                        Kembali ke Login HRD
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
