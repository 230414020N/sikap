@extends('layouts.app')

@section('content')
@php
    $companyName = $company->nama_perusahaan ?? $company->nama ?? $company->name ?? '(nama perusahaan)';
    $companyInitial = strtoupper(mb_substr(trim((string) $companyName), 0, 1)) ?: 'P';
    
    // Navigasi Sidebar
    $navBase = 'flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition duration-200';
    $navActive = 'bg-gray-800 text-white shadow-md';
    $navInactive = 'text-gray-600 hover:bg-gray-100';

    $menu = [
        ['label' => 'Dashboard', 'icon' => '🏠', 'href' => route('perusahaan.dashboard'), 'active' => 'perusahaan.dashboard'],
        ['label' => 'Profile', 'icon' => '👤', 'href' => route('perusahaan.company.edit'), 'active' => 'perusahaan.company.*'],
        ['label' => 'Kelola Akun HRD', 'icon' => '⚙️', 'href' => route('perusahaan.hrd.index'), 'active' => 'perusahaan.hrd.*'],
        ['label' => 'Lowongan', 'icon' => '💼', 'href' => route('perusahaan.jobs.index'), 'active' => 'perusahaan.jobs.*'],
        ['label' => 'Laporan Rekrutmen', 'icon' => '📊', 'href' => '#', 'active' => 'perusahaan.reports.*']
    ];
@endphp

<div class="min-h-screen bg-[#F4F4F4] flex">
    <aside class="w-72 bg-white border-r border-gray-200 hidden lg:flex flex-col p-6 sticky top-0 h-screen">
        <div class="mb-10 px-2 font-bold text-2xl tracking-tighter">
            SIKAP<span class="text-xs font-normal align-top">.</span>
        </div>

        <nav class="flex-1 space-y-2">
            @foreach($menu as $item)
                @php $isActive = request()->routeIs($item['active']); @endphp
                <a href="{{ $item['href'] }}" class="{{ $isActive ? $navActive : $navInactive }} {{ $navBase }}">
                    <span>{{ $item['icon'] }}</span>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="mt-auto pt-6 border-t border-gray-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl w-full transition">
                    <span>🚪</span> Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-6 lg:p-10">
        <header class="flex justify-end items-center mb-10 gap-6">
            <button class="text-gray-500 hover:text-gray-800 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </button>
            <div class="flex items-center gap-3">
                <span class="text-sm font-medium text-gray-700">({{ $companyName }})</span>
                <div class="h-9 w-9 rounded-full bg-black text-white flex items-center justify-center text-xs ring-2 ring-white shadow-sm">
                    {{ $companyInitial }}
                </div>
            </div>
        </header>

        <h1 class="text-2xl font-bold text-gray-900 mb-8">Ubah Profile Utama Perusahaan Anda!</h1>

        @if(session('success'))
            <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-100 p-4 text-emerald-800 text-sm flex items-center gap-3">
                <span>✅</span> {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('perusahaan.company.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Foto Perusahaan</h3>
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="relative group">
                        <div class="h-32 w-32 rounded-full overflow-hidden bg-gray-100 border-2 border-gray-50 shadow-inner">
                            <img id="logoPreview" 
                                 src="{{ !empty($company->logo) ? asset('storage/' . $company->logo) : 'https://ui-avatars.com/api/?name='.urlencode($companyName).'&background=E5E7EB&color=9CA3AF' }}" 
                                 class="h-full w-full object-cover">
                        </div>
                    </div>
                    
                    <div class="flex-1">
                        <label for="logo" class="inline-flex items-center gap-2 px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-xl cursor-pointer transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Pilih Foto
                        </label>
                        <input type="file" id="logo" name="logo" class="hidden" onchange="previewImg(event, 'logoPreview')">
                        <p class="mt-3 text-xs text-gray-400 leading-relaxed">Format .jpg, .jpeg, .png<br>Rekomendasi ukuran 1200px x 1200px, Ukuran max 2Mb</p>
                        @error('logo') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-100 space-y-8">
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-900">Nama Perusahaan</label>
                    <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan', $company->nama_perusahaan) }}" 
                           class="w-full bg-[#E5E7EB] border-none rounded-xl px-4 py-4 text-sm text-gray-700 focus:ring-2 focus:ring-blue-500 transition placeholder-gray-500"
                           placeholder="Masukkan Nama Perusahaan">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-900">Bentuk Usaha</label>
                    <input type="text" name="bidang_usaha" value="{{ old('bidang_usaha', $company->bidang_usaha) }}" 
                           class="w-full bg-[#E5E7EB] border-none rounded-xl px-4 py-4 text-sm text-gray-700 focus:ring-2 focus:ring-blue-500 transition placeholder-gray-500"
                           placeholder="Masukkan Bentuk Usaha">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-900">Email Perusahaan</label>
                    <input type="email" name="email_perusahaan" value="{{ old('email_perusahaan', $company->email) }}" 
                           class="w-full bg-[#E5E7EB] border-none rounded-xl px-4 py-4 text-sm text-gray-700 focus:ring-2 focus:ring-blue-500 transition placeholder-gray-500"
                           placeholder="Masukkan Email">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-900">Alamat Perusahaan</label>
                    <textarea name="deskripsi" rows="6" 
                              class="w-full bg-[#E5E7EB] border-none rounded-xl px-4 py-4 text-sm text-gray-700 focus:ring-2 focus:ring-blue-500 transition placeholder-gray-500 resize-none"
                              placeholder="Masukkan Alamat Lengkap">{{ old('deskripsi', $company->deskripsi) }}</textarea>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-900">Kota / Kabupaten</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi', $company->lokasi) }}" 
                           class="w-full bg-[#E5E7EB] border-none rounded-xl px-4 py-4 text-sm text-gray-700 focus:ring-2 focus:ring-blue-500 transition placeholder-gray-500"
                           placeholder="Masukkan Nama Kota">
                </div>

                <div class="flex justify-end gap-4 pt-4">
                    <a href="{{ route('perusahaan.dashboard') }}" 
                       class="px-10 py-3 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl transition shadow-lg shadow-blue-200">
                        Kembali
                    </a>
                    <button type="submit" 
                            class="px-10 py-3 bg-[#00C17C] hover:bg-emerald-600 text-white font-bold rounded-xl transition shadow-lg shadow-emerald-100">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>

        <footer class="mt-12 text-center text-gray-400 text-xs py-6 flex items-center justify-center gap-2">
            <span class="text-lg">©</span> 2025, Sistem Informasi Karier dan Portofolio
        </footer>
    </main>
</div>

<script>
    function previewImg(event, id) {
        const file = event.target.files && event.target.files[0]
        if (!file) return
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(id).src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
</script>
@endsection