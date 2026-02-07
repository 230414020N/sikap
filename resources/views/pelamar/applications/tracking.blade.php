
@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="mb-8">
                <h1 class="text-2xl font-semibold text-gray-900">Tracking Lamaran</h1>
                <p class="mt-1 text-sm text-gray-600">Pantau status lamaran kamu secara real-time.</p>
            </div>

            @if(session('success'))
                <div class="rounded-xl bg-gray-900 text-white px-4 py-3 text-sm mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-4">
                @forelse($applications as $app)
                    <a href="{{ route('pelamar.applications.show', $app->id) }}"
                       class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 flex items-center justify-between hover:border-gray-300 transition">
                        <div>
                            <h2 class="text-base font-semibold text-gray-900">{{ $app->job->judul }}</h2>
                            <p class="mt-1 text-sm text-gray-600">{{ $app->job->company->nama }}</p>
                            <p class="mt-2 text-xs text-gray-500">Dikirim: {{ $app->created_at->format('d M Y, H:i') }}</p>
                        </div>

                        <span class="text-xs px-4 py-2 rounded-full bg-gray-100 text-gray-800 font-medium">
                            {{ $app->status }}
                        </span>
                    </a>
                @empty
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-10 text-center text-gray-600">
                        Belum ada lamaran.
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $applications->links() }}
            </div>
        </div>
    </div>
@endsection
```
