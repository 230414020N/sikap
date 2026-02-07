@extends('layouts.app')

@section('header')
    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div class="min-w-0">
            <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Lowongan</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola lowongan, status aktif, dan akses cepat ke kandidat.</p>
        </div>

        <div class="flex items-center gap-2">
            @if(Route::has('hrd.jobs.create'))
                <a href="{{ route('hrd.jobs.create') }}"
                   class="inline-flex items-center justify-center rounded-2xl bg-gray-900 px-5 py-3 text-sm font-medium text-white hover:bg-black transition shadow-sm">
                    + Buat Lowongan
                </a>
            @endif
        </div>
    </div>
@endsection

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

    <div class="min-h-screen bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            @if(session('success'))
                <div class="mb-6">
                    <x-alert type="success">{{ session('success') }}</x-alert>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6">
                    <x-alert type="error">Terjadi kesalahan input. Coba cek lagi.</x-alert>
                </div>
            @endif

            <div class="bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Filter</p>
                        <p class="mt-1 text-xs text-gray-600">Cari berdasarkan judul, tipe, level, dan sortir sesuai kebutuhan.</p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-700">
                        Total: <span class="font-semibold text-gray-900">{{ $activeCount }}</span>
                    </div>
                </div>

                <form method="GET" action="{{ route('hrd.jobs.index') }}" class="p-6 grid grid-cols-1 sm:grid-cols-12 gap-4">
                    <div class="sm:col-span-4">
                        <label class="text-xs font-medium text-gray-700">Keyword</label>
                        <input type="text" name="q" value="{{ $q }}"
                               class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition"
                               placeholder="Judul / tipe / level">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="text-xs font-medium text-gray-700">Status</label>
                        <select name="status"
                                class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition">
                            <option value="">Semua</option>
                            <option value="active" @selected($statusSelected === 'active')>Aktif</option>
                            <option value="inactive" @selected($statusSelected === 'inactive')>Nonaktif</option>
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="text-xs font-medium text-gray-700">Urutkan</label>
                        <select name="sort"
                                class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition">
                            <option value="latest" @selected($sortSelected === 'latest')>Terbaru</option>
                            <option value="oldest" @selected($sortSelected === 'oldest')>Terlama</option>
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="text-xs font-medium text-gray-700">Kategori</label>
                        <select name="job_category_id"
                                class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition">
                            <option value="">Semua</option>
                            @foreach(($categories ?? collect()) as $c)
                                <option value="{{ $c->id }}" @selected((string) $c->id === $categorySelected)>{{ $c->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="text-xs font-medium text-gray-700">Lokasi</label>
                        <select name="job_location_id"
                                class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition">
                            <option value="">Semua</option>
                            @foreach(($locations ?? collect()) as $l)
                                <option value="{{ $l->id }}" @selected((string) $l->id === $locationSelected)>{{ $l->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-12 flex flex-col sm:flex-row sm:justify-end gap-2 pt-1">
                        @if($hasFilters)
                            <a href="{{ route('hrd.jobs.index') }}"
                               class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-5 py-3 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                                Reset
                            </a>
                        @endif

                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-2xl bg-gray-900 px-5 py-3 text-sm font-medium text-white hover:bg-black transition shadow-sm">
                            Terapkan
                        </button>
                    </div>
                </form>
            </div>

            <div class="mt-6 bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
                    <p class="text-sm font-semibold text-gray-900">Daftar Lowongan</p>
                    <p class="text-xs text-gray-500">Klik “Edit” untuk ubah detail</p>
                </div>

                <div class="hidden sm:block">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="text-left px-6 py-3 font-medium">Lowongan</th>
                                <th class="text-left px-6 py-3 font-medium">Detail</th>
                                <th class="text-left px-6 py-3 font-medium">Deadline</th>
                                <th class="text-left px-6 py-3 font-medium">Status</th>
                                <th class="text-right px-6 py-3 font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jobs as $job)
                                @php
                                    $isActive = (bool) ($job->is_active ?? false);
                                    $statusPill = $isActive ? 'border-green-200 bg-green-50 text-green-800' : 'border-gray-200 bg-gray-50 text-gray-800';
                                    $deadlineText = $job->deadline ? \Illuminate\Support\Carbon::parse($job->deadline)->format('d M Y') : '—';
                                    $salaryText = ($job->gaji_min || $job->gaji_max)
                                        ? trim(($job->gaji_min ? 'Rp ' . number_format((int) $job->gaji_min, 0, ',', '.') : '') . ' — ' . ($job->gaji_max ? 'Rp ' . number_format((int) $job->gaji_max, 0, ',', '.') : ''), ' — ')
                                        : '—';
                                    $categoryName = $job->jobCategory->nama ?? $job->category->nama ?? '—';
                                    $locationName = $job->jobLocation->nama ?? $job->location->nama ?? '—';
                                @endphp

                                <tr class="border-t border-gray-200">
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-900">{{ $job->judul }}</p>
                                        <p class="mt-1 text-xs text-gray-600">
                                            {{ $categoryName }} • {{ $locationName }}
                                        </p>
                                    </td>

                                    <td class="px-6 py-4">
                                        <p class="text-gray-900">{{ $job->tipe ?: '—' }} • {{ $job->level ?: '—' }}</p>
                                        <p class="mt-1 text-xs text-gray-600">Gaji: {{ $salaryText }}</p>
                                    </td>

                                    <td class="px-6 py-4 text-gray-700">{{ $deadlineText }}</td>

                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-medium {{ $statusPill }}">
                                            {{ $isActive ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('hrd.jobs.edit', $job->id) }}"
                                               class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                                                Edit
                                            </a>

                                            @if(Route::has('hrd.jobs.applications.index'))
                                                <a href="{{ route('hrd.jobs.applications.index', $job->id) }}"
                                                   class="inline-flex items-center justify-center rounded-2xl bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-black transition shadow-sm">
                                                    Kandidat
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-600">
                                        Belum ada lowongan. Klik “Buat Lowongan” untuk mulai.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="sm:hidden divide-y divide-gray-200">
                    @forelse($jobs as $job)
                        @php
                            $isActive = (bool) ($job->is_active ?? false);
                            $statusPill = $isActive ? 'border-green-200 bg-green-50 text-green-800' : 'border-gray-200 bg-gray-50 text-gray-800';
                            $deadlineText = $job->deadline ? \Illuminate\Support\Carbon::parse($job->deadline)->format('d M Y') : '—';
                            $categoryName = $job->jobCategory->nama ?? $job->category->nama ?? '—';
                            $locationName = $job->jobLocation->nama ?? $job->location->nama ?? '—';
                        @endphp

                        <div class="px-6 py-5">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $job->judul }}</p>
                                    <p class="mt-1 text-xs text-gray-600 truncate">{{ $categoryName }} • {{ $locationName }}</p>
                                    <p class="mt-2 text-xs text-gray-500">Deadline: {{ $deadlineText }}</p>
                                </div>

                                <span class="shrink-0 inline-flex items-center rounded-full border px-3 py-1 text-xs font-medium {{ $statusPill }}">
                                    {{ $isActive ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>

                            <div class="mt-4 flex items-center justify-between">
                                <a href="{{ route('hrd.jobs.edit', $job->id) }}"
                                   class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700">
                                    Edit
                                </a>

                                @if(Route::has('hrd.jobs.applications.index'))
                                    <a href="{{ route('hrd.jobs.applications.index', $job->id) }}"
                                       class="inline-flex items-center justify-center rounded-2xl bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-black transition shadow-sm">
                                        Kandidat
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-10 text-center text-gray-600">
                            Belum ada lowongan.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-6">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
@endsection
