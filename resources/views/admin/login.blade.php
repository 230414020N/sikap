@extends('layouts.guest')

@section('title', 'Login Admin')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-md">
        <div class="mb-6 text-center">
            <div class="mx-auto h-11 w-11 rounded-3xl bg-gray-900 text-white flex items-center justify-center text-sm font-semibold shadow-sm">
                🛡️
            </div>
            <p class="mt-4 text-[11px] font-semibold tracking-widest text-gray-500">ADMIN</p>
            <h1 class="mt-2 text-2xl font-semibold tracking-tight text-gray-900">Login Admin</h1>
            <p class="mt-1 text-sm text-gray-600">Masuk untuk mengelola sistem.</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-3xl shadow-sm p-6 sm:p-7">
            @if (session('status'))
                <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    Login gagal. Coba cek kembali email dan password.
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-5">
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
                        placeholder="admin@email.com"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" value="Password" class="text-sm font-medium text-gray-900" />
                    <x-text-input
                        id="password"
                        type="password"
                        name="password"
                        required
                        class="mt-2 block w-full rounded-2xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-300 focus:ring-2 focus:ring-gray-900/10"
                        placeholder="••••••••"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between gap-3">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-gray-900 shadow-sm focus:ring-gray-900/20">
                        <span class="text-sm text-gray-700">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700" href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <x-primary-button class="w-full justify-center rounded-2xl py-3">
                    Login
                </x-primary-button>
            </form>
        </div>

        <p class="mt-4 text-center text-xs text-gray-500">
            Akses admin hanya untuk pengguna yang berwenang.
        </p>
    </div>
</div>
@endsection
