@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#4b4b4b] p-4 sm:p-8">
    <div class="max-w-5xl mx-auto">
        
        <div class="mb-6">
            <h1 class="text-white text-4xl font-bold uppercase tracking-tight">Profile Perusahaan</h1>
            <p class="text-gray-300 mt-2">Kelola informasi dasar perusahaan untuk meningkatkan kepercayaan calon pelamar.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-xl bg-green-500/20 border border-green-500 text-green-100 px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('hrd.company.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="bg-white rounded-3xl p-8 shadow-lg relative">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="relative group">
                        <div class="w-40 h-40 rounded-full bg-gray-200 border-4 border-gray-100 flex items-center justify-center overflow-hidden">
                            @if($company->logo_path)
                                <img src="{{ asset('storage/' . $company->logo_path) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-300"></div>
                            @endif
                        </div>
                        <label class="absolute bottom-2 right-2 bg-white p-2 rounded-full shadow-md cursor-pointer hover:bg-gray-50 transition border border-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            <input type="file" name="logo" class="hidden">
                        </label>
                    </div>

                    <div class="flex-1 w-full space-y-4">
                        <div>
                            <input type="text" name="nama" value="{{ old('nama', $company->nama) }}" placeholder="Nama Perusahaan" 
                                   class="text-3xl font-bold text-gray-900 border-none focus:ring-0 p-0 w-full placeholder-gray-400">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="industri" value="{{ old('industri', $company->industri) }}" placeholder="Industri (Contoh: Teknologi Informasi)" 
                                   class="text-gray-600 border-none focus:ring-0 p-0 w-full">
                            <input type="text" name="lokasi" value="{{ old('lokasi', $company->lokasi) }}" placeholder="Lokasi (Contoh: Kota Bandung, Jawa Barat)" 
                                   class="text-gray-600 border-none focus:ring-0 p-0 w-full">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="kontak" value="{{ $company->kontak ?? '' }}" placeholder="Nomor Telepon" 
                                   class="text-gray-600 border-none focus:ring-0 p-0 w-full">
                            <input type="email" name="website" value="{{ old('website', $company->website) }}" placeholder="Email / Website Perusahaan" 
                                   class="text-gray-600 border-none focus:ring-0 p-0 w-full">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-lg">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Identitas & Legalitas Perusahaan</h2>
                <div class="space-y-4">
                    <div class="flex flex-col md:flex-row md:items-center gap-4">
                        <label class="w-full md:w-1/3 text-gray-700 font-medium">Tahun Berdiri</label>
                        <input type="text" name="tahun_berdiri" value="{{ $company->tahun_berdiri ?? '' }}" placeholder="2008" 
                               class="w-full md:w-2/3 bg-[#f0f0f0] border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center gap-4">
                        <label class="w-full md:w-1/3 text-gray-700 font-medium">Nomor Legalitas</label>
                        <input type="text" name="no_legalitas" value="{{ $company->no_legalitas ?? '' }}" placeholder="AHU-XXXX.AH.01.01" 
                               class="w-full md:w-2/3 bg-[#f0f0f0] border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center gap-4">
                        <label class="w-full md:w-1/3 text-gray-700 font-medium">NPWP</label>
                        <input type="text" name="npwp" value="{{ $company->npwp ?? '' }}" placeholder="02.345.678.9-421.000" 
                               class="w-full md:w-2/3 bg-[#f0f0f0] border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-lg">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Tentang Perusahaan</h2>
                <div class="space-y-6">
                    <div>
                        <label class="block text-gray-700 font-medium mb-3">Deskripsi Perusahaan</label>
                        <textarea name="deskripsi" rows="4" placeholder="Masukkan deskripsi perusahaan..." 
                                  class="w-full bg-[#f0f0f0] border-none rounded-xl py-4 px-5 focus:ring-2 focus:ring-blue-500">{{ old('deskripsi', $company->deskripsi) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-3">Visi Perusahaan</label>
                        <textarea name="visi" rows="2" placeholder="Masukkan visi perusahaan..." 
                                  class="w-full bg-[#f0f0f0] border-none rounded-xl py-4 px-5 focus:ring-2 focus:ring-blue-500">{{ $company->visi ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-3">Misi Perusahaan</label>
                        <textarea name="misi" rows="3" placeholder="Masukkan misi perusahaan..." 
                                  class="w-full bg-[#f0f0f0] border-none rounded-xl py-4 px-5 focus:ring-2 focus:ring-blue-500">{{ $company->misi ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-center md:justify-end gap-4 mt-8">
                <a href="{{ route('hrd.dashboard') }}" 
                   class="bg-[#4d79ff] text-white px-10 py-3 rounded-xl font-semibold hover:bg-blue-600 transition shadow-md">
                    Kembali
                </a>
                <button type="submit" 
                        class="bg-[#00d094] text-white px-10 py-3 rounded-xl font-semibold hover:bg-emerald-500 transition shadow-md">
                    Simpan Perubahan
                </button>
            </div>
        </form>

        <div class="mt-12 text-center text-gray-400 text-sm pb-8">
            <p>&copy; 2025, Sistem Informasi Karier dan Portofolio</p>
        </div>
    </div>
</div>

<style>
    /* Menghilangkan outline fokus default untuk input gaya border-none */
    input:focus, textarea:focus {
        outline: none !important;
    }
    
    /* Custom scrollbar untuk textarea jika diperlukan */
    textarea::-webkit-scrollbar {
        width: 8px;
    }
    textarea::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }
</style>
@endsection