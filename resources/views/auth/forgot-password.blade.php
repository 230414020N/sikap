@extends('layouts.guest')

@section('title', 'Lupa Password')

@section('content')
<div class="w-full max-w-md">
    <div class="bg-white border border-gray-200 rounded-3xl shadow-sm p-6 sm:p-7">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <p class="text-[11px] font-semibold tracking-widest text-gray-500">ACCOUNT</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-gray-900">Lupa Password</h1>
                <p class="mt-1 text-sm text-gray-600">
                    Masukkan email akun kamu. Kami akan kirim link untuk reset password.
                </p>
            </div>
            <div class="h-11 w-11 rounded-3xl bg-gray-900 text-white flex items-center justify-center text-sm font-semibold shadow-sm">
                ✉️
            </div>
        </div>

        @if (session('status'))
            <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                Email belum valid. Coba cek lagi.
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="mt-7 space-y-5">
            @csrf

            <div>
                <x-input-label for="email" value="Email" class="text-sm font-medium text-gray-900" />
                <x-text-input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="mt-2 block w-full rounded-2xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-300 focus:ring-2 focus:ring-gray-900/10"
                    placeholder="nama@email.com"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <x-primary-button class="w-full justify-center rounded-2xl py-3">
                Kirim Link Reset
            </x-primary-button>

            <div class="pt-4 border-t border-gray-200 flex items-center justify-between text-sm">
                <a href="{{ route('login') }}" class="text-gray-900 underline underline-offset-4 hover:text-gray-700">
                    ← Kembali login
                </a>
                <a href="{{ route('perusahaan.login') }}" class="text-gray-900 underline underline-offset-4 hover:text-gray-700">
                    Login perusahaan
                </a>
            </div>
        </form>
    </div>

    <p class="mt-4 text-center text-xs text-gray-500">
        Kalau email terdaftar, link reset akan dikirim dalam beberapa menit.
    </p>
</div>
@endsection
