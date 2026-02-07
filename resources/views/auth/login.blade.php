@extends('layouts.guest')

@section('title', 'Login')

@section('content')
@php
    $as = $as ?? request('as') ?? 'pelamar';
    if (!in_array($as, ['pelamar','hrd','perusahaan'], true)) $as = 'pelamar';

    $href = function (string $name, array $params = [], string $fallback = '#') {
        return \Illuminate\Support\Facades\Route::has($name) ? route($name, $params) : $fallback;
    };

    $switch = [
        ['label' => 'Pelamar', 'href' => $href('login.pelamar', [], $href('login', ['as' => 'pelamar'])), 'active' => 'pelamar'],
        ['label' => 'HRD', 'href' => $href('login.hrd', [], $href('login', ['as' => 'hrd'])), 'active' => 'hrd'],
        ['label' => 'Perusahaan', 'href' => $href('login.perusahaan', [], $href('login', ['as' => 'perusahaan'])), 'active' => 'perusahaan'],
    ];
@endphp

<div class="w-full max-w-4xl bg-[#D9D9D9] rounded-[40px] shadow-lg overflow-hidden flex flex-col md:flex-row h-auto">
    
    <div class="w-full md:w-1/3 p-8 flex flex-col gap-4 border-b md:border-b-0 md:border-r border-gray-400/50">
        <a href="#" class="flex items-center gap-4 bg-[#BDBDBD] p-4 rounded-2xl transition-all">
            <div class="bg-black p-2 rounded-lg text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </div>
            <span class="font-bold text-xl text-gray-800">Masuk</span>
        </a>

        @php
            $registerUrl = match($as) {
                'perusahaan' => route('perusahaan.register'),
                'hrd' => '#',
                default => route('register'),
            };
        @endphp
        <a href="{{ $registerUrl }}" class="flex items-center gap-4 p-4 rounded-2xl hover:bg-gray-300 transition-all text-gray-600">
            <div class="p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <span class="font-bold text-xl">Daftar</span>
        </a>
    </div>

    <div class="flex-1 p-8 md:p-16 relative">
        <h1 class="text-5xl text-right font-bold text-black mb-12">Login</h1>

        <form method="POST" action="{{ route('login') }}" class="space-y-8">
            @csrf
            <input type="hidden" name="as" value="{{ $as }}">

            <div class="space-y-2">
                <label for="email" class="text-xl font-medium text-black">E-mail</label>
                <input 
                    id="email" 
                    name="email" 
                    type="email" 
                    placeholder="Masukkan E-mail Anda"
                    class="w-full p-4 rounded-xl border-none bg-white text-lg focus:ring-2 focus:ring-gray-400 shadow-sm"
                    value="{{ old('email') }}" required
                >
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="space-y-2">
                <label for="password" class="text-xl font-medium text-black">Kata Sandi</label>
                <div class="relative">
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        placeholder="Masukkan Kata Sandi Anda"
                        class="w-full p-4 rounded-xl border-none bg-white text-lg focus:ring-2 focus:ring-gray-400 shadow-sm pr-12"
                        required
                    >
                    <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-black">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="remember" id="remember" class="w-5 h-5 rounded-full border-2 border-black text-black focus:ring-0">
                <label for="remember" class="text-lg font-medium text-black">Ingat Saya</label>
            </div>

            <button type="submit" class="w-full bg-[#BDBDBD] py-4 rounded-xl text-xl font-bold text-gray-800 hover:bg-gray-400 transition-colors shadow-md mt-4">
                Login
            </button>

            <div class="pt-8 border-t border-gray-400/30">
                <p class="text-sm text-gray-600 mb-3 text-center">Masuk sebagai peran lain:</p>
                <div class="flex flex-wrap justify-center gap-2">
                    @foreach($switch as $sw)
                        <a href="{{ $sw['href'] }}" 
                           class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ $as === $sw['active'] ? 'bg-black text-white' : 'bg-white/50 text-gray-700 hover:bg-white' }}">
                            {{ $sw['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </form>
    </div>
</div>
@endsection