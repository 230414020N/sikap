@extends('layouts.app')

@section('content')
@php
    // Logic untuk inisial dan nama perusahaan di sidebar/header
    $companyName = Auth::user()->perusahaan->nama_perusahaan ?? '(nama perusahaan)';
    $companyInitial = strtoupper(mb_substr(trim($companyName), 0, 1)) ?: 'P';
    
    $navBase = 'flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition duration-200';
    $navActive = 'bg-gray-800 text-white shadow-md';
    $navInactive = 'text-gray-600 hover:bg-gray-100';
@endphp

<div class="min-h-screen bg-[#F4F4F4] flex">
    <aside class="w-72 bg-[#E5E7EB] border-r border-gray-200 hidden lg:flex flex-col p-6 sticky top-0 h-screen">
        <div class="mb-10 px-2 font-bold text-2xl tracking-tighter italic">
            SIKAP<span class="text-xs font-normal align-top not-italic">.</span>
        </div>

        <nav class="flex-1 space-y-2">
            <a href="{{ route('perusahaan.dashboard') }}" class="{{ request()->routeIs('perusahaan.dashboard') ? $navActive : $navInactive }} {{ $navBase }}">
                <span>🏠</span> Dashboard
            </a>
            <a href="{{ route('perusahaan.company.edit') }}" class="{{ request()->routeIs('perusahaan.company.*') ? $navActive : $navInactive }} {{ $navBase }}">
                <span>👤</span> Profile
            </a>
            <a href="{{ route('perusahaan.hrd.index') }}" class="{{ request()->routeIs('perusahaan.hrd.*') ? $navActive : $navInactive }} {{ $navBase }}">
                <span>⚙️</span> Kelola Akun HRD
            </a>
            <a href="#" class="text-gray-600 hover:bg-gray-100 {{ $navBase }}">
                <span>💼</span> Lowongan
            </a>
            <a href="#" class="text-gray-600 hover:bg-gray-100 {{ $navBase }}">
                <span>📊</span> Laporan Rekrutmen
            </a>
        </nav>

        <div class="mt-auto pt-6 border-t border-gray-300">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-200 rounded-xl w-full transition text-left">
                    <span>🚪</span> Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-6 lg:p-10">
        <header class="flex justify-end items-center mb-10 gap-6">
            <button class="text-gray-800">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </button>
            <div class="flex items-center gap-3">
                <span class="text-sm font-medium text-gray-700">({{ $companyName }})</span>
                <div class="h-10 w-10 rounded-full bg-black text-white flex items-center justify-center text-sm font-bold shadow-sm">
                    {{ $companyInitial }}
                </div>
            </div>
        </header>

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white drop-shadow-sm">Perbaharui Akun HRD di perusahaan anda!</h1>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl bg-red-50 border border-red-100 p-4 text-sm text-red-800">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-[32px] p-10 shadow-sm border border-gray-100 max-w-6xl">
            <form method="POST" action="{{ route('perusahaan.hrd.update', $hrd->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 items-center">
                    <label class="text-gray-900 font-medium">Nama Lengkap</label>
                    <div class="md:col-span-2">
                        <input type="text" name="name" value="{{ old('name', $hrd->name) }}" placeholder="Masukkan Nama Lengkap"
                               class="w-full bg-[#E5E7EB] border-none rounded-xl px-5 py-4 text-sm focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 items-center">
                    <label class="text-gray-900 font-medium">Email</label>
                    <div class="md:col-span-2">
                        <input type="email" name="email" value="{{ old('email', $hrd->email) }}" placeholder="Masukkan Email"
                               class="w-full bg-[#E5E7EB] border-none rounded-xl px-5 py-4 text-sm focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 items-center">
                    <label class="text-gray-900 font-medium">Password</label>
                    <div class="md:col-span-2">
                        <input type="password" name="password" placeholder="Masukkan Password"
                               class="w-full bg-[#E5E7EB] border-none rounded-xl px-5 py-4 text-sm focus:ring-2 focus:ring-blue-500 transition">
                        <p class="mt-1 text-[10px] text-gray-400 font-medium italic">*Kosongkan jika tidak ingin mengganti password</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 items-center">
                    <label class="text-gray-900 font-medium">Konfirmasi Password</label>
                    <div class="md:col-span-2">
                        <input type="password" name="password_confirmation" placeholder="Ketikkan Password yang Sama"
                               class="w-full bg-[#E5E7EB] border-none rounded-xl px-5 py-4 text-sm focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 items-center">
                    <label class="text-gray-900 font-medium">Jabatan</label>
                    <div class="md:col-span-2">
                        <input type="text" name="jabatan" value="{{ old('jabatan', $hrd->jabatan ?? '') }}" placeholder="Masukkan Jabatan"
                               class="w-full bg-[#E5E7EB] border-none rounded-xl px-5 py-4 text-sm focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 items-center">
                    <label class="text-gray-900 font-medium">Status</label>
                    <div class="md:col-span-2 relative">
                        <select name="status" class="w-full bg-[#E5E7EB] border-none rounded-xl px-5 py-4 text-sm focus:ring-2 focus:ring-blue-500 transition appearance-none">
                            <option value="1" {{ $hrd->status == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ $hrd->status == 0 ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-10 justify-end">
                    <a href="{{ route('perusahaan.hrd.index') }}" 
                       class="px-12 py-4 bg-[#3B82F6] hover:bg-blue-600 text-white font-bold rounded-xl transition text-center min-w-[160px]">
                        Kembali
                    </a>
                    <button type="submit" 
                            class="px-12 py-4 bg-[#10B981] hover:bg-emerald-600 text-white font-bold rounded-xl transition shadow-lg shadow-emerald-100 min-w-[160px]">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-8 border-t border-gray-100">
                <form method="POST" action="{{ route('perusahaan.hrd.destroy', $hrd->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="text-red-500 hover:text-red-700 text-sm font-medium underline transition"
                            onclick="return confirm('Hapus akun HRD ini secara permanen?')">
                        Hapus Akun HRD
                    </button>
                </form>
            </div>
        </div>

        <footer class="mt-12 text-center text-gray-500 text-xs py-6">
            <div class="flex items-center justify-center gap-2">
                <span class="text-lg">©</span> 2025, Sistem Informasi Karier dan Portofolio
            </div>
        </footer>
    </main>
</div>
@endsection