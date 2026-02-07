@extends('layouts.app')

@section('content')
@php
    $user = auth()->user();

    $companyId = $user->company_id
        ?? $user->perusahaan_id
        ?? $user->perusahaanProfile?->company_id
        ?? $user->perusahaanProfile?->id
        ?? $user->hrdProfile?->company_id
        ?? $user->company?->id
        ?? null;

    $jobModelClass = \App\Models\Job::class;
    $applicationModelClass = \App\Models\Application::class;

    $acceptedCount = 0;
    $rejectedCount = 0;

    $jobs = [];

    if ($companyId && class_exists($jobModelClass) && class_exists($applicationModelClass)) {
        $jobIds = $jobModelClass::query()
            ->where('company_id', $companyId)
            ->pluck('id');

        $stats = $applicationModelClass::query()
            ->whereIn('job_id', $jobIds)
            ->selectRaw("
                SUM(status = 'diterima') as accepted,
                SUM(status = 'ditolak') as rejected
            ")
            ->first();

        $acceptedCount = (int) ($stats?->accepted ?? 0);
        $rejectedCount = (int) ($stats?->rejected ?? 0);

        $jobRows = $jobModelClass::query()
            ->where('company_id', $companyId)
            ->latest()
            ->take(4)
            ->get();

        $jobs = $jobRows->map(function ($j) {
            $title = $j->judul ?? $j->title ?? $j->nama ?? 'Lowongan';

            $statusRaw = $j->status ?? null;

            $isActive = false;

            if (isset($j->is_active)) {
                $isActive = (bool) $j->is_active;
            } elseif (isset($j->aktif)) {
                $isActive = (bool) $j->aktif;
            } elseif (is_string($statusRaw)) {
                $s = strtolower(trim($statusRaw));
                $isActive = in_array($s, ['aktif', 'active', 'published', 'open'], true);
            } elseif (isset($j->published_at) && $j->published_at) {
                $isActive = true;
            }

            return [
                'title' => $title,
                'status' => $isActive ? 'Aktif' : 'Non-Aktif',
                'bg' => $isActive ? 'bg-green-500' : 'bg-red-500',
            ];
        })->values()->all();
    }

    if (count($jobs) === 0) {
        $jobs = [
            ['title' => 'Belum ada lowongan', 'status' => 'Non-Aktif', 'bg' => 'bg-red-500'],
            ['title' => '-', 'status' => 'Non-Aktif', 'bg' => 'bg-red-500'],
            ['title' => '-', 'status' => 'Non-Aktif', 'bg' => 'bg-red-500'],
            ['title' => '-', 'status' => 'Non-Aktif', 'bg' => 'bg-red-500'],
        ];
    }
@endphp

<div class="max-w-7xl mx-auto">
    <div class="mb-10 text-white">
        <h1 class="text-4xl font-black tracking-tight italic mb-2 uppercase">
            Selamat datang, {{ auth()->user()->name }}!
        </h1>
        <p class="text-gray-400 font-medium text-lg">Mari kelola dan pantau proses rekrutmen Anda dengan praktis.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-[#BDE3FF] border-[4px] border-white rounded-[35px] p-8 shadow-xl transform transition hover:scale-105">
            <p class="text-[#005696] font-black text-xs uppercase tracking-widest mb-4">Lowongan Aktif</p>
            <h2 class="text-7xl font-[1000] text-[#005696] leading-none">{{ $jobCount }}</h2>
        </div>

        <div class="bg-[#FFEDC2] border-[4px] border-white rounded-[35px] p-8 shadow-xl transform transition hover:scale-105">
            <p class="text-[#916A08] font-black text-xs uppercase tracking-widest mb-4">Lamaran Masuk</p>
            <h2 class="text-7xl font-[1000] text-[#916A08] leading-none">{{ $applicationCount }}</h2>
        </div>

        <div class="bg-[#D1FFD6] border-[4px] border-white rounded-[35px] p-8 shadow-xl transform transition hover:scale-105">
            <p class="text-[#1E7E34] font-black text-xs uppercase tracking-widest mb-4">Diterima</p>
            <h2 class="text-7xl font-[1000] text-[#1E7E34] leading-none">{{ $acceptedCount }}</h2>
        </div>

        <div class="bg-[#FFD1D1] border-[4px] border-white rounded-[35px] p-8 shadow-xl transform transition hover:scale-105">
            <p class="text-[#A91E2C] font-black text-xs uppercase tracking-widest mb-4">Ditolak</p>
            <h2 class="text-7xl font-[1000] text-[#A91E2C] leading-none">{{ $rejectedCount }}</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8 bg-white rounded-[45px] p-10 shadow-2xl">
            <div class="mb-8">
                <h3 class="text-xl font-black text-black uppercase tracking-tight">Rekapitulasi Terbaru</h3>
                <p class="text-gray-400 text-sm font-bold">Tren jumlah lamaran masuk dan perbandingan status kandidat.</p>
            </div>

            <div class="w-full bg-gray-50 rounded-[30px] border-2 border-dashed border-gray-200 flex flex-col items-center justify-center p-12 min-h-[350px]">
                <div class="flex gap-4 items-end mb-6">
                    <div class="w-12 bg-blue-400 rounded-t-lg h-32"></div>
                    <div class="w-12 bg-blue-600 rounded-t-lg h-48"></div>
                    <div class="w-12 bg-blue-300 rounded-t-lg h-20"></div>
                </div>
                <p class="font-black italic text-gray-400 text-center">
                    Visualisasi Statistik Rekrutmen<br>
                    <span class="text-[10px] uppercase tracking-[0.2em] not-italic opacity-50">Data Real-time akan dimuat di sini</span>
                </p>
            </div>
        </div>

        <div class="lg:col-span-4 bg-white rounded-[45px] p-10 shadow-2xl flex flex-col">
            <div class="mb-8">
                <h3 class="text-xl font-black text-black uppercase tracking-tight">Status Lowongan</h3>
                <p class="text-gray-400 text-sm font-bold">Pantau publikasi Anda.</p>
            </div>

            <div class="flex-1 space-y-6">
                @foreach($jobs as $j)
                <div class="flex justify-between items-center pb-4 border-b border-gray-100 last:border-0">
                    <span class="font-black text-gray-800 text-sm uppercase tracking-tighter">{{ $j['title'] }}</span>
                    <span class="{{ $j['bg'] }} text-white px-4 py-1.5 rounded-xl text-[9px] font-black uppercase shadow-sm">
                        {{ $j['status'] }}
                    </span>
                </div>
                @endforeach
            </div>

            <div class="mt-10">
                <a href="{{ route('hrd.jobs.create') }}" class="group flex items-center justify-center gap-3 w-full bg-black text-white py-5 rounded-[22px] font-black text-xs tracking-widest hover:bg-gray-800 transition-all shadow-xl">
                    <span>+</span> BUAT LOWONGAN BARU
                </a>
            </div>
        </div>
    </div>

    <div class="mt-16 mb-4 text-center">
        <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.4em]">
            &copy; {{ now()->year }} SIKAP • Sistem Informasi Karier dan Portofolio
        </p>
    </div>
</div>

<style>
    h2 { font-family: 'Inter', sans-serif; letter-spacing: -3px; }
    h3 { letter-spacing: -0.5px; }
</style>
@endsection
