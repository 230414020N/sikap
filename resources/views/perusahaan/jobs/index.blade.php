@extends('layouts.app')

@section('content')
@php
    // Logic untuk inisial dan nama perusahaan
    $companyName = Auth::user()->perusahaan->nama_perusahaan ?? '(nama perusahaan)';
    $companyInitial = strtoupper(mb_substr(trim($companyName), 0, 1)) ?: 'P';
    
    // Konfigurasi Navigasi Sidebar
    $navBase = 'flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition duration-200';
    $navActive = 'bg-gray-800 text-white shadow-md';
    $navInactive = 'text-gray-600 hover:bg-gray-200';
@endphp

<div class="min-h-screen bg-[#F4F4F4] flex">
    <aside class="w-72 bg-white border-r border-gray-200 hidden lg:flex flex-col p-6 sticky top-0 h-screen">
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
            <a href="{{ route('perusahaan.jobs.index') }}" class="{{ request()->routeIs('perusahaan.jobs.*') ? $navActive : $navInactive }} {{ $navBase }}">
                <span>💼</span> Lowongan
            </a>
            <a href="#" class="text-gray-600 hover:bg-gray-200 {{ $navBase }}">
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

        <div class="mb-4">
            <h1 class="text-3xl font-bold text-gray-900">Lowongan Perusahaan</h1>
            <p class="text-gray-600 text-sm mt-1">Pantau seluruh lowongan pekerjaan yang dibuat oleh akun HRD di bawah perusahaan.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-2xl bg-green-50 border border-green-100 p-4 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-[#BDE9FF] rounded-[24px] p-6 flex items-center justify-between border border-blue-100 shadow-sm">
                <div>
                    <p class="text-[#0086C9] font-bold text-sm">Total Lowongan</p>
                    <p class="text-5xl font-bold text-[#0086C9] mt-2">{{ $jobs->total() }}</p>
                </div>
                <div class="bg-white/40 p-3 rounded-2xl text-2xl">❓</div>
            </div>
            <div class="bg-[#D1FFD0] rounded-[24px] p-6 flex items-center justify-between border border-green-100 shadow-sm">
                <div>
                    <p class="text-[#107C10] font-bold text-sm">Lowongan Aktif</p>
                    <p class="text-5xl font-bold text-[#107C10] mt-2">{{ $jobs->where('status', 'Aktif')->count() }}</p>
                </div>
                <div class="bg-white/40 p-3 rounded-2xl text-2xl">✅</div>
            </div>
            <div class="bg-[#FFBDBB] rounded-[24px] p-6 flex items-center justify-between border border-red-100 shadow-sm">
                <div>
                    <p class="text-[#C42B1C] font-bold text-sm">Lowongan Tidak Aktif</p>
                    <p class="text-5xl font-bold text-[#C42B1C] mt-2">{{ $jobs->where('status', '!=', 'Aktif')->count() }}</p>
                </div>
                <div class="bg-white/40 p-3 rounded-2xl text-2xl">❗️</div>
            </div>
        </div>

        <div class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-100 min-h-[500px]">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-gray-900 border-b border-gray-200">
                        <th class="pb-6 font-bold text-sm">Posisi Lowongan</th>
                        <th class="pb-6 font-bold text-sm">Departemen / Divisi</th>
                        <th class="pb-6 font-bold text-sm">HRD Penanggung Jawab</th>
                        <th class="pb-6 font-bold text-sm text-center">Status</th>
                        <th class="pb-6 font-bold text-sm text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($jobs as $job)
                        <tr class="group hover:bg-gray-50/50 transition duration-150">
                            <td class="py-5 font-medium text-gray-900 text-sm">
                                {{ $job->judul ?? $job->title ?? 'Lowongan' }}
                            </td>
                            <td class="py-5 text-gray-600 text-sm">
                                {{ $job->lokasi ?? $job->location ?? 'Umum' }}
                            </td>
                            <td class="py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full border-2 border-gray-200 flex items-center justify-center text-xs">👤</div>
                                    <span class="text-sm text-gray-900">{{ $job->user->name ?? 'Admin' }}</span>
                                </div>
                            </td>
                            <td class="py-5 text-center">
                                @if(($job->status ?? 'Aktif') == 'Aktif')
                                    <span class="bg-[#10B981] text-white text-[10px] font-bold px-4 py-1.5 rounded-full uppercase tracking-wider">Aktif</span>
                                @else
                                    <span class="bg-red-500 text-white text-[10px] font-bold px-4 py-1.5 rounded-full uppercase tracking-wider">Tutup</span>
                                @endif
                            </td>
                            <td class="py-5">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('perusahaan.jobs.edit', $job->id) }}" class="flex items-center gap-1.5 bg-blue-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-blue-600 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Lihat Detail
                                    </a>
                                    <form method="POST" action="{{ route('perusahaan.jobs.destroy', $job->id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus lowongan ini?')" class="p-1.5 text-gray-400 hover:text-red-500 transition">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-20 text-center text-gray-400 italic">
                                Belum ada lowongan yang dibuat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-8">
                {{ $jobs->links() }}
            </div>
        </div>

        <footer class="mt-12 text-center text-gray-500 text-xs py-6 flex items-center justify-center gap-2">
            <span class="text-lg">©</span> 2025, Sistem Informasi Karier dan Portofolio
        </footer>
    </main>
</div>
@endsection