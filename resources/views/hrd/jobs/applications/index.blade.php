@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6 mb-8">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-4 py-2 text-xs text-gray-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-gray-900"></span>
                        Lamaran per Lowongan
                    </div>

                    <h1 class="mt-4 text-2xl sm:text-3xl font-semibold tracking-tight text-gray-900">
                        {{ $job->judul }}
                    </h1>

                    <p class="mt-2 text-sm text-gray-600">
                        Total lamaran: {{ $applications->total() }}
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('hrd.jobs.index') }}"
                       class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                        Kembali
                    </a>

                    <a href="{{ route('hrd.jobs.edit', $job->id) }}"
                       class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                        Edit Lowongan
                    </a>

                    <a href="{{ route('hrd.applications.index') }}"
                       class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-black transition">
                        Semua Lamaran
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-2xl border border-gray-200 bg-white px-5 py-4 text-sm text-gray-900">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-5 border-b border-gray-200">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div class="md:col-span-2">
                            <input type="text" name="q" value="{{ $search }}"
                                   placeholder="Cari nama atau email kandidat…"
                                   class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black/10 focus:border-gray-400 transition">
                        </div>

                        <div class="flex gap-3">
                            <select name="status"
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black/10 focus:border-gray-400 transition">
                                <option value="">Semua Status</option>
                                @foreach($statuses as $s)
                                    <option value="{{ $s }}" @selected($status === $s)>{{ $s }}</option>
                                @endforeach
                            </select>

                            <button type="submit"
                                    class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-black transition">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>

                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="text-left px-5 py-3">Kandidat</th>
                            <th class="text-left px-5 py-3">Status</th>
                            <th class="text-left px-5 py-3">Tanggal</th>
                            <th class="text-right px-5 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $app)
                            <tr class="border-t border-gray-200">
                                <td class="px-5 py-4">
                                    <p class="font-medium text-gray-900">{{ $app->pelamar?->name ?? 'Pelamar' }}</p>
                                    <p class="text-xs text-gray-600">{{ $app->pelamar?->email ?? '-' }}</p>
                                </td>

                                <td class="px-5 py-4">
                                    <span class="text-xs px-3 py-1 rounded-full border border-gray-200 bg-gray-50 text-gray-800">
                                        {{ $app->status ?? 'Dikirim' }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-gray-700">
                                    {{ $app->created_at?->format('d M Y, H:i') }}
                                </td>

                                <td class="px-5 py-4 text-right">
                                    <a href="{{ route('hrd.applications.show', $app->id) }}"
                                       class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-black transition">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-10 text-center text-gray-600">
                                    Belum ada lamaran untuk lowongan ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $applications->links() }}
            </div>
        </div>
    </div>
@endsection
