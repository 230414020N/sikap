@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex items-start justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">{{ $job->judul }}</h1>
                    <p class="mt-1 text-sm text-gray-600">{{ $job->company->nama }} • {{ $job->lokasi ?? '—' }}</p>
                </div>

                <a href="{{ route('pelamar.jobs.index') }}"
                   class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700">
                    ← Kembali
                </a>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 space-y-6">
                <div class="flex flex-wrap gap-2">
                    @foreach([$job->tipe, $job->level, $job->kategori] as $tag)
                        @if($tag)
                            <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-700">{{ $tag }}</span>
                        @endif
                    @endforeach
                </div>

                <div>
                    <h2 class="text-sm font-semibold text-gray-900">Deskripsi</h2>
                    <p class="mt-2 text-sm text-gray-700 whitespace-pre-line">{{ $job->deskripsi ?? '-' }}</p>
                </div>

                <div>
                    <h2 class="text-sm font-semibold text-gray-900">Kualifikasi</h2>
                    <p class="mt-2 text-sm text-gray-700 whitespace-pre-line">{{ $job->kualifikasi ?? '-' }}</p>
                </div>

                <div class="border-t border-gray-200 pt-6 flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        @if($job->deadline)
                            Deadline: <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}</span>
                        @endif
                    </div>

                    @if($alreadyApplied)
                        <span class="text-sm font-medium text-gray-700 bg-gray-100 px-4 py-2 rounded-xl">
                            Sudah Melamar
                        </span>
                    @else
                        <a href="{{ route('pelamar.jobs.applyForm', $job->id) }}"
                           class="rounded-xl bg-black px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-900">
                            Ajukan Lamaran
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
