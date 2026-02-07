@extends('layouts.guest')

@section('title', 'Login')

@section('content')
@php
    $as = $as ?? request('as') ?? 'pelamar';
    if (!in_array($as, ['pelamar','hrd','perusahaan'], true)) $as = 'pelamar';

    $href = function (string $name, array $params = [], string $fallback = '#') {
        return \Illuminate\Support\Facades\Route::has($name) ? route($name, $params) : $fallback;
    };

    $homeHref = \Illuminate\Support\Facades\Route::has('home') ? route('home') : url('/');

    $switch = [
        ['label' => 'Pelamar', 'href' => $href('login.pelamar', [], $href('login', ['as' => 'pelamar'])), 'active' => 'pelamar'],
        ['label' => 'HRD', 'href' => $href('login.hrd', [], $href('login', ['as' => 'hrd'])), 'active' => 'hrd'],
        ['label' => 'Perusahaan', 'href' => $href('login.perusahaan', [], $href('login', ['as' => 'perusahaan'])), 'active' => 'perusahaan'],
    ];

    $meta = match($as) {
        'hrd' => [
            'eyebrow' => 'HRD',
            'title' => 'Masuk sebagai HRD',
            'subtitle' => 'Gunakan akun HRD yang dibuat oleh perusahaan.',
            'switch' => $switch,
        ],
        'perusahaan' => [
            'eyebrow' => 'PERUSAHAAN',
            'title' => 'Masuk sebagai Perusahaan',
            'subtitle' => 'Gunakan akun perusahaan untuk kelola HRD dan profil.',
            'switch' => $switch,
        ],
        default => [
            'eyebrow' => 'PELAMAR',
            'title' => 'Masuk sebagai Pelamar',
            'subtitle' => 'Gunakan akun pelamar untuk melamar dan kelola portofolio.',
            'switch' => $switch,
        ],
    };
@endphp

<div class="w-full max-w-md">
    <div class="mb-6 text-center">
        <h1 class="mt-2 text-2xl font-semibold tracking-tight text-gray-900">{{ $meta['title'] }}</h1>
        <p class="mt-1 text-sm text-gray-600">{{ $meta['subtitle'] }}</p>
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

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="as" value="{{ $as }}">

            <div>
                <x-input-label for="email" value="Email" class="text-sm font-medium text-gray-900" />
                <x-text-input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="mt-2 block w-full rounded-2xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-300 focus:ring-2 focus:ring-gray-900/10"
                    placeholder="nama@email.com"
                />
                <x-input-error :help="false" class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="password" value="Password" class="text-sm font-medium text-gray-900" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    required
                    class="mt-2 block w-full rounded-2xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-300 focus:ring-2 focus:ring-gray-900/10"
                    placeholder="••••••••"
                />
                <x-input-error :help="false" class="mt-2" :messages="$errors->get('password')" />
            </div>

            <div class="flex items-center justify-between gap-3">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-gray-900 shadow-sm focus:ring-gray-900/20" @checked(old('remember'))>
                    <span class="text-sm text-gray-700">Ingat saya</span>
                </label>

                @if (\Illuminate\Support\Facades\Route::has('password.request'))
                    <a class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>

            <x-primary-button class="w-full justify-center rounded-2xl py-3">
                Masuk
            </x-primary-button>

            <div class="pt-5 border-t border-gray-200 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                    @foreach($meta['switch'] as $sw)
                        <a href="{{ $sw['href'] }}"
                           class="rounded-2xl px-3 py-2 text-center text-sm font-medium transition {{ $as === $sw['active'] ? 'bg-gray-900 text-white' : 'bg-white border border-gray-200 text-gray-900 hover:bg-gray-50' }}">
                            {{ $sw['label'] }}
                        </a>
                    @endforeach
                </div>

                <div class="text-center text-sm text-gray-600">
                    @if($as === 'pelamar')
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-gray-900 underline underline-offset-4 hover:text-gray-700">Register</a>
                    @elseif($as === 'perusahaan')
                        Belum punya akun?
                        <a href="{{ route('perusahaan.register') }}" class="text-gray-900 underline underline-offset-4 hover:text-gray-700">Register Perusahaan</a>
                    @else
                        Minta akun HRD ke perusahaan kamu.
                    @endif
                </div>
            </div>
        </form>
    </div>

    <p class="mt-4 text-center text-xs text-gray-500">
        Dengan login, kamu menyetujui kebijakan dan ketentuan penggunaan.
    </p>
</div>
@endsection
