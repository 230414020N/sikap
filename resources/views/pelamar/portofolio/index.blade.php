@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-[#E5E7EB]">
    <aside class="w-64 bg-white border-r border-gray-300 hidden md:flex flex-col p-6 sticky top-0 h-screen">
        <div class="mb-10 px-2 font-bold text-2xl tracking-tighter italic text-gray-900">
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
            <a href="{{ route('pelamar.portofolio.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium bg-[#4B4B4B] text-white shadow-md transition">
                <span>📂</span> Portofolio
            </a>
            <a href="{{ route('pelamar.applications.tracking') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-200 transition">
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
            <h1 class="text-4xl font-bold text-white uppercase tracking-tight">PROJECT SHOWCASE</h1>
            <p class="text-gray-300 text-sm mt-1">Tampilkan karya terbaikmu untuk menarik perhatian perusahaan.</p>
        </div>

        <div class="mb-8">
            <a href="{{ route('pelamar.portofolio.create') }}" class="inline-flex items-center bg-[#3399FF] text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-600 transition shadow-lg">
                + Tambah Project
            </a>
        </div>

        <div class="bg-[#D1D5DB] rounded-[32px] p-10 shadow-inner min-h-[600px]">
            <h2 class="text-2xl font-bold text-gray-800 mb-8">Portofolio Proyek Saya</h2>
            
            @if(session('success'))
                <div class="mb-6 rounded-xl bg-green-500 text-white p-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($portofolios as $p)
                    <div class="bg-white rounded-[24px] overflow-hidden shadow-sm flex flex-col h-full border border-gray-100">
                        <div class="relative h-48 w-full bg-gray-100">
                            @if($p->thumbnail_path)
                                <img src="{{ asset('storage/' . $p->thumbnail_path) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                    <span class="text-4xl">🖼️</span>
                                    <span class="text-xs mt-2 italic">Tanpa Gambar</span>
                                </div>
                            @endif
                        </div>

                        <div class="p-6 flex-1 flex flex-col items-center text-center">
                            <h3 class="text-lg font-extrabold text-gray-900 leading-tight mb-2 truncate w-full">
                                {{ $p->judul }}
                            </h3>
                            <p class="text-xs text-gray-500 flex items-center gap-2 mb-6">
                                <span class="p-1 bg-gray-100 rounded">📂</span> Oleh : {{ Auth::user()->name }}
                            </p>

                            <div class="flex items-center gap-2 mt-auto w-full justify-center">
                                <a href="{{ route('pelamar.portofolio.show', $p->id) }}" class="bg-[#3D5AFE] text-white text-[10px] font-bold px-4 py-1.5 rounded-lg hover:bg-blue-700 transition">
                                    🔍 Detail
                                </a>
                                <a href="{{ route('pelamar.portofolio.edit', $p->id) }}" class="bg-[#FFC107] text-gray-900 text-[10px] font-bold px-4 py-1.5 rounded-lg hover:bg-yellow-500 transition">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('pelamar.portofolio.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus portofolio ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-[#F44336] text-white text-[10px] font-bold px-4 py-1.5 rounded-lg hover:bg-red-700 transition">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center text-gray-500 italic">
                        Belum ada portofolio yang ditambahkan.
                    </div>
                @endforelse
            </div>

            @if(method_exists($portofolios, 'links'))
                <div class="mt-12">
                    {{ $portofolios->links() }}
                </div>
            @endif
        </div>

        <footer class="mt-16 text-center text-gray-400 text-xs py-6">
            <div class="flex items-center justify-center gap-2">
                <span class="inline-flex w-5 h-5 rounded-full border border-gray-500 items-center justify-center text-[10px]">C</span>
                2025, Sistem Informasi Karier dan Portofolio
            </div>
        </footer>
    </main>
</div>
@endsection