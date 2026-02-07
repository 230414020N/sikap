@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-[#E5E7EB]">
    <aside class="w-64 bg-[#E5E7EB] border-r border-gray-300 hidden md:flex flex-col p-6 sticky top-0 h-screen">
        <div class="mb-10 px-2 font-bold text-2xl tracking-tighter italic text-gray-900">
            SIKAP<span class="text-xs font-normal align-top not-italic">.</span>
        </div>
        <nav class="flex-1 space-y-2">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-200 transition">
                <span>🏠</span> Dashboard
            </a>
            <a href="{{ route('pelamar.portofolio.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium bg-[#4B4B4B] text-white shadow-md transition">
                <span>📂</span> Project
            </a>
            </nav>
        <div class="pt-10 border-t border-gray-300">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-sm font-medium text-gray-600 hover:text-red-600 transition">
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
            <div class="flex items-center gap-4 text-white">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-medium">({{ Auth::user()->name }})</span>
                    <div class="w-8 h-8 rounded-full bg-black flex items-center justify-center text-xs border border-gray-600">👤</div>
                </div>
            </div>
        </header>

        <div class="max-w-4xl mx-auto bg-[#D1D5DB] rounded-[40px] p-8 lg:p-12 shadow-xl space-y-6">
            
            <div class="bg-white rounded-[32px] p-8 shadow-sm">
                <div class="mb-6">
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $portofolio->judul }}</h1>
                    <p class="text-gray-500 mt-1">Dibuat Oleh {{ Auth::user()->name }}</p>
                </div>

                <div class="flex flex-col lg:flex-row gap-8 items-center">
                    <div class="w-full lg:w-2/3 aspect-video rounded-2xl overflow-hidden bg-gray-100 border border-gray-200">
                        @if($portofolio->thumbnail_path)
                            <img src="{{ asset('storage/' . $portofolio->thumbnail_path) }}" alt="{{ $portofolio->judul }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                        @endif
                    </div>

                    <div class="flex items-center gap-3">
                        <svg class="w-10 h-10 text-gray-900 fill-current" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        <span class="text-2xl font-bold text-gray-900">17 Likes</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[32px] p-8 shadow-sm">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Deskripsi Proyek</h2>
                <p class="text-gray-700 leading-relaxed italic">
                    {{ $portofolio->deskripsi ?? 'Tidak ada deskripsi.' }}
                </p>
            </div>

            <div class="bg-white rounded-[32px] p-8 shadow-sm">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Link Proyek</h2>
                <div class="flex items-center gap-3 text-gray-700">
                    <span>🔗</span>
                    <a href="{{ $portofolio->link_github }}" target="_blank" class="hover:underline break-all">
                        {{ $portofolio->link_github ?? '-' }}
                    </a>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <a href="{{ route('pelamar.portofolio.index') }}" class="bg-[#00D1A0] text-gray-900 font-extrabold px-10 py-3 rounded-2xl hover:bg-emerald-400 transition-all shadow-md uppercase tracking-tight">
                    Kembali Ke Portofolio
                </a>
            </div>
        </div>

        <footer class="mt-20 text-center text-gray-400 text-xs py-6">
            © 2025, Sistem Informasi Karier dan Portofolio
        </footer>
    </main>
</div>
@endsection