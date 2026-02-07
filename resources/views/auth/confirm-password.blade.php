@extends('layouts.guest')

@section('title', 'Konfirmasi Password')

@section('content')
<div class="w-full max-w-md">
    <div class="bg-white border border-gray-200 rounded-3xl shadow-sm p-6 sm:p-7">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <p class="text-[11px] font-semibold tracking-widest text-gray-500">SECURITY</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-gray-900">Konfirmasi Password</h1>
                <p class="mt-1 text-sm text-gray-600">
                    Area ini membutuhkan verifikasi. Masukkan password kamu untuk lanjut.
                </p>
            </div>
            <div class="h-11 w-11 rounded-3xl bg-gray-900 text-white flex items-center justify-center text-sm font-semibold shadow-sm">
                🔒
            </div>
        </div>

        @if($errors->any())
            <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                Password tidak sesuai. Coba lagi.
            </div>
        @endif

        <form method="POST" action="{{ route('password.confirm') }}" class="mt-7 space-y-5">
            @csrf

            <div>
                <x-input-label for="password" value="Password" class="text-sm font-medium text-gray-900" />
                <x-text-input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="mt-2 block w-full rounded-2xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-300 focus:ring-2 focus:ring-gray-900/10"
                    placeholder="••••••••"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <x-primary-button class="w-full justify-center rounded-2xl py-3">
                Konfirmasi
            </x-primary-button>

            <div class="pt-4 border-t border-gray-200 text-center">
                <a href="{{ url()->previous() }}" class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700">
                    ← Kembali
                </a>
            </div>
        </form>
    </div>

    <p class="mt-4 text-center text-xs text-gray-500">
        Demi keamanan, kamu mungkin diminta konfirmasi ulang saat melakukan perubahan penting.
    </p>
</div>
@endsection
