@extends('layouts.guest')

@section('title', 'Daftar')

@section('content')
<div class="w-full max-w-6xl bg-[#D9D9D9] rounded-[40px] shadow-lg overflow-hidden flex flex-col md:flex-row min-h-[600px] mx-4">
    
    <div class="w-full md:w-1/4 p-10 flex flex-col gap-6 border-b md:border-b-0 md:border-r border-gray-400/40">
        <a href="{{ route('login') }}" class="flex items-center gap-4 p-5 rounded-3xl text-gray-500 hover:bg-gray-300 transition-all">
            <div class="p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </div>
            <span class="font-bold text-2xl">Masuk</span>
        </a>

        <a href="#" class="flex items-center gap-4 bg-[#BDBDBD] p-5 rounded-3xl transition-all shadow-sm">
            <div class="bg-black p-2.5 rounded-xl text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <span class="font-bold text-2xl text-gray-800">Daftar</span>
        </a>
    </div>

    <div class="flex-1 p-10 md:p-16 flex flex-col justify-center">
        <div class="mb-8">
            <p class="text-xl text-gray-700">Daftar sebagai pencari kerja</p>
            <h1 class="text-5xl font-bold text-black mt-2">Hai! Yuk mulai bangun profil kariermu.</h1>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-lg">
                Ada beberapa input yang belum valid. Coba cek lagi ya.
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-6 max-w-3xl">
            @csrf

            <div class="space-y-2">
                <label for="name" class="text-xl font-medium text-black">Nama Lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Masukkan Nama Lengkap"
                    class="w-full p-4 rounded-xl border-none bg-white text-lg shadow-sm focus:ring-2 focus:ring-gray-400" required autofocus>
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <div class="space-y-2">
                <label for="whatsapp" class="text-xl font-medium text-black">Nomor WhatsApp</label>
                <input id="whatsapp" name="whatsapp" type="text" placeholder="Masukkan Nomor WhatsApp"
                    class="w-full p-4 rounded-xl border-none bg-white text-lg shadow-sm focus:ring-2 focus:ring-gray-400">
                <p class="text-sm text-gray-600 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Pastikan nomor whatsapp mu sesuai, agar bisa dihubungi oleh pihak perusahaan.
                </p>
            </div>

            <div class="space-y-2">
                <label for="email" class="text-xl font-medium text-black">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="Masukkan E-mail Anda"
                    class="w-full p-4 rounded-xl border-none bg-white text-lg shadow-sm focus:ring-2 focus:ring-gray-400" required>
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div class="space-y-2">
                <label for="password" class="text-xl font-medium text-black">Kata Sandi</label>
                <div class="relative">
                    <input id="password" name="password" type="password" placeholder="Buat Kata Sandi"
                        class="w-full p-4 rounded-xl border-none bg-white text-lg shadow-sm focus:ring-2 focus:ring-gray-400 pr-12" required>
                    <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-black">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div class="space-y-2">
                <label for="password_confirmation" class="text-xl font-medium text-black">Ketik Ulang Kata Sandi</label>
                <div class="relative">
                    <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Masukkan Kata Sandi yang Sama"
                        class="w-full p-4 rounded-xl border-none bg-white text-lg shadow-sm focus:ring-2 focus:ring-gray-400 pr-12" required>
                    <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-black">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="w-full md:w-64 bg-[#3498DB] py-4 rounded-xl text-xl font-bold text-white hover:bg-blue-600 transition-all shadow-md">
                    Selanjutnya
                </button>
            </div>
        </form>
    </div>
</div>
@endsection