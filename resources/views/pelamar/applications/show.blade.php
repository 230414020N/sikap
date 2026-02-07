@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex items-start justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">{{ $application->job->judul }}</h1>
                    <p class="mt-1 text-sm text-gray-600">{{ $application->job->company->nama }}</p>
                </div>

                <a href="{{ route('pelamar.applications.tracking') }}"
                   class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700">
                    ← Kembali
                </a>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">Status Saat Ini</p>
                    <span class="text-xs px-4 py-2 rounded-full bg-gray-100 text-gray-800 font-medium">
                        {{ $application->status }}
                    </span>
                </div>

                <div class="mt-6 border-t border-gray-200 pt-6">
                    <h2 class="text-sm font-semibold text-gray-900">Riwayat Status</h2>

                    <div class="mt-4 space-y-3">
                        @foreach($application->histories()->latest()->get() as $h)
                            <div class="rounded-xl border border-gray-200 p-4">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900">{{ $h->status }}</p>
                                    <p class="text-xs text-gray-500">{{ $h->created_at->format('d M Y, H:i') }}</p>
                                </div>

                                @if($h->catatan_hrd)
                                    <p class="mt-2 text-sm text-gray-700 whitespace-pre-line">{{ $h->catatan_hrd }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6 border-t border-gray-200 pt-6">
                    <h2 class="text-sm font-semibold text-gray-900">Dokumen Snapshot</h2>
                    <p class="mt-1 text-xs text-gray-600">Dokumen yang dikirim saat melamar.</p>

                    <div class="mt-3 flex gap-3">
                        @if($application->cv_snapshot_path)
                            <a target="_blank" class="rounded-xl border border-gray-300 px-4 py-2 text-sm hover:bg-gray-50"
                               href="{{ asset('storage/' . $application->cv_snapshot_path) }}">
                                Lihat CV
                            </a>
                        @endif

                        @if($application->surat_lamaran_snapshot_path)
                            <a target="_blank" class="rounded-xl border border-gray-300 px-4 py-2 text-sm hover:bg-gray-50"
                               href="{{ asset('storage/' . $application->surat_lamaran_snapshot_path) }}">
                                Lihat Surat
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
