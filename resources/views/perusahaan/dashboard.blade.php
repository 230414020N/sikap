@extends('layouts.app')

@section('content')
@php
    $companyName = $company->nama_perusahaan ?? $company->nama ?? $company->name ?? 'Perusahaan';
    $companyInitial = strtoupper(mb_substr(trim((string) $companyName), 0, 1)) ?: 'P';

    $navBase = 'flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-medium transition focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-900/20 focus-visible:ring-offset-2';
    $navActive = 'bg-gray-900 text-white shadow-sm';
    $navInactive = 'border border-gray-200 bg-white text-gray-900 hover:bg-gray-50';

    $btnBase = 'inline-flex items-center justify-center rounded-2xl px-5 py-3 text-sm font-medium transition focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-900/20 focus-visible:ring-offset-2';
    $btnSecondary = $btnBase.' border border-gray-200 bg-white text-gray-900 hover:bg-gray-50';
    $btnPrimary = $btnBase.' bg-gray-900 text-white hover:bg-black shadow-sm';

    $companyEditHref = \Illuminate\Support\Facades\Route::has('perusahaan.company.edit')
        ? route('perusahaan.company.edit')
        : ((\Illuminate\Support\Facades\Route::has('companies.edit') && ($company?->id)) ? route('companies.edit', $company->id) : '#');

    $jobsIndexHref = \Illuminate\Support\Facades\Route::has('perusahaan.jobs.index') ? route('perusahaan.jobs.index') : '#';
    $jobsCreateHref = \Illuminate\Support\Facades\Route::has('perusahaan.jobs.create') ? route('perusahaan.jobs.create') : '#';

    $hrdIndexHref = \Illuminate\Support\Facades\Route::has('perusahaan.hrd.index') ? route('perusahaan.hrd.index') : '#';

    $dashboardHref = \Illuminate\Support\Facades\Route::has('perusahaan.dashboard') ? route('perusahaan.dashboard') : url('/perusahaan/dashboard');

    $menu = [
        ['label' => 'Dashboard', 'href' => $dashboardHref, 'active' => 'perusahaan.dashboard', 'right' => '↵'],
        ['label' => 'Lowongan', 'href' => $jobsIndexHref, 'active' => 'perusahaan.jobs.*', 'right' => '→'],
        ['label' => 'HRD', 'href' => $hrdIndexHref, 'active' => 'perusahaan.hrd.*', 'right' => '→'],
        ['label' => 'Profil Perusahaan', 'href' => $companyEditHref, 'active' => 'perusahaan.company.*', 'right' => '→'],
    ];

    $jobCountValue = (int) ($jobCount ?? 0);
    $jobActiveCountValue = (int) ($jobActiveCount ?? $jobCountValue);
    $hrdCountValue = (int) ($hrdCount ?? 0);
    $applicationCountValue = (int) ($applicationCount ?? 0);

    $profileCompleteValue = (bool) ($profileComplete ?? true);

    $stats = [
        [
            'label' => 'Lowongan Aktif',
            'value' => $jobActiveCountValue,
            'desc' => 'Posisi yang sedang dibuka',
            'icon' => '📌',
            'iconClass' => 'bg-gray-900 text-white',
        ],
        [
            'label' => 'Total Lowongan',
            'value' => $jobCountValue,
            'desc' => 'Semua lowongan yang dibuat',
            'icon' => '🗂️',
            'iconClass' => 'border border-gray-200 bg-gray-50 text-gray-900',
        ],
        [
            'label' => 'HRD',
            'value' => $hrdCountValue,
            'desc' => 'Akun HRD terdaftar',
            'icon' => '👥',
            'iconClass' => 'border border-gray-200 bg-white text-gray-900',
        ],
        [
            'label' => 'Pelamar Masuk',
            'value' => $applicationCountValue,
            'desc' => 'Lamaran yang diterima',
            'icon' => '📨',
            'iconClass' => 'bg-gray-900 text-white',
        ],
    ];

    $latestJobsValue = $latestJobs ?? collect();
    $latestApplicationsValue = $latestApplications ?? collect();
@endphp

<div class="min-h-screen bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-gray-50 border border-gray-200 rounded-[28px] shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] min-h-[78vh]">
                <aside class="bg-white border-b lg:border-b-0 lg:border-r border-gray-200 lg:sticky lg:top-0 lg:h-screen">
                    <div class="p-6">
                        <div class="flex items-center gap-3">
                            <div class="h-11 w-11 rounded-3xl bg-gray-900 text-white flex items-center justify-center text-sm font-semibold shadow-sm">
                                {{ $companyInitial }}
                            </div>
                            <div class="leading-tight min-w-0">
                                <p class="text-base font-semibold tracking-tight text-gray-900 truncate">{{ $companyName }}</p>
                                <p class="text-xs text-gray-500">Perusahaan</p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <p class="text-[11px] font-semibold tracking-widest text-gray-500">MENU</p>
                            <div class="mt-3 space-y-2">
                                @foreach($menu as $item)
                                    @php $isActive = request()->routeIs($item['active']); @endphp
                                    <a href="{{ $item['href'] }}"
                                       @class([
                                           $navBase,
                                           $navActive => $isActive,
                                           $navInactive => !$isActive,
                                       ])>
                                        <span>{{ $item['label'] }}</span>
                                        <span @class([
                                            'text-xs',
                                            'text-white/70' => $isActive,
                                            'text-gray-500' => !$isActive,
                                        ])>{{ $item['right'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </aside>

                <main class="bg-gray-50">
                    <div class="p-6 sm:p-8">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                            <div class="min-w-0">
                                <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-gray-900 truncate">Dashboard Perusahaan</h1>
                                <p class="mt-1 text-sm text-gray-600">Pantau lowongan, HRD, dan pelamar di satu tempat.</p>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-3">
                                <a href="{{ $jobsCreateHref }}" class="{{ $btnPrimary }}">Buat Lowongan</a>
                                <a href="{{ $companyEditHref }}" class="{{ $btnSecondary }}">Edit Profil</a>
                            </div>
                        </div>

                        <div class="mt-7 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($stats as $card)
                                <div class="bg-white border border-gray-200 rounded-3xl shadow-sm p-5">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <p class="text-xs text-gray-600">{{ $card['label'] }}</p>
                                            <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $card['value'] }}</p>
                                            <p class="mt-2 text-xs text-gray-500">{{ $card['desc'] }}</p>
                                        </div>
                                        <div class="h-10 w-10 rounded-2xl flex items-center justify-center text-xs font-semibold {{ $card['iconClass'] }}">
                                            {{ $card['icon'] }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-4">
                            <div class="lg:col-span-2 bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
                                <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">Lowongan Terbaru</p>
                                        <p class="mt-1 text-xs text-gray-600">Kelola cepat posisi yang baru dibuat.</p>
                                    </div>
                                    <a href="{{ $jobsIndexHref }}" class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700">
                                        Lihat semua
                                    </a>
                                </div>

                                <div class="divide-y divide-gray-200">
                                    @forelse($latestJobsValue as $job)
                                        <div class="px-6 py-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold text-gray-900 truncate">
                                                    {{ $job->judul ?? $job->title ?? 'Lowongan' }}
                                                </p>
                                                <p class="mt-1 text-sm text-gray-600 truncate">
                                                    {{ $job->lokasi ?? $job->location ?? '—' }}
                                                </p>
                                                <p class="mt-2 text-xs text-gray-500">
                                                    {{ optional($job->created_at)->format('d M Y, H:i') }}
                                                </p>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <span class="text-xs px-3 py-1 rounded-full border border-gray-200 bg-gray-50 text-gray-800">
                                                    {{ $job->status ?? 'Aktif' }}
                                                </span>

                                                @php
                                                    $editHref = (\Illuminate\Support\Facades\Route::has('perusahaan.jobs.edit') && ($job?->id))
                                                        ? route('perusahaan.jobs.edit', $job->id)
                                                        : '#';
                                                @endphp

                                                <a href="{{ $editHref }}"
                                                   class="rounded-2xl bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-black transition shadow-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-900/20 focus-visible:ring-offset-2 focus-visible:ring-offset-white">
                                                    Edit
                                                </a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="px-6 py-10 text-center text-sm text-gray-600">
                                            Belum ada lowongan. Buat lowongan pertama kamu.
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="bg-white border border-gray-200 rounded-3xl shadow-sm p-6">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">Status Profil</p>
                                        <p class="mt-1 text-xs text-gray-600">Biar pelamar makin yakin.</p>
                                    </div>
                                    <div class="h-10 w-10 rounded-2xl border border-gray-200 bg-gray-50 flex items-center justify-center text-xs font-semibold text-gray-900">
                                        {{ $profileCompleteValue ? '✓' : '!' }}
                                    </div>
                                </div>

                                <div class="mt-5 rounded-3xl border border-gray-200 bg-gray-50 p-5">
                                    @if($profileCompleteValue)
                                        <p class="text-sm font-semibold text-gray-900">Profil sudah siap</p>
                                        <p class="mt-1 text-xs text-gray-600">Info perusahaan terlihat lebih kredibel.</p>
                                    @else
                                        <p class="text-sm font-semibold text-gray-900">Perlu dilengkapi</p>
                                        <p class="mt-1 text-xs text-gray-600">Lengkapi deskripsi, alamat, dan kontak.</p>
                                    @endif

                                    <a href="{{ $companyEditHref }}" class="mt-4 w-full {{ $btnSecondary }}">
                                        {{ $profileCompleteValue ? 'Edit Profil' : 'Lengkapi Profil' }}
                                    </a>
                                </div>

                                <div class="mt-4 space-y-3">
                                    <a href="{{ $hrdIndexHref }}" class="block rounded-2xl border border-gray-200 bg-white p-4 hover:bg-gray-50 transition">
                                        <p class="text-sm font-semibold text-gray-900">Kelola HRD</p>
                                        <p class="mt-1 text-sm text-gray-600">Tambah dan atur akses HRD.</p>
                                    </a>

                                    <a href="{{ $jobsIndexHref }}" class="block rounded-2xl border border-gray-200 bg-white p-4 hover:bg-gray-50 transition">
                                        <p class="text-sm font-semibold text-gray-900">Kelola Lowongan</p>
                                        <p class="mt-1 text-sm text-gray-600">Edit, tutup, atau buat posisi baru.</p>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
                            <div class="px-6 py-5 border-b border-gray-200">
                                <p class="text-sm font-semibold text-gray-900">Pelamar Terbaru</p>
                                <p class="mt-1 text-xs text-gray-600">Ringkasan pelamar masuk (opsional).</p>
                            </div>

                            <div class="divide-y divide-gray-200">
                                @forelse($latestApplicationsValue as $app)
                                    <div class="px-6 py-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 truncate">
                                                {{ $app->user?->name ?? $app->pelamar?->nama ?? 'Pelamar' }}
                                            </p>
                                            <p class="mt-1 text-sm text-gray-600 truncate">
                                                {{ $app->job?->judul ?? $app->job?->title ?? 'Lowongan' }}
                                            </p>
                                            <p class="mt-2 text-xs text-gray-500">
                                                {{ optional($app->created_at)->format('d M Y, H:i') }}
                                            </p>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <span class="text-xs px-3 py-1 rounded-full border border-gray-200 bg-gray-50 text-gray-800">
                                                {{ $app->status ?? 'Masuk' }}
                                            </span>
                                            <a href="#" class="{{ $btnSecondary }} px-4 py-2">
                                                Detail
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-6 py-10 text-center text-sm text-gray-600">
                                        Belum ada pelamar masuk.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </main>
            </div>
        </div>
    </div>
</div>
@endsection
