@extends('layouts.app')

@section('content')
@php
    $companyName = $company->nama_perusahaan ?? $company->nama ?? $company->name ?? '(nama perusahaan)';
    $companyInitial = strtoupper(mb_substr(trim((string) $companyName), 0, 1)) ?: 'P';
    
    // Konfigurasi Navigasi Sidebar
    $navBase = 'flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition duration-200';
    $navActive = 'bg-gray-800 text-white shadow-md';
    $navInactive = 'text-gray-600 hover:bg-gray-100';

    $menu = [
        ['label' => 'Dashboard', 'icon' => '🏠', 'href' => route('perusahaan.dashboard'), 'active' => 'perusahaan.dashboard'],
        ['label' => 'Profile', 'icon' => '👤', 'href' => route('perusahaan.company.edit'), 'active' => 'perusahaan.company.*'],
        ['label' => 'Kelola Akun HRD', 'icon' => '⚙️', 'href' => route('perusahaan.hrd.index'), 'active' => 'perusahaan.hrd.*'],
        ['label' => 'Lowongan', 'icon' => '💼', 'href' => '#', 'active' => 'perusahaan.jobs.*'],
        ['label' => 'Laporan Rekrutmen', 'icon' => '📊', 'href' => '#', 'active' => 'perusahaan.reports.*'],
    ];
@endphp

<div class="min-h-screen bg-[#F4F4F4] flex">
    <aside class="w-72 bg-white border-r border-gray-200 hidden lg:flex flex-col p-6 sticky top-0 h-screen">
        <div class="mb-10 px-2 font-bold text-2xl tracking-tighter italic">
            SIKAP<span class="text-xs font-normal align-top not-italic">.</span>
        </div>

        <nav class="flex-1 space-y-2">
            @foreach($menu as $item)
                @php $isActive = request()->routeIs($item['active']) || ($item['label'] == 'Kelola Akun HRD'); @endphp
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
                <div class="h-9 w-9 rounded-full bg-black text-white flex items-center justify-center text-xs ring-2 ring-white shadow-sm font-bold">
                    {{ $companyInitial }}
                </div>
            </div>
        </header>

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Tambahkan Akun HRD di perusahaan anda!</h1>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl bg-red-50 border border-red-100 p-5 text-sm text-red-800">
                <p class="font-bold mb-1">Terjadi kesalahan:</p>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('perusahaan.hrd.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold mb-6 text-gray-900">Foto Diri HRD</h2>
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="w-32 h-32 rounded-full bg-gray-200 flex-shrink-0"></div>
                    <div>
                        <label class="inline-flex items-center justify-center px-6 py-2.5 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-xl cursor-pointer transition shadow-md shadow-blue-100 gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Pilih Foto
                            <input type="file" name="profile_photo" class="hidden">
                        </label>
                        <p class="mt-3 text-xs text-gray-400 leading-relaxed">
                            Format .jpg, jpeg, .png<br>
                            Rekomendasi ukuran 1200px x 1200px, Ukuran max 2Mb
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-100">
                <div class="space-y-6 max-w-5xl">
                    <div class="grid grid-cols-1 md:grid-cols-3 items-center">
                        <label class="text-gray-900 font-medium">Nama Lengkap</label>
                        <div class="md:col-span-2">
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama Lengkap"
                                   class="w-full bg-[#E5E7EB] border-none rounded-xl px-4 py-4 text-sm focus:ring-2 focus:ring-blue-500 transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 items-center">
                        <label class="text-gray-900 font-medium">Email</label>
                        <div class="md:col-span-2">
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email"
                                   class="w-full bg-[#E5E7EB] border-none rounded-xl px-4 py-4 text-sm focus:ring-2 focus:ring-blue-500 transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 items-center">
                        <label class="text-gray-900 font-medium">Password</label>
                        <div class="md:col-span-2">
                            <input type="password" name="password" placeholder="Masukkan Password"
                                   class="w-full bg-[#E5E7EB] border-none rounded-xl px-4 py-4 text-sm focus:ring-2 focus:ring-blue-500 transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 items-center">
                        <label class="text-gray-900 font-medium">Jabatan</label>
                        <div class="md:col-span-2">
                            <input type="text" name="jabatan" value="{{ old('jabatan') }}" placeholder="Masukkan Jabatan"
                                   class="w-full bg-[#E5E7EB] border-none rounded-xl px-4 py-4 text-sm focus:ring-2 focus:ring-blue-500 transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 items-center">
                        <label class="text-gray-900 font-medium">Status</label>
                        <div class="md:col-span-2 relative">
                            <select name="status" class="w-full bg-[#E5E7EB] border-none rounded-xl px-4 py-4 text-sm focus:ring-2 focus:ring-blue-500 transition appearance-none">
                                <option value="1">Aktif</option>
                                <option value="0">Non-Aktif</option>
                            </select>
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 pt-6 justify-end">
                        <a href="{{ route('perusahaan.hrd.index') }}" 
                           class="px-10 py-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl transition text-center">
                            Kembali
                        </a>
                        <button type="submit" 
                                class="px-10 py-4 bg-[#00C17C] hover:bg-emerald-600 text-white font-bold rounded-xl transition shadow-lg shadow-emerald-100">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <footer class="mt-12 text-center text-gray-400 text-xs py-6 flex items-center justify-center gap-2">
            <span class="text-lg">©</span> 2025, Sistem Informasi Karier dan Portofolio
        </footer>
    </main>
</div>
@endsection