@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f3f4f6] py-10 px-4">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-800 mb-8">Detail Kandidat</h1>

        <div class="bg-white rounded-[32px] shadow-sm overflow-hidden p-8 border border-gray-100">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
                <div class="flex items-center gap-6">
                    <div class="w-32 h-32 rounded-full overflow-hidden bg-blue-100 border-4 border-white shadow-sm">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($application->pelamar->name) }}&background=0D8ABC&color=fff&size=128" alt="Profile" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900">{{ $application->pelamar->name }}</h2>
                        <p class="text-lg text-gray-600 mb-2">{{ $application->job->judul }}</p>
                        <span class="inline-block px-8 py-1.5 rounded-full text-sm font-bold uppercase tracking-wider 
                            @if($application->status == 'Ditolak') bg-red-500 text-white 
                            @elseif($application->status == 'Interview') bg-yellow-400 text-white
                            @else bg-green-400 text-white @endif">
                            {{ $application->status }}
                        </span>
                    </div>
                </div>

                <div class="relative inline-block text-left">
                    <button id="dropdownButton" class="bg-[#fcd34d] hover:bg-yellow-500 text-gray-900 px-6 py-2.5 rounded-xl font-bold flex items-center gap-2 transition shadow-sm">
                        Ubah Status Lamaran
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    </div>
            </div>

            <hr class="border-gray-200 mb-8">

            <div class="flex gap-12 border-b border-gray-100 mb-8 overflow-x-auto">
                <button class="pb-4 border-b-4 border-blue-500 text-blue-600 font-bold px-4">Profile</button>
                <button class="pb-4 text-gray-400 font-semibold px-4 hover:text-gray-600 transition">CV & Dokumen</button>
                <button class="pb-4 text-gray-400 font-semibold px-4 hover:text-gray-600 transition">Project Showcase</button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                <div class="lg:col-span-5 space-y-8">
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 text-gray-700">
                            <div class="w-10 h-10 flex items-center justify-center bg-gray-50 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="font-medium">{{ $application->pelamar->email }}</span>
                        </div>
                        <div class="flex items-center gap-4 text-gray-700">
                            <div class="w-10 h-10 flex items-center justify-center bg-gray-50 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <span class="font-medium">{{ $application->pelamar->no_telp ?? '083123456789' }}</span>
                        </div>
                        <div class="flex items-start gap-4 text-gray-700">
                            <div class="w-10 h-10 flex items-center justify-center bg-gray-50 rounded-lg shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <span class="font-medium text-sm leading-relaxed">
                                Jl. Cipaganti Gang Melati No. 12 Blok A. RT 01 / RW 03. Kel. Pasteur. Kec. Sukajadi <br>
                                Kota Bandung, Jawa Barat
                            </span>
                        </div>
                    </div>

                    <div class="pt-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Keahlian</h3>
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="font-bold text-gray-700">Figma</span>
                                    <span class="text-gray-500">90%</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2.5">
                                    <div class="bg-blue-400 h-2.5 rounded-full" style="width: 90%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="font-bold text-gray-700">HTML/CSS</span>
                                    <span class="text-gray-500">80%</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2.5">
                                    <div class="bg-green-400 h-2.5 rounded-full" style="width: 80%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-7 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white border border-gray-200 rounded-2xl p-6">
                        <h4 class="font-bold text-gray-900 mb-4">Informasi Dasar</h4>
                        <p class="text-sm text-gray-600 leading-relaxed italic">
                            {{ $application->catatan_pelamar ?? 'Belum ada catatan deskripsi tambahan dari pelamar.' }}
                        </p>
                        <p class="mt-4 text-xs text-gray-400 font-medium italic">Melamar pada: {{ $application->created_at->format('d M Y') }}</p>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-2xl p-6">
                        <h4 class="font-bold text-gray-900 mb-4">Catatan Rekrutmen</h4>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            Kandidat Menunjukan kemampuan desain yang baik, sehingga direkomendasikan untuk lanjut ke tahap interview.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-12 flex justify-end">
                <a href="{{ url()->previous() }}" class="bg-[#3b82f6] hover:bg-blue-700 text-white px-16 py-3 rounded-2xl font-bold transition shadow-md">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection