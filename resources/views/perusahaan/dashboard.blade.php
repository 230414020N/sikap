@extends('layouts.app')

@section('content')
@php
    $companyName = $company->nama_perusahaan ?? $company->nama ?? $company->name ?? 'Perusahaan';
    $companyInitial = strtoupper(mb_substr(trim((string) $companyName), 0, 1)) ?: 'P';

    // Styling sesuai gambar (Rounded corners tinggi, warna netral)
    $navBase = 'flex items-center justify-between rounded-xl px-4 py-3 text-sm font-medium transition duration-200';
    $navActive = 'bg-gray-800 text-white shadow-md';
    $navInactive = 'text-gray-600 hover:bg-gray-100';

    $btnPrimary = 'inline-flex items-center justify-center rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-black transition shadow-sm';
    $btnSecondary = 'inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition';

    // Logic Href tetap sama
    $companyEditHref = \Illuminate\Support\Facades\Route::has('perusahaan.company.edit') ? route('perusahaan.company.edit') : '#';
    $jobsIndexHref = \Illuminate\Support\Facades\Route::has('perusahaan.jobs.index') ? route('perusahaan.jobs.index') : '#';
    $jobsCreateHref = \Illuminate\Support\Facades\Route::has('perusahaan.jobs.create') ? route('perusahaan.jobs.create') : '#';
    $hrdIndexHref = \Illuminate\Support\Facades\Route::has('perusahaan.hrd.index') ? route('perusahaan.hrd.index') : '#';
    $dashboardHref = \Illuminate\Support\Facades\Route::has('perusahaan.dashboard') ? route('perusahaan.dashboard') : url('/perusahaan/dashboard');

    $menu = [
        ['label' => 'Dashboard', 'icon' => '🏠', 'href' => $dashboardHref, 'active' => 'perusahaan.dashboard'],
        ['label' => 'Profile', 'icon' => '👤', 'href' => $companyEditHref, 'active' => 'perusahaan.company.*'],
        ['label' => 'Kelola Akun HRD', 'icon' => '⚙️', 'href' => $hrdIndexHref, 'active' => 'perusahaan.hrd.*'],
        ['label' => 'Lowongan', 'icon' => '💼', 'href' => $jobsIndexHref, 'active' => 'perusahaan.jobs.*'],
        ['label' => 'Laporan Rekrutmen', 'icon' => '📊', 'href' => '#', 'active' => 'perusahaan.reports.*']
    ];

    $stats = [
        ['label' => 'Lowongan Aktif', 'value' => $jobActiveCount ?? 12, 'desc' => 'Posisi yang sedang dibuka', 'color' => 'bg-blue-50 text-blue-600'],
        ['label' => 'Lamaran Masuk', 'value' => $applicationCount ?? 450, 'desc' => 'Total berkas pelamar', 'color' => 'bg-orange-50 text-orange-600'],
        ['label' => 'Diterima', 'value' => $acceptedCount ?? 30, 'desc' => 'Kandidat lolos seleksi', 'color' => 'bg-green-50 text-green-600'],
        ['label' => 'Ditolak', 'value' => $rejectedCount ?? 10, 'desc' => 'Kandidat tidak memenuhi kriteria', 'color' => 'bg-red-50 text-red-600'],
    ];
@endphp

<div class="min-h-screen bg-[#F4F4F4] font-sans">
    <div class="flex max-w-[1600px] mx-auto min-h-screen">
        
        <aside class="w-72 bg-white border-r border-gray-200 hidden lg:flex flex-col p-6">
            <div class="mb-10 px-2">
                <img src="{{ asset('images/logo.png') }}" alt="SIKAP" class="h-15">
            </div>

            <nav class="flex-1 space-y-2">
                @foreach($menu as $item)
                    @php $isActive = request()->routeIs($item['active']); @endphp
                    <a href="{{ $item['href'] }}" class="{{ $isActive ? $navActive : $navInactive }} {{ $navBase }}">
                        <div class="flex items-center gap-3">
                            <span>{{ $item['icon'] }}</span>
                            <span>{{ $item['label'] }}</span>
                        </div>
                    </a>
                @endforeach
            </nav>

            <div class="mt-auto pt-6 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-red-600 hover:bg-red-50 rounded-xl w-full transition">
                        <span>🚪</span> Keluar
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-6 lg:p-10">
            <header class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Selamat datang, {{ $companyName }}!</h1>
                    <p class="text-gray-500 text-sm">Mari kelola dan pantau proses rekrutmen Anda dengan praktis.</p>
                </div>
                <div class="flex items-center gap-4">
                    <button class="p-2 bg-white rounded-full border border-gray-200 text-gray-500 hover:bg-gray-50">🔔</button>
                    <div class="flex items-center gap-3 bg-white p-1 pr-4 rounded-full border border-gray-200">
                        <div class="h-8 w-8 rounded-full bg-gray-900 text-white flex items-center justify-center text-xs">{{ $companyInitial }}</div>
                        <span class="text-sm font-medium text-gray-700">{{ $companyName }}</span>
                    </div>
                </div>
            </header>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @foreach($stats as $stat)
                    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-100 flex flex-col items-center text-center">
                        <p class="text-sm font-bold text-gray-800">{{ $stat['label'] }}</p>
                        <p class="text-xs text-gray-400 mb-4">({{ $stat['desc'] }})</p>
                        <p class="text-5xl font-bold mb-2 {{ $stat['color'] === 'bg-orange-50 text-orange-600' ? 'text-orange-400' : ($stat['color'] === 'bg-blue-50 text-blue-600' ? 'text-blue-400' : 'text-gray-800') }}">
                            {{ $stat['value'] }}
                        </p>
                    </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-white p-8 rounded-[32px] shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-gray-900">Rekapitulasi Terbaru</h3>
                        <a href="{{ $jobsCreateHref }}" class="{{ $btnPrimary }}">Buat Lowongan</a>
                    </div>
                    
                    {{-- <div class="space-y-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Lowongan Terbaru</p>
                        <div class="divide-y divide-gray-50">
                            @forelse($latestJobsValue as $job)
                                <div class="py-4 flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-gray-900 text-sm">{{ $job->judul ?? 'Untitled Job' }}</p>
                                        <p class="text-xs text-gray-500">{{ $job->lokasi ?? 'Remote' }} • {{ optional($job->created_at)->diffForHumans() }}</p>
                                    </div>
                                    <span class="px-3 py-1 bg-green-50 text-green-600 text-[10px] font-bold rounded-full uppercase">Aktif</span>
                                </div>
                            @empty
                                <div class="text-center py-10 text-gray-400 text-sm italic">Belum ada data lowongan.</div>
                            @endforelse
                        </div>
                    </div> --}}
                </div>

                <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-6">Status Lowongan Terakhir</h3>
                    <div class="space-y-6">
                        @php
                            $sampleJobs = [['title' => 'Software Engineer', 'status' => 'Aktif'], ['title' => 'UI/UX Designer', 'status' => 'Aktif'], ['title' => 'Digital Marketing', 'status' => 'Non-Aktif']];
                        @endphp
                        @foreach($sampleJobs as $sJob)
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">{{ $sJob['title'] }}</span>
                                <span class="px-4 py-1.5 rounded-full text-[10px] font-bold {{ $sJob['status'] == 'Aktif' ? 'bg-emerald-400 text-white' : 'bg-red-400 text-white' }}">
                                    {{ $sJob['status'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-10 p-4 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                        <p class="text-xs text-gray-600 mb-3">Lengkapi profil perusahaan Anda untuk kredibilitas lebih baik.</p>
                        <a href="{{ $companyEditHref }}" class="text-xs font-bold text-gray-900 underline underline-offset-4">Edit Profil →</a>
                    </div>
                </div>
            </div>

            <footer class="mt-12 text-center text-gray-400 text-xs">
                <p>&copy; 2025, Sistem Informasi Karier dan Portofolio (SIKAP)</p>
            </footer>
        </main>
    </div>
</div>
@endsection