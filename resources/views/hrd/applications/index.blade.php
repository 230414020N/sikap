@extends('layouts.app')

@section('content')
    @php
        $statusClass = function ($status) {
            $s = strtolower((string) $status);
            if (str_contains($s, 'ditinjau') || str_contains($s, 'proses')) {
                return 'bg-[#98e998] text-gray-700'; // Hijau muda sesuai gambar
            }
            if (str_contains($s, 'interview') || str_contains($s, 'wawancara')) {
                return 'bg-[#ffe7a5] text-gray-700'; // Kuning sesuai gambar
            }
            if (str_contains($s, 'ditolak')) {
                return 'bg-[#f46b6b] text-white'; // Merah sesuai gambar
            }
            return 'bg-gray-200 text-gray-700';
        };

        $total = method_exists($applications, 'total') ? $applications->total() : (is_countable($applications) ? count($applications) : 0);
    @endphp

    <div class="min-h-screen bg-[#4b4b4b] p-4 sm:p-8">
        <div class="max-w-6xl mx-auto">
            
            <div class="mb-6">
                <h1 class="text-white text-4xl font-bold uppercase tracking-tight">Lamaran Masuk</h1>
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-xl">
                
                <div class="mb-8 bg-[#f0f0f0] rounded-2xl p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Cari Lamaran</h2>
                    <form method="GET" action="{{ route('hrd.applications.index') }}" class="relative">
                        <input type="text" name="q" value="{{ request('q') }}"
                               class="w-full bg-white border-none rounded-2xl py-4 px-6 pr-12 text-sm shadow-sm focus:ring-2 focus:ring-blue-400"
                               placeholder="Cari nama, posisi, atau kata kunci lainnya...">
                        <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>

                        @if(request('job_id') || request('status') || request('pendidikan'))
                            <div class="mt-4 flex flex-wrap gap-2">
                                <span class="text-xs font-medium text-gray-500 italic">Filter Aktif:</span>
                                <a href="{{ route('hrd.applications.index') }}" class="text-xs text-blue-600 font-bold hover:underline">Hapus Semua Filter</a>
                            </div>
                        @endif
                    </form>
                </div>

                <div class="bg-[#f0f0f0] rounded-2xl p-6">
    <h2 class="text-lg font-bold text-gray-800 mb-4">Daftar Lamaran</h2>
    
    <div class="overflow-x-auto">
        <table class="w-full text-center border-collapse">
            <thead>
                <tr class="text-gray-800 font-bold border-b border-gray-400">
                    <th class="py-4 px-2 w-16">No</th>
                    <th class="py-4 px-4 text-left border-l border-gray-400">Nama Lengkap</th>
                    <th class="py-4 px-4 border-l border-gray-400">Posisi</th>
                    <th class="py-4 px-4 border-l border-gray-400">Pendidikan</th>
                    <th class="py-4 px-4 border-l border-gray-400">Status</th>
                    <th class="py-4 px-4 border-l border-gray-400 w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-300">
                @forelse($applications as $index => $a)
                    <tr class="text-sm text-gray-900 font-medium">
                        <td class="py-4">{{ $applications->firstItem() + $index }}</td>
                        <td class="py-4 px-4 text-left border-l border-gray-300">{{ $a->pelamar?->name }}</td>
                        <td class="py-4 px-4 border-l border-gray-300">{{ $a->job->judul }}</td>
                        <td class="py-4 px-4 border-l border-gray-300">{{ $a->pelamar?->pendidikan ?? 'S1' }}</td>
                        <td class="py-4 px-4 border-l border-gray-300">
                            <span class="inline-block px-6 py-1 rounded-full text-[10px] font-bold uppercase {{ $statusClass($a->status) }}">
                                {{ $a->status }}
                            </span>
                        </td>
                        <td class="py-4 px-4 border-l border-gray-300 text-center">
                            <a href="{{ route('hrd.applications.show', $a->id) }}" 
                               class="bg-[#4d79ff] text-white px-4 py-2 rounded-lg text-[11px] font-bold flex items-center justify-center gap-2 hover:bg-blue-600 transition mx-auto w-fit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-10 text-gray-500 italic">Belum ada lamaran masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
                    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-gray-300 pt-6">
                        <p class="text-sm font-bold text-gray-700 uppercase">
                            Menampilkan {{ $applications->firstItem() ?? 0 }} - {{ $applications->lastItem() ?? 0 }} dari {{ $total }} Lamaran
                        </p>
                        
                        <div class="sikap-pagination">
                            {{ $applications->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center text-gray-400 text-sm pb-8 flex items-center justify-center gap-2">
                <span class="text-xl">©</span>
                <p>2025, Sistem Informasi Karier dan Portofolio</p>
            </div>
        </div>
    </div>

    <style>
    /* Reset gaya pagination Laravel agar jadi kotak minimalis sesuai gambar */
    .sikap-pagination-container nav div:first-child { display: none; } /* Sembunyikan info text bawaan laravel */
    .sikap-pagination-container nav div:last-child { margin-top: 0; box-shadow: none; }
    .sikap-pagination-container span[aria-current="page"] span {
        background-color: #333 !important;
        color: white !important;
        border-color: #333 !important;
    }
    .sikap-pagination-container a, .sikap-pagination-container span {
        border-radius: 4px !important;
        padding: 6px 12px !important;
        font-weight: bold !important;
        border: 1px solid #333 !important;
        color: #333 !important;
    }
    .sikap-pagination-container a:hover {
        background-color: #f0f0f0 !important;
    }
</style>
@endsection