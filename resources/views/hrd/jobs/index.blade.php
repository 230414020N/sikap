@extends('layouts.app')

@section('content')
    @php
        $hasFilters = (string) request()->getQueryString() !== '';
        $statusSelected = (string) request('status', '');
        $sortSelected = (string) (request('sort') ?? 'latest');
        $q = (string) request('q', '');
        $categorySelected = (string) request('job_category_id', '');
        $locationSelected = (string) request('job_location_id', '');
        $activeCount = method_exists($jobs, 'total') ? $jobs->total() : (is_countable($jobs) ? count($jobs) : 0);
    @endphp

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Lowongan Pekerjaan</h1>
            <p class="text-gray-500 mt-1">Kelola publikasi lowongan dan pantau status rekrutmen perusahaan Anda.</p>
        </div>
        
        @if(Route::has('hrd.jobs.create'))
            <a href="{{ route('hrd.jobs.create') }}"
               class="inline-flex items-center justify-center rounded-xl bg-[#3AB4F2] px-6 py-3 text-sm font-bold text-white hover:bg-blue-500 transition shadow-sm gap-2">
                <span class="text-lg">+</span> Tambah Lowongan Pekerjaan
            </a>
        @endif
    </div>

    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-6 mb-8">
        <form method="GET" action="{{ route('hrd.jobs.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            <div class="md:col-span-3">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Cari Lowongan</label>
                <input type="text" name="q" value="{{ $q }}"
                       class="mt-1.5 w-full rounded-xl border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:ring-blue-500 focus:border-blue-500 transition"
                       placeholder="Judul posisi...">
            </div>

            <div class="md:col-span-2">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Kategori</label>
                <select name="job_category_id" class="mt-1.5 w-full rounded-xl border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:ring-blue-500 transition">
                    <option value="">Semua Kategori</option>
                    @foreach(($categories ?? collect()) as $c)
                        <option value="{{ $c->id }}" @selected((string) $c->id === $categorySelected)>{{ $c->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Lokasi</label>
                <select name="job_location_id" class="mt-1.5 w-full rounded-xl border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:ring-blue-500 transition">
                    <option value="">Semua Lokasi</option>
                    @foreach(($locations ?? collect()) as $l)
                        <option value="{{ $l->id }}" @selected((string) $l->id === $locationSelected)>{{ $l->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Status</label>
                <select name="status" class="mt-1.5 w-full rounded-xl border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:ring-blue-500 transition">
                    <option value="">Semua Status</option>
                    <option value="active" @selected($statusSelected === 'active')>Aktif (Proses)</option>
                    <option value="inactive" @selected($statusSelected === 'inactive')>Nonaktif (Selesai)</option>
                </select>
            </div>

            <div class="md:col-span-3 flex gap-2">
                <button type="submit" class="flex-1 bg-gray-800 text-white rounded-xl py-3 text-sm font-bold hover:bg-black transition">
                    Filter
                </button>
                @if($hasFilters)
                    <a href="{{ route('hrd.jobs.index') }}" class="bg-gray-100 text-gray-600 rounded-xl px-4 py-3 text-sm font-bold hover:bg-gray-200 transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Daftar Lowongan (<span class="text-blue-500">{{ $activeCount }}</span>)</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 text-gray-400 text-[11px] uppercase tracking-[0.1em]">
                        <th class="px-8 py-4 font-bold">No</th>
                        <th class="px-4 py-4 font-bold">Posisi Pekerjaan</th>
                        <th class="px-4 py-4 font-bold">Lokasi & Kategori</th>
                        <th class="px-4 py-4 font-bold">Gaji & Tipe</th>
                        <th class="px-4 py-4 font-bold text-center">Status</th>
                        <th class="px-8 py-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($jobs as $index => $job)
                        @php
                            $isActive = (bool) ($job->is_active ?? false);
                            $statusLabel = $isActive ? 'Proses' : 'Selesai';
                            $statusColor = $isActive ? 'bg-[#82CD47]' : 'bg-[#EB455F]';
                            $salaryText = ($job->gaji_min || $job->gaji_max)
                                ? 'Rp' . number_format($job->gaji_min ?? 0, 0, ',', '.')
                                : 'Tidak ditampilkan';
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-6 text-sm text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-4 py-6">
                                <p class="font-bold text-gray-800 text-base">{{ $job->judul }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">Deadline: {{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('d M Y') : '-' }}</p>
                            </td>
                            <td class="px-4 py-6">
                                <p class="text-sm font-semibold text-gray-700">{{ $job->jobLocation->nama ?? 'Remote' }}</p>
                                <p class="text-xs text-gray-400">{{ $job->jobCategory->nama ?? 'Umum' }}</p>
                            </td>
                            <td class="px-4 py-6">
                                <p class="text-sm font-semibold text-gray-700">{{ $salaryText }}</p>
                                <p class="text-xs text-gray-400">{{ $job->tipe ?? 'Full-time' }}</p>
                            </td>
                            <td class="px-4 py-6 text-center">
                                <span class="{{ $statusColor }} text-white px-5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="#"
                                       class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded-lg text-xs font-bold transition-all">
                                        Kandidat
                                    </a>
                                    <a href="{{ route('hrd.jobs.edit', $job->id) }}" class="text-blue-400 hover:text-blue-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-12 text-center text-gray-400 italic">
                                Belum ada lowongan yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($jobs->hasPages())
            <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-50">
                {{ $jobs->links() }}
            </div>
        @endif
    </div>

    <div class="mt-12 mb-4 text-center">
        <p class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.3em]">
            &copy; {{ now()->year }} SIKAP • Sistem Informasi Karier dan Portofolio
        </p>
    </div>
</div>

<style>
    body { background-color: #F9FAFB; }
    table th { font-family: 'Inter', sans-serif; }
</style>
@endsection