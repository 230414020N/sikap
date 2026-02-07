@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-[#E5E7EB]">
    <aside class="w-64 bg-white border-r border-gray-300 hidden md:flex flex-col p-6 sticky top-0 h-screen">
        <div class="mb-10 px-2 font-bold text-2xl tracking-tighter italic">
            SIKAP<span class="text-xs font-normal align-top not-italic">.</span>
        </div>

        <nav class="flex-1 space-y-2">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-200 transition">
                <span>🏠</span> Dashboard
            </a>
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-200 transition">
                <span>👤</span> Profile
            </a>
            <a href="#" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-200 transition">
                <span>📂</span> Dokumen
            </a>
            <a href="#" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-200 transition">
                <span>📂</span> Project
            </a>
            <a href="{{ route('pelamar.applications.tracking') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium bg-[#4B4B4B] text-white shadow-md transition">
                <span>💼</span> Lamaran
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

    <main class="flex-1 bg-[#4B4B4B] p-6 lg:p-10 overflow-y-auto">
        <header class="flex justify-between items-center mb-10">
            <div class="relative w-72">
                <input type="text" placeholder="Cari Lowongan Pekerjaan" class="w-full bg-gray-200 border-none rounded-xl py-2 px-4 text-sm focus:ring-0">
            </div>
            <div class="flex items-center gap-4">
                <button class="text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </button>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-white font-medium">({{ Auth::user()->name }})</span>
                    <div class="w-8 h-8 rounded-full bg-black flex items-center justify-center text-white text-xs border border-gray-600">👤</div>
                </div>
            </div>
        </header>

        <div class="mb-10">
            <h1 class="text-3xl font-bold text-white">Lamaran Saya</h1>
            <p class="text-gray-300 text-sm mt-1">Pantau status lamaran pekerjaanmu disini.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-2xl bg-gray-800 text-white p-4 text-sm border border-gray-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-[32px] p-8 shadow-xl min-h-[500px]">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-gray-900 border-b border-gray-100">
                        <th class="pb-6 font-bold text-sm text-center">Lamaran / Nama Perusahaan</th>
                        <th class="pb-6 font-bold text-sm text-center">Tanggal Kirim</th>
                        <th class="pb-6 font-bold text-sm text-center">Status</th>
                        <th class="pb-6 font-bold text-sm text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($applications as $app)
                        <tr>
                            <td class="py-6 text-center">
                                <div class="font-bold text-gray-900">{{ $app->job->judul }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">di {{ $app->job->company->nama ?? 'PT. Perusahaan' }}</div>
                            </td>
                            <td class="py-6 text-center text-gray-900 font-medium">
                                {{ $app->created_at->format('d F Y') }}
                            </td>
                            <td class="py-6 text-center">
                                <span class="font-bold text-sm {{ $app->status == 'Ditolak' ? 'text-gray-900' : 'text-gray-900' }}">
                                    {{ $app->status }}
                                </span>
                            </td>
                            <td class="py-6 text-center">
                                <a href="{{ route('pelamar.applications.show', $app->id) }}" class="inline-flex items-center gap-2 bg-[#5569FF] text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-[#4455dd] transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-20 text-center text-gray-400 italic">
                                Belum ada lamaran yang dikirim.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-8">
                {{ $applications->links() }}
            </div>
        </div>

        <footer class="mt-16 text-center text-gray-400 text-xs py-6">
            <div class="flex items-center justify-center gap-2">
                <span class="inline-block w-5 h-5 rounded-full border border-gray-500 flex items-center justify-center text-[10px]">C</span>
                2025, Sistem Informasi Karier dan Portofolio
            </div>
        </footer>
    </main>
</div>
@endsection