@extends('layouts.guest')

@section('title', 'Verifikasi Email')

@section('content')
<div class="w-full max-w-md">
    <div class="mb-6 text-center">
        <div class="mx-auto h-11 w-11 rounded-3xl bg-gray-900 text-white flex items-center justify-center text-sm font-semibold shadow-sm">
            S
        </div>
        <p class="mt-4 text-[11px] font-semibold tracking-widest text-gray-500">VERIFIKASI EMAIL</p>
        <h1 class="mt-2 text-2xl font-semibold tracking-tight text-gray-900">Cek Email Kamu</h1>
        <p class="mt-1 text-sm text-gray-600">Klik link verifikasi agar akun kamu aktif.</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-3xl shadow-sm p-6 sm:p-7">
        <div class="rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mt-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-6 flex flex-col gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button class="w-full justify-center rounded-2xl py-3">
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-5 py-3 text-sm font-medium text-gray-900 hover:bg-gray-50 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-900/20 focus-visible:ring-offset-2 focus-visible:ring-offset-white"
                >
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>

    <p class="mt-4 text-center text-xs text-gray-500">
        Tidak menerima email? Cek folder Spam/Promotions atau pastikan alamat email benar.
    </p>
</div>
@endsection
