@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-md">
            <div class="mb-6 text-center">
                <div class="mx-auto h-11 w-11 rounded-3xl bg-gray-900 text-white flex items-center justify-center text-sm font-semibold shadow-sm">
                    S
                </div>
                <p class="mt-4 text-[11px] font-semibold tracking-widest text-gray-500">PELAMAR</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-gray-900">Buat Akun Pelamar</h1>
                <p class="mt-1 text-sm text-gray-600">Daftar untuk melamar kerja, kelola profil, dan portofolio.</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-3xl shadow-sm p-6 sm:p-7">
                @if($errors->any())
                    <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        Ada beberapa input yang belum valid. Coba cek lagi ya.
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="name" value="Nama" class="text-sm font-medium text-gray-900" />
                        <x-text-input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                            class="mt-2 block w-full rounded-2xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-300 focus:ring-2 focus:ring-gray-900/10"
                            placeholder="Nama lengkap"
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Email" class="text-sm font-medium text-gray-900" />
                        <x-text-input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="username"
                            class="mt-2 block w-full rounded-2xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-300 focus:ring-2 focus:ring-gray-900/10"
                            placeholder="nama@email.com"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" value="Password" class="text-sm font-medium text-gray-900" />
                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="new-password"
                            class="mt-2 block w-full rounded-2xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-300 focus:ring-2 focus:ring-gray-900/10"
                            placeholder="Minimal 8 karakter"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" value="Konfirmasi Password" class="text-sm font-medium text-gray-900" />
                        <x-text-input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            required
                            autocomplete="new-password"
                            class="mt-2 block w-full rounded-2xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-300 focus:ring-2 focus:ring-gray-900/10"
                            placeholder="Ulangi password"
                        />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <x-primary-button class="w-full justify-center rounded-2xl py-3">
                        Daftar
                    </x-primary-button>

                    <div class="pt-5 border-t border-gray-200 text-center text-sm text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-gray-900 underline underline-offset-4 hover:text-gray-700">
                            Login
                        </a>
                    </div>
                </form>
            </div>

            <p class="mt-4 text-center text-xs text-gray-500">
                Dengan mendaftar, kamu menyetujui kebijakan dan ketentuan penggunaan.
            </p>
        </div>
    </div>
@endsection
