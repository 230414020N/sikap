@extends('layouts.guest')

@section('title', 'Registrasi Perusahaan')

@section('content')
<div class="w-full max-w-6xl bg-[#D9D9D9] rounded-[40px] shadow-lg overflow-hidden flex flex-col md:flex-row min-h-[700px] mx-4">
    
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
                <svg xmlns="http://www.w3.org/2000/xl" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <span class="font-bold text-2xl text-gray-800">Daftar</span>
        </a>
    </div>

    <div class="flex-1 p-10 md:p-16 flex flex-col justify-center">
        <div class="mb-8">
            <p class="text-xl text-gray-700">Daftar sebagai perusahaan</p>
            <h1 class="text-5xl font-bold text-black mt-2">Pasang Lowongan Kerjamu Sekarang!</h1>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-lg">
                Ada beberapa input yang belum valid. Coba cek lagi ya.
            </div>
        @endif

        <form method="POST" action="{{ route('perusahaan.register.store') }}" class="space-y-6 max-w-4xl">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <div class="space-y-6">
                    <h2 class="text-2xl font-bold text-gray-800 border-b border-gray-400/30 pb-2">Data PIC Admin</h2>
                    
                    <div class="space-y-2">
                        <label for="name" class="text-lg font-medium text-black">Nama Lengkap PIC</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Masukkan Nama Lengkap"
                            class="w-full p-4 rounded-xl border-none bg-white text-lg shadow-sm focus:ring-2 focus:ring-gray-400" required>
                        <x-input-error :messages="$errors->get('name')" />
                    </div>

                    <div class="space-y-2">
                        <label for="whatsapp" class="text-lg font-medium text-black">Nomor WhatsApp PIC</label>
                        <input id="whatsapp" name="whatsapp" type="text" placeholder="Masukkan Nomor WhatsApp"
                            class="w-full p-4 rounded-xl border-none bg-white text-lg shadow-sm focus:ring-2 focus:ring-gray-400">
                        <p class="text-[10px] text-gray-600 italic leading-tight">Pastikan nomor whatsapp mu sesuai.</p>
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="text-lg font-medium text-black">E-mail Perusahaan</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="nama@perusahaan.com"
                            class="w-full p-4 rounded-xl border-none bg-white text-lg shadow-sm focus:ring-2 focus:ring-gray-400" required>
                        <x-input-error :messages="$errors->get('email')" />
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <div class="space-y-2">
                            <label for="password" class="text-lg font-medium text-black">Kata Sandi</label>
                            <input id="password" name="password" type="password" placeholder="Buat Kata Sandi"
                                class="w-full p-4 rounded-xl border-none bg-white text-lg shadow-sm focus:ring-2 focus:ring-gray-400" required>
                        </div>
                        <div class="space-y-2">
                            <label for="password_confirmation" class="text-lg font-medium text-black">Ulangi Kata Sandi</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Konfirmasi Kata Sandi"
                                class="w-full p-4 rounded-xl border-none bg-white text-lg shadow-sm focus:ring-2 focus:ring-gray-400" required>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <h2 class="text-2xl font-bold text-gray-800 border-b border-gray-400/30 pb-2">Detail Perusahaan</h2>

                    <div class="space-y-2">
                        <label for="company_nama" class="text-lg font-medium text-black">Nama Perusahaan</label>
                        <input id="company_nama" name="company_nama" type="text" value="{{ old('company_nama') }}" placeholder="PT Nama Perusahaan"
                            class="w-full p-4 rounded-xl border-none bg-white text-lg shadow-sm focus:ring-2 focus:ring-gray-400" required>
                        <x-input-error :messages="$errors->get('company_nama')" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="company_industri" class="text-lg font-medium text-black">Industri</label>
                            <input id="company_industri" name="company_industri" type="text" value="{{ old('company_industri') }}" placeholder="Misal: IT"
                                class="w-full p-4 rounded-xl border-none bg-white text-lg shadow-sm focus:ring-2 focus:ring-gray-400">
                        </div>
                        <div class="space-y-2">
                            <label for="company_lokasi" class="text-lg font-medium text-black">Lokasi</label>
                            <input id="company_lokasi" name="company_lokasi" type="text" value="{{ old('company_lokasi') }}" placeholder="Kota"
                                class="w-full p-4 rounded-xl border-none bg-white text-lg shadow-sm focus:ring-2 focus:ring-gray-400">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="company_website" class="text-lg font-medium text-black">Website</label>
                        <input id="company_website" name="company_website" type="text" value="{{ old('company_website') }}" placeholder="https://..."
                            class="w-full p-4 rounded-xl border-none bg-white text-lg shadow-sm focus:ring-2 focus:ring-gray-400">
                    </div>

                    <div class="space-y-2">
                        <label for="company_deskripsi" class="text-lg font-medium text-black">Deskripsi Singkat</label>
                        <textarea id="company_deskripsi" name="company_deskripsi" rows="2" placeholder="Tentang perusahaan..."
                            class="w-full p-4 rounded-xl border-none bg-white text-lg shadow-sm focus:ring-2 focus:ring-gray-400">{{ old('company_deskripsi') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-6">
                <button type="submit" class="w-full md:w-72 bg-[#BDBDBD] py-5 rounded-2xl text-2xl font-bold text-gray-800 hover:bg-gray-400 transition-all shadow-md">
                    Selanjutnya
                </button>
            </div>
        </form>
    </div>
</div>
@endsection