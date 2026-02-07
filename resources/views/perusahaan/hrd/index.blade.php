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
            <h1 class="text-3xl font-bold text-gray-900">Kelola Akun HRD</h1>
            <p class="text-gray-600 mt-1 text-lg">Kelola akun HRD untuk mengatur akses dan peran di sistem rekrutmen perusahaan.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-100 p-4 text-emerald-800 text-sm flex items-center gap-3">
                <span>✅</span> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8 space-y-6">
                <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
                    <div class="w-full md:w-2/3">
                        <input type="text" placeholder="Cari Nama HRD" 
                               class="w-full bg-[#E5E7EB] border-none rounded-xl px-6 py-4 text-sm text-gray-700 focus:ring-2 focus:ring-blue-500 transition placeholder-gray-500">
                    </div>
                    <a href="{{ route('perusahaan.hrd.create') }}" 
                       class="w-full md:w-auto px-8 py-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl transition shadow-lg shadow-blue-100 flex items-center justify-center gap-2">
                        + Akun HRD
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="pb-4 font-bold text-gray-900 text-center w-12">No</th>
                                <th class="pb-4 font-bold text-gray-900 px-4">Nama HRD</th>
                                <th class="pb-4 font-bold text-gray-900 px-4 text-center">Email</th>
                                <th class="pb-4 font-bold text-gray-900 px-4 text-center">Status</th>
                                <th class="pb-4 font-bold text-gray-900 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($hrdUsers as $index => $hrd)
                                @php
                                    $isActivated = !empty($hrd->email_verified_at);
                                @endphp
                                <tr>
                                    <td class="py-6 text-center text-gray-700 text-sm">
                                        {{ $hrdUsers->firstItem() + $index }}
                                    </td>
                                    <td class="py-6 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 border border-gray-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            </div>
                                            <span class="font-semibold text-gray-900">{{ $hrd->name ?? 'HRD' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-6 px-4 text-center text-gray-600 text-sm">
                                        {{ $hrd->email }}
                                    </td>
                                    <td class="py-6 px-4 text-center">
                                        <span class="px-5 py-1.5 rounded-full text-xs font-bold {{ $isActivated ? 'bg-[#00C17C] text-white' : 'bg-red-500 text-white' }}">
                                            {{ $isActivated ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                    </td>
                                    <td class="py-6 px-4">
                                        <div class="flex items-center justify-center gap-3">
                                            <a href="{{ route('perusahaan.hrd.edit', $hrd->id) }}" class="p-2 text-gray-600 hover:text-blue-600 transition">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </a>
                                            <form method="POST" action="{{ route('perusahaan.hrd.destroy', $hrd->id) }}" onsubmit="return confirm('Hapus akun HRD ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-gray-600 hover:text-red-600 transition">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-gray-500 italic">
                                        Belum ada data HRD tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pt-6 border-t border-gray-100">
                    {{ $hrdUsers->links() }}
                </div>
            </div>
        </div>

        <footer class="mt-12 text-center text-gray-400 text-xs py-6 flex items-center justify-center gap-2">
            <span class="text-lg">©</span> 2025, Sistem Informasi Karier dan Portofolio
        </footer>
    </main>
</div>
@endsection