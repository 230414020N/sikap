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
    $interviewCount = 0; // Tambahan sesuai gambar

    $latestApplications = [];

    if ($companyId && class_exists($jobModelClass) && class_exists($applicationModelClass)) {
        $jobIds = $jobModelClass::query()
            ->where('company_id', $companyId)
            ->pluck('id');

        $stats = $applicationModelClass::query()
            ->whereIn('job_id', $jobIds)
            ->selectRaw("
                SUM(status = 'diterima' OR status = 'lolos') as accepted,
                SUM(status = 'ditolak') as rejected,
                SUM(status = 'interview' OR status = 'wawancara') as interview
            ")
            ->first();

        $acceptedCount = (int) ($stats?->accepted ?? 0);
        $rejectedCount = (int) ($stats?->rejected ?? 0);
        $interviewCount = (int) ($stats?->interview ?? 0);

        // Mengambil data lamaran terbaru untuk tabel bawah
        $latestApplications = $applicationModelClass::query()
            ->whereIn('job_id', $jobIds)
            ->with(['user', 'job'])
            ->latest()
            ->take(4)
            ->get();
    }
@endphp

<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Selamat datang, {{ auth()->user()->name }}!</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-[#BDE3FF] rounded-[20px] p-6 shadow-sm border border-white flex flex-col items-center justify-center text-center">
            <p class="text-[#005696] text-xs font-bold uppercase mb-1">Lowongan Aktif</p>
            <p class="text-[#005696] text-[10px] mb-4">( Posisi yang sedang dibuka )</p>
            <h2 class="text-7xl font-bold text-[#3AB4F2] leading-none">{{ $jobCount ?? 0 }}</h2>
        </div>

        <div class="bg-[#FFEDC2] rounded-[20px] p-6 shadow-sm border border-white flex flex-col items-center justify-center text-center">
            <p class="text-[#916A08] text-xs font-bold uppercase mb-1">Lamaran Masuk</p>
            <p class="text-[#916A08] text-[10px] mb-4">( Total berkas pelamar )</p>
            <h2 class="text-7xl font-bold text-[#F0BB40] leading-none">{{ $applicationCount ?? 0 }}</h2>
        </div>

        <div class="bg-[#D1FFD6] rounded-[20px] p-6 shadow-sm border border-white flex flex-col items-center justify-center text-center">
            <p class="text-[#1E7E34] text-xs font-bold uppercase mb-1">Interview Berjalan</p>
            <p class="text-[#1E7E34] text-[10px] mb-4">( Kandidat yang lolos seleksi )</p>
            <h2 class="text-7xl font-bold text-[#82CD47] leading-none">{{ $interviewCount }}</h2>
        </div>

        <div class="bg-[#FFD1D1] rounded-[20px] p-6 shadow-sm border border-white flex flex-col items-center justify-center text-center">
            <p class="text-[#A91E2C] text-xs font-bold uppercase mb-1">Ditolak</p>
            <p class="text-[#A91E2C] text-[10px] mb-4">( Kandidat tidak memenuhi kriteria )</p>
            <h2 class="text-7xl font-bold text-[#EB455F] leading-none">{{ $rejectedCount }}</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
        <div class="lg:col-span-8 bg-white rounded-[25px] p-8 shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Status Lamaran Kandidat</h3>
            <div class="relative h-64 flex items-end justify-around border-b border-gray-100 px-4">
                <div class="flex flex-col items-center w-12">
                    <div class="bg-gray-400 w-full rounded-t-md" style="height: 40%;"></div>
                    <span class="text-[10px] mt-2 text-gray-500 font-bold">Dikirim</span>
                </div>
                <div class="flex flex-col items-center w-12">
                    <div class="bg-blue-400 w-full rounded-t-md" style="height: 70%;"></div>
                    <span class="text-[10px] mt-2 text-gray-500 font-bold">Dibaca</span>
                </div>
                <div class="flex flex-col items-center w-12">
                    <div class="bg-yellow-400 w-full rounded-t-md" style="height: 55%;"></div>
                    <span class="text-[10px] mt-2 text-gray-500 font-bold">Interview</span>
                </div>
                <div class="flex flex-col items-center w-12">
                    <div class="bg-red-400 w-full rounded-t-md" style="height: 50%;"></div>
                    <span class="text-[10px] mt-2 text-gray-500 font-bold">Ditolak</span>
                </div>
                <div class="flex flex-col items-center w-12">
                    <div class="bg-green-400 w-full rounded-t-md" style="height: 30%;"></div>
                    <span class="text-[10px] mt-2 text-gray-500 font-bold">Lolos</span>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 bg-white rounded-[25px] p-8 shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Kandidat Potensial</h3>
            <div class="space-y-4">
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl">
                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/></svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-gray-800">Sinta Rahma</p>
                        <p class="text-[10px] text-gray-500 mb-1">UI/UX Designer</p>
                        <span class="bg-[#D1FFD6] text-[#1E7E34] px-2 py-0.5 rounded text-[9px] font-bold">Lulus Interview</span>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl">
                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/></svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-gray-800">Rendi Santoso</p>
                        <p class="text-[10px] text-gray-500 mb-1">Digital Marketing</p>
                        <span class="bg-[#FFEDC2] text-[#916A08] px-2 py-0.5 rounded text-[9px] font-bold">Direkomendasikan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[25px] p-8 shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Lamaran Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-center">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="pb-4 font-bold text-gray-800">Nama Lengkap</th>
                        <th class="pb-4 font-bold text-gray-800">Posisi</th>
                        <th class="pb-4 font-bold text-gray-800">Status</th>
                        <th class="pb-4 font-bold text-gray-800">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($latestApplications as $app)
                    <tr>
                        <td class="py-4 text-sm text-gray-700 font-medium">{{ $app->user->name ?? 'User' }}</td>
                        <td class="py-4 text-sm text-gray-600">{{ $app->job->title ?? $app->job->judul ?? '-' }}</td>
                        <td class="py-4">
                            @php
                                $statusLabel = ucfirst($app->status);
                                $statusBg = 'bg-gray-100 text-gray-600';
                                if($app->status == 'diterima' || $app->status == 'lolos') $statusBg = 'bg-green-100 text-green-700';
                                if($app->status == 'ditolak') $statusBg = 'bg-red-100 text-red-700';
                                if($app->status == 'interview') $statusBg = 'bg-yellow-100 text-yellow-700';
                            @endphp
                            <span class="{{ $statusBg }} px-6 py-1 rounded-full text-[11px] font-bold">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="py-4">
                            <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded-lg text-[10px] font-bold transition-all inline-flex items-center gap-2">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-gray-400 italic">Belum ada lamaran masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-12 mb-4 text-center">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest flex items-center justify-center gap-2">
            <span class="text-lg">&copy;</span> {{ now()->year }} SIKAP • Sistem Informasi Karier dan Portofolio
        </p>
    </div>
</div>

<style>
    body { background-color: #F9FAFB; }
    h2 { font-family: 'Inter', sans-serif; }
</style>
@endsection