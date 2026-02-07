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
            <a href="{{ route('pelamar.jobs.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-200 transition">
                <span>🔍</span> Cari Lowongan
            </a>
            <a href="{{ route('pelamar.portofolio.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-200 transition">
                <span>📂</span> Portofolio
            </a>
            <a href="{{ route('pelamar.profile.show') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium bg-[#4B4B4B] text-white shadow-md transition">
                <span>👤</span> Profil Saya
            </a>
        </nav>
    </aside>

    <main class="flex-1 bg-[#4B4B4B] p-6 lg:p-10 overflow-y-auto">
        <header class="flex justify-between items-center mb-10">
            <div class="text-white">
                <h1 class="text-2xl font-bold tracking-tight">Profil Profesional</h1>
                <p class="text-sm opacity-70">Bagaimana perusahaan melihat profil Anda.</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="/profile/edit/{{ Auth::user()->id }}" class="bg-[#00D1A0] text-gray-900 px-5 py-2.5 rounded-xl text-xs font-bold uppercase hover:bg-emerald-400 transition shadow-lg">
                    Edit Profil
                </a>
            </div>
        </header>

        <div class="max-w-4xl mx-auto bg-[#D1D5DB] rounded-[40px] p-8 lg:p-12 shadow-xl space-y-6">
            
            <div class="bg-white rounded-[32px] p-8 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-[#00D1A0]/10 rounded-full -mr-16 -mt-16"></div>
                
                <div class="flex flex-col md:flex-row gap-8 items-center md:items-start relative">
                    <div class="w-32 h-32 rounded-[2.5rem] overflow-hidden border-4 border-[#E5E7EB] shadow-lg flex-shrink-0">
                        <img src="{{ $profile->foto_path ? asset('storage/'.$profile->foto_path) : asset('images/avatar.jpg') }}" class="w-full h-full object-cover" alt="Foto Profil">
                    </div>
                    
                    <div class="flex-1 text-center md:text-left">
                        <h2 class="text-3xl font-black text-gray-900 leading-tight">{{ $profile->nama_lengkap ?? Auth::user()->name }}</h2>
                        <p class="text-[#00D1A0] font-bold text-lg">{{ $profile->headline ?? 'Pekerjaan Belum Diatur' }}</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-3 gap-x-6 mt-6 text-sm">
                            <div class="flex items-center gap-3 text-gray-600">
                                <span class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-xs">📧</span>
                                <span class="font-medium">{{ Auth::user()->email }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-gray-600">
                                <span class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-xs">📞</span>
                                <span class="font-medium">{{ $profile->no_hp ?? '-' }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-gray-600 md:col-span-2">
                                <span class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-xs">📍</span>
                                <span class="font-medium">{{ $profile->alamat ?? 'Alamat belum dilengkapi' }}, {{ $profile->domisili ?? '' }}</span>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-wrap justify-center md:justify-start gap-2">
                            <span class="px-4 py-1.5 bg-gray-900 text-white rounded-full text-[10px] font-bold uppercase tracking-wider">
                                {{ ucfirst($profile->jenis_kelamin ?? '—') }}
                            </span>
                            <span class="px-4 py-1.5 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                Aktif Mencari Kerja
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[32px] p-8 shadow-sm">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="w-1.5 h-6 bg-[#00D1A0] rounded-full"></span> Keahlian & Kompetensi
                </h3>
                <div class="flex flex-wrap gap-2">
                    @php
                        $skills = is_array($profile->keterampilan) ? $profile->keterampilan : json_decode($profile->keterampilan ?? '[]', true);
                    @endphp
                    @forelse($skills as $skill)
                        <span class="px-5 py-2.5 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-semibold text-gray-700">
                            {{ $skill }}
                        </span>
                    @empty
                        <p class="text-gray-400 italic text-sm">Belum ada keahlian yang ditambahkan.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-[32px] p-8 shadow-sm">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="w-1.5 h-6 bg-[#00D1A0] rounded-full"></span> Riwayat Pendidikan
                </h3>
                <div class="bg-gray-50 rounded-[24px] p-6 border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-6 text-center md:text-left flex-col md:flex-row">
                        <div class="px-4 py-2 bg-white rounded-xl shadow-sm text-[#00D1A0] font-black text-sm">
                            {{ $profile->tahun_lulus ?? '—' }}
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg">{{ $profile->institusi ?? 'Institusi Belum Diatur' }}</h4>
                            <p class="text-gray-500 font-medium italic text-sm">{{ $profile->pendidikan_terakhir ?? '' }} - {{ $profile->jurusan ?? '' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[32px] p-8 shadow-sm border-t-8 border-[#00D1A0]">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    📄 Curriculum Vitae
                </h3>
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 p-6 bg-gray-50 rounded-[24px] border border-dashed border-gray-300">
                    @if($profile->cv_path)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-100 text-red-600 rounded-lg flex items-center justify-center font-bold">PDF</div>
                            <p class="text-sm font-bold text-gray-700 uppercase tracking-tight">File CV Terlampir</p>
                        </div>
                        <a href="{{ asset('storage/'.$profile->cv_path) }}" target="_blank" class="bg-gray-900 text-white px-6 py-2.5 rounded-xl text-xs font-bold uppercase hover:bg-black transition">
                            Unduh / Lihat CV
                        </a>
                    @else
                        <p class="text-gray-500 font-medium italic text-sm">Belum ada file CV yang diunggah.</p>
                        <a href="/pelamar/profile" class="text-[#00D1A0] font-bold text-xs uppercase hover:underline">
                            Upload Sekarang →
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <footer class="mt-20 text-center text-gray-400 text-xs py-6">
            © 2026, Sistem Informasi Karier dan Portofolio (SIKAP)
        </footer>
    </main>
</div>
@endsection