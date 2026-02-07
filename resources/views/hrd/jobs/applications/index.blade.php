@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#4b4b4b] p-4 sm:p-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-white text-4xl font-bold mb-8">Lamaran Masuk</h1>

        <div class="bg-white rounded-3xl p-8 shadow-lg">
            
            <div class="mb-8">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Cari Lamaran</h2>
                <form method="GET" class="relative">
                    <input type="text" 
                           name="q" 
                           value="{{ $search }}"
                           placeholder="Cari nama, posisi, atau kata kunci lainnya..." 
                           class="w-full bg-[#f0f0f0] border-none rounded-xl py-3 px-5 pr-12 focus:ring-2 focus:ring-blue-500 transition">
                    <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                    @if($status) <input type="hidden" name="status" value="{{ $status }}"> @endif
                </form>
            </div>

            <hr class="border-gray-300 mb-8">

            <div class="mb-4">
                <h2 class="text-lg font-semibold mb-6 text-gray-800">Daftar Lamaran</h2>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-center border-collapse">
                        <thead>
                            <tr class="text-gray-800 font-bold border-b-2 border-gray-300">
                                <th class="pb-4 px-2">No</th>
                                <th class="pb-4 px-2">Nama Lengkap</th>
                                <th class="pb-4 px-2">Posisi</th>
                                <th class="pb-4 px-2">Pendidikan</th>
                                <th class="pb-4 px-2">Status</th>
                                <th class="pb-4 px-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($applications as $index => $app)
                            <tr>
                                <td class="py-5 text-gray-700">{{ $applications->firstItem() + $index }}</td>
                                <td class="py-5 text-gray-700">{{ $app->pelamar?->name ?? 'Pelamar' }}</td>
                                <td class="py-5 text-gray-700">{{ $job->judul }}</td>
                                <td class="py-5 text-gray-700">S1</td> <td class="py-5">
                                    @php
                                        $statusColor = match($app->status) {
                                            'Interview' => 'bg-[#ffeeba] text-gray-800',
                                            'Ditolak' => 'bg-[#f8d7da] text-red-700',
                                            'Diterima' => 'bg-[#d4edda] text-green-700',
                                            default => 'bg-[#c3e6cb] text-gray-800', // Status 'Ditinjau' atau default
                                        };
                                    @endphp
                                    <span class="{{ $statusColor }} px-6 py-1.5 rounded-full text-xs font-semibold">
                                        {{ $app->status ?? 'Ditinjau' }}
                                    </span>
                                </td>
                                <td class="py-5">
                                    <a href="{{ route('hrd.applications.show', $app->id) }}" 
                                       class="bg-[#4d79ff] text-white px-4 py-1.5 rounded-lg text-xs flex items-center justify-center gap-2 hover:bg-blue-600 transition inline-flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
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

            <div class="mt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-600 text-sm">
                    Menampilkan {{ $applications->firstItem() }} - {{ $applications->lastItem() }} dari {{ $applications->total() }} Lamaran
                </p>
                <div class="custom-pagination">
                    {{ $applications->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Menyesuaikan style pagination agar lebih mirip dengan UI gambar */
    .custom-pagination nav span[aria-current="page"] > span {
        background-color: #4b4b4b !important;
        border-color: #4b4b4b !important;
    }
    .custom-pagination nav a, .custom-pagination nav span {
        border-radius: 8px !important;
        margin: 0 2px;
    }
</style>
@endsection