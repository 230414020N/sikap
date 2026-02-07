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

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white">Detail Lamaran</h1>
            <p class="text-gray-300 text-sm mt-1">Pantau status lamaran pekerjaanmu disini.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-[32px] p-10 shadow-xl">
                    <h2 class="text-3xl font-bold text-gray-900">{{ $application->job->judul }}</h2>
                    <p class="text-lg text-gray-500 mt-1">di {{ $application->job->company->nama }}</p>
                    
                    <div class="mt-10 pt-6 border-t border-gray-100">
                        <p class="text-gray-600 font-medium italic">Tanggal Melamar : {{ $application->created_at->format('d F Y') }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-[32px] p-10 shadow-xl">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Dokumen Terlampir</h3>
                    <div class="space-y-4">
                        @if($application->cv_snapshot_path)
                            <a href="{{ asset('storage/' . $application->cv_snapshot_path) }}" target="_blank" class="flex items-center gap-3 text-sm text-gray-700 hover:text-blue-600 transition group">
                                <span class="text-xl">📄</span>
                                <span class="underline decoration-gray-300 group-hover:decoration-blue-500">CV_{{ Auth::user()->name }}.PDF</span>
                            </a>
                        @endif

                        @if($application->surat_lamaran_snapshot_path)
                            <a href="{{ asset('storage/' . $application->surat_lamaran_snapshot_path) }}" target="_blank" class="flex items-center gap-3 text-sm text-gray-700 hover:text-blue-600 transition group">
                                <span class="text-xl">📄</span>
                                <span class="underline decoration-gray-300 group-hover:decoration-blue-500">Surat Lamaran-{{ $application->job->company->nama }}.PDF</span>
                            </a>
                        @endif
                        
                        {{-- Logic untuk dokumen tambahan jika ada di DB --}}
                        <p class="text-xs text-gray-400 mt-4 italic">* Dokumen di atas adalah snapshot saat lamaran dikirim.</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-transparent border border-gray-600 rounded-[32px] p-8 min-h-full">
                    <h3 class="text-xl font-bold text-white mb-10">Riwayat Status Lamaran</h3>
                    
                    <div class="relative flex flex-col gap-10">
                        <div class="absolute left-[17px] top-2 bottom-2 w-0.5 bg-gray-500"></div>

                        @php
                            // Array status untuk visualisasi sesuai gambar (jika history kosong, tampilkan default)
                            $statuses = ['Dikirim', 'Diterima', 'Ditinjau', 'Interview', 'Keputusan'];
                            $currentStatus = $application->status;
                            $history = $application->histories->pluck('status')->toArray();
                        @endphp

                        @foreach($statuses as $index => $step)
                            @php
                                $isCompleted = in_array($step, $history) || $currentStatus == $step;
                                $isCurrent = $currentStatus == $step;
                            @endphp
                            <div class="relative flex items-center gap-6 z-10">
                                <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-all duration-300
                                    {{ $isCurrent ? 'bg-[#10B981] border-[#10B981] text-white' : ($isCompleted ? 'bg-gray-400 border-gray-400 text-white' : 'bg-[#4B4B4B] border-gray-500 text-gray-400') }}">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-lg font-bold {{ $isCurrent || $isCompleted ? 'text-white' : 'text-gray-500' }}">{{ $step }}</span>
                                    @if($isCurrent && $application->catatan_hrd)
                                        <p class="text-xs text-gray-300 mt-1 max-w-[200px]">{{ $application->catatan_hrd }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
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