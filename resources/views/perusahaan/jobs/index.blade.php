@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white border border-gray-200 rounded-[28px] shadow-sm overflow-hidden">
            <div class="p-6 sm:p-8 border-b border-gray-200 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-gray-900">Lowongan</h1>
                    <p class="mt-1 text-sm text-gray-600">Kelola semua lowongan yang kamu buat.</p>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('perusahaan.dashboard') }}"
                       class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-5 py-3 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                        Dashboard
                    </a>
                    <a href="{{ route('perusahaan.jobs.create') }}"
                       class="inline-flex items-center justify-center rounded-2xl bg-gray-900 px-5 py-3 text-sm font-medium text-white hover:bg-black transition shadow-sm">
                        + Buat Lowongan
                    </a>
                </div>
            </div>

            <div class="p-6 sm:p-8">
                @if(session('success'))
                    <div class="mb-4 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <p class="text-sm font-semibold text-gray-900">Daftar Lowongan</p>
                        <p class="text-xs text-gray-500">Total: {{ $jobs->total() }}</p>
                    </div>

                    <div class="divide-y divide-gray-200">
                        @forelse($jobs as $job)
                            <div class="px-6 py-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">
                                        {{ $job->judul ?? $job->title ?? 'Lowongan' }}
                                    </p>

                                    <div class="mt-1 flex flex-wrap items-center gap-2 text-sm text-gray-600">
                                        <span class="truncate">{{ $job->lokasi ?? $job->location ?? '—' }}</span>
                                        <span class="text-gray-300">•</span>
                                        <span class="truncate">{{ $job->employmentStatus->nama ?? $job->employmentStatus->name ?? '—' }}</span>
                                        <span class="text-gray-300">•</span>
                                        <span class="text-xs text-gray-500">{{ optional($job->created_at)->format('d M Y, H:i') }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="text-xs px-3 py-1 rounded-full border border-gray-200 bg-gray-50 text-gray-800">
                                        {{ $job->status ?? 'Aktif' }}
                                    </span>

                                    <a href="{{ route('perusahaan.jobs.edit', $job->id) }}"
                                       class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ route('perusahaan.jobs.destroy', $job->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center justify-center rounded-2xl bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-black transition"
                                                onclick="return confirm('Hapus lowongan ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-12 text-center">
                                <p class="text-sm font-semibold text-gray-900">Belum ada lowongan</p>
                                <p class="mt-1 text-sm text-gray-600">Mulai buat lowongan pertama untuk menerima pelamar.</p>
                                <a href="{{ route('perusahaan.jobs.create') }}"
                                   class="mt-5 inline-flex items-center justify-center rounded-2xl bg-gray-900 px-5 py-3 text-sm font-medium text-white hover:bg-black transition shadow-sm">
                                    + Buat Lowongan
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="mt-6">
                    {{ $jobs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
