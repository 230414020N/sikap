@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Detail Lamaran</h1>
                <p class="mt-1 text-sm text-gray-600">{{ $application->job->judul }}</p>
            </div>
            <span class="inline-flex text-xs px-3 py-1 rounded-full border border-gray-200 bg-white font-medium text-gray-900">
                {{ $application->status }}
            </span>
        </div>

        <div class="mt-6 bg-white border border-gray-200 rounded-3xl shadow-sm p-6">
            <p class="text-sm text-gray-500">Kandidat</p>
            <p class="text-lg font-semibold text-gray-900">{{ $application->pelamar->name }}</p>
            <p class="text-sm text-gray-600">{{ $application->pelamar->email }}</p>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Tanggal melamar</p>
                    <p class="text-sm font-medium text-gray-900">{{ $application->created_at->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Catatan pelamar</p>
                    <p class="text-sm text-gray-900">{{ $application->catatan_pelamar ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
