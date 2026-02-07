@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white border border-gray-200 rounded-[28px] shadow-sm overflow-hidden">
            <div class="p-6 sm:p-8 border-b border-gray-200 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-gray-900">Dashboard HRD</h1>
                    <p class="mt-1 text-sm text-gray-600">Kelola lowongan dan pantau lamaran masuk.</p>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('hrd.jobs.index') }}"
                       class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-5 py-3 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                        Lowongan
                    </a>
                    <a href="{{ route('hrd.applications.index') }}"
                       class="inline-flex items-center justify-center rounded-2xl bg-gray-900 px-5 py-3 text-sm font-medium text-white hover:bg-black transition shadow-sm">
                        Lamaran
                    </a>
                </div>
            </div>

            <div class="p-6 sm:p-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="bg-white border border-gray-200 rounded-3xl shadow-sm p-5">
                        <p class="text-xs text-gray-600">Total Lowongan</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ (int) $jobCount }}</p>
                        <a href="{{ route('hrd.jobs.index') }}"
                           class="mt-4 inline-flex items-center justify-center w-full rounded-2xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                            Kelola Lowongan
                        </a>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-3xl shadow-sm p-5">
                        <p class="text-xs text-gray-600">Total Lamaran</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ (int) $applicationCount }}</p>
                        <a href="{{ route('hrd.applications.index') }}"
                           class="mt-4 inline-flex items-center justify-center w-full rounded-2xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                            Lihat Lamaran
                        </a>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-3xl shadow-sm p-5">
                        <p class="text-xs text-gray-600">Quick Action</p>
                        <p class="mt-2 text-sm font-semibold text-gray-900">Tambah lowongan baru</p>
                        <p class="mt-1 text-xs text-gray-600">Buka posisi baru untuk mulai menerima pelamar.</p>
                        <a href="{{ route('hrd.jobs.create') }}"
                           class="mt-4 inline-flex items-center justify-center w-full rounded-2xl bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-black transition">
                            + Buat Lowongan
                        </a>
                    </div>
                </div>

                <div class="mt-6 bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Lamaran Terbaru</p>
                            <p class="mt-1 text-xs text-gray-600">Akses cepat ke detail lamaran.</p>
                        </div>
                        <a href="{{ route('hrd.applications.index') }}"
                           class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700">
                            Lihat semua
                        </a>
                    </div>

                    <div class="divide-y divide-gray-200">
                        @forelse($latestApplications as $app)
                            <div class="px-6 py-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">
                                        {{ $app->job?->judul ?? $app->job?->title ?? 'Lowongan' }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-600 truncate">
                                        {{ $app->user?->name ?? 'Pelamar' }}
                                    </p>
                                    <p class="mt-2 text-xs text-gray-500">
                                        {{ optional($app->created_at)->format('d M Y, H:i') }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="text-xs px-3 py-1 rounded-full border border-gray-200 bg-gray-50 text-gray-800">
                                        {{ $app->status ?? 'Masuk' }}
                                    </span>

                                    <a href="{{ route('hrd.applications.show', $app->id) }}"
                                       class="rounded-2xl bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-black transition">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-10 text-center text-sm text-gray-600">
                                Belum ada lamaran masuk.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
