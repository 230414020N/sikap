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
            <a href="{{ route('pelamar.jobs.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium bg-[#4B4B4B] text-white shadow-md transition">
                <span>🔍</span> Cari Lowongan
            </a>
            <a href="{{ route('pelamar.portofolio.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-200 transition">
                <span>📂</span> Portofolio
            </a>
        </nav>
    </aside>

    <main class="flex-1 bg-[#4B4B4B] p-6 lg:p-10 overflow-y-auto">
        <header class="flex justify-between items-center mb-10">
            <form action="{{ route('pelamar.jobs.index') }}" method="GET" class="relative w-full max-w-xl">
                <input type="text" name="q" value="{{ request('q') }}" 
                    placeholder="Cari Lowongan Pekerjaan (Contoh: UI/UX, Backend)" 
                    class="w-full bg-gray-200 border-none rounded-2xl py-3 px-6 text-sm focus:ring-2 focus:ring-[#00D1A0] transition shadow-inner">
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-800">
                    🔍
                </button>
            </form>
            <div class="flex items-center gap-4 text-white ml-4">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-medium hidden sm:inline">({{ Auth::user()->name }})</span>
                    <div class="w-10 h-10 rounded-full bg-black flex items-center justify-center text-xs border border-gray-600 shadow-lg">👤</div>
                </div>
            </div>
        </header>

        <div class="bg-[#D1D5DB] rounded-[40px] p-8 lg:p-10 shadow-2xl min-h-[80vh]">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Cari Lowongan</h1>
                    <p class="text-gray-600 text-sm mt-1">Temukan peluang karier yang sesuai dengan keahlianmu.</p>
                </div>
                
                <div class="flex gap-2">
                    <span class="bg-white/50 px-4 py-2 rounded-full text-xs font-semibold text-gray-700 border border-gray-300">
                        Total: {{ $jobs->total() }} Lowongan
                    </span>
                </div>
            </div>

            <form method="GET" action="{{ route('pelamar.jobs.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
                    <input name="lokasi" value="{{ request('lokasi') }}" placeholder="📍 Lokasi" class="w-full border-none px-4 py-3 text-sm focus:ring-0">
                </div>

                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
                    <select name="tipe" class="w-full border-none px-4 py-3 text-sm focus:ring-0 text-gray-600">
                        <option value="">💼 Semua Tipe</option>
                        @foreach(['Full-time','Part-time','Internship'] as $t)
                            <option value="{{ $t }}" @selected(request('tipe')==$t)>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
                    <select name="level" class="w-full border-none px-4 py-3 text-sm focus:ring-0 text-gray-600">
                        <option value="">📊 Semua Level</option>
                        @foreach(['Junior','Mid','Senior'] as $l)
                            <option value="{{ $l }}" @selected(request('level')==$l)>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-black text-white rounded-xl text-sm font-bold hover:bg-gray-800 transition shadow-lg">
                        Filter
                    </button>
                    <a href="{{ route('pelamar.jobs.index') }}" class="p-3 bg-white text-gray-600 rounded-xl border border-gray-300 hover:bg-gray-50 transition shadow-sm">
                        🔄
                    </a>
                </div>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($jobs as $job)
                    <a href="{{ route('pelamar.jobs.show', $job->id) }}" class="group bg-white rounded-3xl p-6 shadow-sm border-2 border-transparent hover:border-[#00D1A0] transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <div class="bg-gray-100 p-3 rounded-2xl group-hover:bg-[#00D1A0]/10 transition">
                                    <span class="text-2xl">🏢</span>
                                </div>
                                <span class="text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-[#4B4B4B] text-white">
                                    {{ $job->tipe }}
                                </span>
                            </div>
                            
                            <h2 class="text-xl font-bold text-gray-900 group-hover:text-[#00D1A0] transition leading-tight">
                                {{ $job->judul }}
                            </h2>
                            <p class="text-sm font-medium text-gray-500 mt-1">{{ $job->company->nama }}</p>
                            
                            <div class="flex flex-wrap gap-2 mt-4">
                                <span class="text-[11px] bg-gray-100 text-gray-600 px-2 py-1 rounded-md border border-gray-200">📍 {{ $job->lokasi }}</span>
                                <span class="text-[11px] bg-gray-100 text-gray-600 px-2 py-1 rounded-md border border-gray-200">🎓 {{ $job->level }}</span>
                                <span class="text-[11px] bg-gray-100 text-gray-600 px-2 py-1 rounded-md border border-gray-200">📁 {{ $job->kategori }}</span>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-xs font-bold text-red-500">
                                ⌛ Deadline: {{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}
                            </span>
                            <span class="text-[#00D1A0] font-bold text-sm group-hover:translate-x-1 transition-transform">
                                Detail →
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="text-6xl mb-4">🍃</div>
                        <h3 class="text-xl font-bold text-gray-800">Lowongan tidak ditemukan</h3>
                        <p class="text-gray-500">Coba ubah kata kunci atau filter pencarianmu.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $jobs->appends(request()->query())->links() }}
            </div>
        </div>

        <footer class="mt-16 text-center text-gray-400 text-xs py-6">
            © 2026, Sistem Informasi Karier dan Portofolio (SIKAP)
        </footer>
    </main>
</div>

<style>
    /* Custom style untuk menyamakan pagination dengan tema SIKAP */
    .pagination { @apply flex justify-center gap-2; }
    .page-item.active .page-link { @apply bg-[#00D1A0] border-[#00D1A0] text-gray-900 font-bold rounded-xl; }
    .page-link { @apply rounded-xl border-none bg-white text-gray-600 shadow-sm; }
</style>
@endsection