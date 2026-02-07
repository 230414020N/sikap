{{-- @extends('layouts.app')

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
            <div class="text-white">
                <a href="{{ route('pelamar.jobs.index') }}" class="flex items-center gap-2 text-sm opacity-80 hover:opacity-100 transition">
                    ← Kembali ke Daftar Lowongan
                </a>
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
                <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                    <div>
                        <span class="inline-block px-3 py-1 rounded-full bg-gray-900 text-white text-[10px] font-bold uppercase tracking-wider mb-3">
                            {{ $job->tipe }}
                        </span>
                        <h1 class="text-3xl font-bold text-gray-900 leading-tight">{{ $job->judul }}</h1>
                        <p class="text-lg text-[#00D1A0] font-semibold mt-1">{{ $job->company->nama }}</p>
                        <div class="flex items-center gap-4 mt-4 text-sm text-gray-500 font-medium">
                            <span class="flex items-center gap-1">📍 {{ $job->lokasi ?? 'Remote' }}</span>
                            <span class="flex items-center gap-1">🎓 {{ $job->level }}</span>
                            <span class="flex items-center gap-1">📁 {{ $job->kategori }}</span>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 text-center min-w-[140px]">
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">Deadline</p>
                        <p class="text-red-500 font-bold mt-1">
                            {{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('d M Y') : '—' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[32px] p-8 shadow-sm space-y-8">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-[#00D1A0] rounded-full"></span>
                        Deskripsi Pekerjaan
                    </h2>
                    <div class="text-gray-700 leading-relaxed whitespace-pre-line text-sm">
                        {{ $job->deskripsi ?? 'Tidak ada deskripsi spesifik.' }}
                    </div>
                </div>

                <hr class="border-gray-100">

                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-[#00D1A0] rounded-full"></span>
                        Kualifikasi
                    </h2>
                    <div class="text-gray-700 leading-relaxed whitespace-pre-line text-sm">
                        {{ $job->kualifikasi ?? 'Tidak ada kualifikasi spesifik.' }}
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-center gap-6 bg-white/30 backdrop-blur-md rounded-[32px] p-6 border border-white/20">
                <div class="text-gray-700">
                    <p class="text-xs font-bold uppercase opacity-60">Tertarik dengan posisi ini?</p>
                    <p class="text-sm">Pastikan profil dan portofolio kamu sudah lengkap.</p>
                </div>

                @if($alreadyApplied)
                    <button disabled class="bg-gray-400 text-white font-extrabold px-10 py-4 rounded-2xl cursor-not-allowed shadow-md uppercase tracking-tight">
                        Sudah Melamar
                    </button>
                @else
                    <a href="{{ route('pelamar.jobs.applyForm', $job->id) }}" 
                       class="bg-[#00D1A0] text-gray-900 font-extrabold px-10 py-4 rounded-2xl hover:bg-emerald-400 transition-all shadow-[0_4px_14px_0_rgba(0,209,160,0.4)] uppercase tracking-tight text-center">
                        Ajukan Lamaran Sekarang
                    </a>
                @endif
            </div>
        </div>

        <footer class="mt-20 text-center text-gray-400 text-xs py-6">
            © 2026, Sistem Informasi Karier dan Portofolio (SIKAP)
        </footer>
    </main>
</div>
@endsection --}}

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
            <div class="text-white">
                <a href="{{ route('pelamar.jobs.index') }}" class="flex items-center gap-2 text-sm opacity-80 hover:opacity-100 transition">
                    ← Kembali ke Daftar Lowongan
                </a>
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
                <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                    <div>
                        <span class="inline-block px-3 py-1 rounded-full bg-gray-900 text-white text-[10px] font-bold uppercase tracking-wider mb-3">
                            {{ $job->tipe }}
                        </span>
                        <h1 class="text-3xl font-bold text-gray-900 leading-tight">{{ $job->judul }}</h1>
                        <p class="text-lg text-[#00D1A0] font-semibold mt-1">{{ $job->company->nama }}</p>
                        <div class="flex items-center gap-4 mt-4 text-sm text-gray-500 font-medium">
                            <span class="flex items-center gap-1">📍 {{ $job->lokasi ?? 'Remote' }}</span>
                            <span class="flex items-center gap-1">🎓 {{ $job->level }}</span>
                            <span class="flex items-center gap-1">📁 {{ $job->kategori }}</span>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 text-center min-w-[140px]">
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">Deadline</p>
                        <p class="text-red-500 font-bold mt-1">
                            {{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('d M Y') : '—' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[32px] p-8 shadow-sm space-y-8">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-[#00D1A0] rounded-full"></span>
                        Deskripsi Pekerjaan
                    </h2>
                    <div class="text-gray-700 leading-relaxed whitespace-pre-line text-sm">
                        {{ $job->deskripsi ?? 'Tidak ada deskripsi spesifik.' }}
                    </div>
                </div>

                <hr class="border-gray-100">

                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-[#00D1A0] rounded-full"></span>
                        Kualifikasi
                    </h2>
                    <div class="text-gray-700 leading-relaxed whitespace-pre-line text-sm">
                        {{ $job->kualifikasi ?? 'Tidak ada kualifikasi spesifik.' }}
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[32px] p-8 shadow-sm border-t-8 border-[#00D1A0]">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        🏢 Tentang Perusahaan
                    </h2>
                    <a href="{{ route('perusahaan.company.edit', $job->company->id) }}" 
                       class="text-[10px] font-bold text-gray-500 border border-gray-300 px-3 py-1.5 rounded-lg hover:bg-gray-900 hover:text-white hover:border-gray-900 transition-all uppercase tracking-tighter">
                        Lihat Profil →
                    </a>
                </div>
                <div class="text-gray-600 text-sm leading-relaxed">
                    <p class="line-clamp-3">
                        {{ $job->company->deskripsi ?? 'Perusahaan ini bergerak di bidang ' . $job->kategori . ' dan berkomitmen untuk memberikan inovasi terbaik di industrinya.' }}
                    </p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-center gap-6 bg-white/30 backdrop-blur-md rounded-[32px] p-6 border border-white/20">
                <div class="text-gray-700">
                    <p class="text-xs font-bold uppercase opacity-60">Tertarik dengan posisi ini?</p>
                    <p class="text-sm">Pastikan profil dan portofolio kamu sudah lengkap.</p>
                </div>

                @if($alreadyApplied)
                    <button disabled class="bg-gray-400 text-white font-extrabold px-10 py-4 rounded-2xl cursor-not-allowed shadow-md uppercase tracking-tight">
                        Sudah Melamar
                    </button>
                @else
                    <a href="{{ route('pelamar.jobs.applyForm', $job->id) }}" 
                       class="bg-[#00D1A0] text-gray-900 font-extrabold px-10 py-4 rounded-2xl hover:bg-emerald-400 transition-all shadow-[0_4px_14px_0_rgba(0,209,160,0.4)] uppercase tracking-tight text-center">
                        Ajukan Lamaran Sekarang
                    </a>
                @endif
            </div>
        </div>

        <footer class="mt-20 text-center text-gray-400 text-xs py-6">
            © 2026, Sistem Informasi Karier dan Portofolio (SIKAP)
        </footer>
    </main>
</div>
@endsection