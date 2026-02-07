@extends('layouts.app')

@section('title', 'Dokumen Saya')

@section('content')
<div class="flex min-h-screen bg-[#E5E7EB]">
    <aside class="w-64 bg-white border-r border-gray-300 hidden md:flex flex-col p-6 sticky top-0 h-screen">
        <div class="mb-10 px-2 font-bold text-2xl tracking-tighter italic text-gray-900">
            SIKAP<span class="text-xs font-normal align-top not-italic">.</span>
        </div>
        <nav class="flex-1 space-y-2 text-sm font-medium">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-200 transition">
                <span>🏠</span> Dashboard
            </a>
            <a href="{{ route('pelamar.profile.show') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-200 transition">
                <span>👤</span> Profile
            </a>
            <a href="{{ route('pelamar.portofolio.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-200 transition">
                <span>📂</span> Portofolio
            </a>
            <a href="{{ route('pelamar.applications.tracking') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-200 transition">
                <span>💼</span> Lamaran
            </a>
        </nav>
        <div class="mt-auto border-t border-gray-300 pt-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="flex items-center gap-3 w-full px-4 py-3 text-gray-600 hover:text-red-600 transition">
                    <span>🚪</span> Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 bg-[#4B4B4B] p-6 lg:p-10">
        <header class="flex justify-between items-center mb-10 text-white">
            <div>
                <h1 class="text-4xl font-black uppercase tracking-tight">DOKUMEN SAYA</h1>
                <p class="text-sm opacity-70">Kelola CV dan dokumen pendukung lamaranmu.</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm font-bold italic">{{ Auth::user()->name }}</span>
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-900 shadow-lg">
                    👤
                </div>
            </div>
        </header>

        <div class="bg-[#D1D5DB] rounded-[40px] p-8 mb-8 shadow-inner">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-[32px] p-8 flex flex-col items-center text-center shadow-sm">
                    <p class="font-bold text-gray-900 mb-6 uppercase tracking-wider">Curriculum Vitae (CV)</p>
                    <div class="mb-8">
                        <svg class="w-24 h-24 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20M13,13V18H15V13H13M9,13V18H11V13H9M9,10V12H15V10H9Z" />
                        </svg>
                    </div>
                    <button class="w-full bg-[#3498DB] hover:bg-blue-600 text-white font-bold py-3 rounded-xl transition shadow-md">
                        + Unggah File
                    </button>
                    <p class="mt-4 text-[10px] text-gray-400 font-bold uppercase">Max. Ukuran : 10 MB (PDF)</p>
                </div>

                <div class="bg-white rounded-[32px] p-8 flex flex-col items-center text-center shadow-sm">
                    <p class="font-bold text-gray-900 mb-6 uppercase tracking-wider">Surat Lamaran</p>
                    <div class="mb-8">
                        <svg class="w-24 h-24 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4M20,18H4V8L12,13L20,8V18M12,11L4,6H20L12,11Z" />
                        </svg>
                    </div>
                    <button class="w-full bg-[#3498DB] hover:bg-blue-600 text-white font-bold py-3 rounded-xl transition shadow-md">
                        + Unggah File
                    </button>
                    <p class="mt-4 text-[10px] text-gray-400 font-bold uppercase">Max. Ukuran : 10 MB (PDF)</p>
                </div>

                <div class="bg-white rounded-[32px] p-8 flex flex-col items-center text-center shadow-sm">
                    <p class="font-bold text-gray-900 mb-6 uppercase tracking-wider">Sertifikat Pendukung</p>
                    <div class="mb-8">
                        <svg class="w-24 h-24 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13,13H11V7H13M13,17H11V15H13M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                        </svg>
                    </div>
                    <button class="w-full bg-[#3498DB] hover:bg-blue-600 text-white font-bold py-3 rounded-xl transition shadow-md">
                        + Unggah File
                    </button>
                    <p class="mt-4 text-[10px] text-gray-400 font-bold uppercase">Max. Ukuran : 10 MB (PDF)</p>
                </div>
            </div>
        </div>

        <div class="bg-[#D1D5DB] rounded-[40px] p-8 shadow-inner">
            <h3 class="text-xl font-black text-gray-900 mb-6 uppercase tracking-tight">File Terunggah</h3>
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm">
                <div class="divide-y divide-gray-100">
                    {{-- Ganti bagian ini dengan @foreach data dokumen asli Anda --}}
                    @forelse($documents ?? [] as $doc)
                    <div class="flex items-center justify-between p-5 hover:bg-gray-50 transition">
                        <div class="flex items-center gap-4">
                            <span class="text-xl">📄</span>
                            <p class="text-sm font-bold text-gray-800 tracking-tight">{{ $doc->name }}</p>
                        </div>
                        <div class="flex items-center gap-6">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-tighter">{{ $doc->created_at->diffForHumans() }}</span>
                            <form method="POST" action="#">
                                @csrf @method('DELETE')
                                <button class="text-gray-400 hover:text-red-500 transition">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="p-10 text-center italic text-gray-400 font-medium">
                        Belum ada file yang diunggah.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <footer class="mt-12 text-center text-gray-400 text-xs py-6">
            © 2026, Sistem Informasi Karier dan Portofolio (SIKAP)
        </footer>
    </main>
</div>
@endsection