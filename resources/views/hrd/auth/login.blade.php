@extends('layouts.app')

@section('content')
@php
    $homeHref = \Illuminate\Support\Facades\Route::has('home') ? route('home') : url('/');
@endphp

<div class="min-h-screen bg-gray-50">
    <div class="max-w-md mx-auto px-4 py-12">
        <div class="mb-6 flex justify-center">
            <a href="{{ $homeHref }}" class="inline-flex items-center justify-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SIKAP" class="h-20 sm:h-24 w-auto max-w-none object-contain">
            </a>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
            <div class="mb-5">
                <h1 class="text-xl font-semibold text-gray-900">Login HRD</h1>
                <p class="mt-1 text-sm text-gray-600">Masuk untuk mengelola lowongan dan kandidat.</p>
            </div>

            @if($errors->any())
                <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    Login gagal. Cek kembali email dan password kamu.
                </div>
            @endif

            <form method="POST" action="{{ route('hrd.login.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="text-sm font-medium text-gray-900">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
                           placeholder="nama@email.com" required>
                    @error('email')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-900">Password</label>
                    <input type="password" name="password"
                           class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
                           placeholder="••••••••" required>
                    @error('password')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full rounded-xl bg-black px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-900 transition">
                    Masuk
                </button>
            </form>

            <div class="mt-5 pt-5 border-t border-gray-200 text-sm text-gray-700">
                Belum punya akun perusahaan?
                <a href="{{ route('hrd.company.register') }}" class="text-gray-900 underline underline-offset-4 hover:text-gray-700">
                    Daftar
                </a>
            </div>
        </div>

        <p class="mt-6 text-center text-xs text-gray-500">
            Dengan login, kamu menyetujui kebijakan dan ketentuan penggunaan.
        </p>
    </div>
</div>
@endsection
