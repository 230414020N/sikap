@extends('layouts.app')

@section('content')
    @php
        $statusClass = function ($status) {
            $s = strtolower((string) $status);

            if (str_contains($s, 'diterima') || str_contains($s, 'lolos') || str_contains($s, 'accepted') || str_contains($s, 'hire')) {
                return 'border-green-200 bg-green-50 text-green-800';
            }

            if (str_contains($s, 'ditolak') || str_contains($s, 'gagal') || str_contains($s, 'rejected') || str_contains($s, 'reject')) {
                return 'border-red-200 bg-red-50 text-red-800';
            }

            if (str_contains($s, 'interview') || str_contains($s, 'wawancara')) {
                return 'border-blue-200 bg-blue-50 text-blue-800';
            }

            if (str_contains($s, 'review') || str_contains($s, 'diproses') || str_contains($s, 'proses') || str_contains($s, 'screen')) {
                return 'border-amber-200 bg-amber-50 text-amber-800';
            }

            return 'border-gray-200 bg-gray-50 text-gray-800';
        };

        $total = method_exists($applications, 'total') ? $applications->total() : (is_countable($applications) ? count($applications) : 0);
        $jobSelected = (string) request('job_id', '');
        $statusSelected = (string) request('status', '');
        $hasFilters = (string) request()->getQueryString() !== '';
    @endphp

    <div class="min-h-screen bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Lamaran Masuk</h1>
                    <p class="mt-1 text-sm text-gray-600">Search & filter kandidat berdasarkan pendidikan, pengalaman, dan keyword.</p>
                </div>

                <div class="flex items-center gap-2">
                    <div class="rounded-2xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-700">
                        Total: <span class="font-semibold text-gray-900">{{ $total }}</span>
                    </div>

                    @if($hasFilters)
                        <a href="{{ route('hrd.applications.index') }}"
                           class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                            Reset
                        </a>
                    @endif
                </div>
            </div>

            @if(session('success'))
                <div class="mt-6">
                    <x-alert type="success">{{ session('success') }}</x-alert>
                </div>
            @endif

            @if($errors->any())
                <div class="mt-6">
                    <x-alert type="error">Input filter belum valid.</x-alert>
                </div>
            @endif

            <div class="mt-8 bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200">
                    <p class="text-sm font-semibold text-gray-900">Filter</p>
                    <p class="mt-1 text-xs text-gray-600">Pilih lowongan, status, dan detail kandidat untuk mempersempit hasil.</p>
                </div>

                <form method="GET" action="{{ route('hrd.applications.index') }}" class="p-6 grid grid-cols-1 sm:grid-cols-12 gap-4">
                    <div class="sm:col-span-4">
                        <label class="text-xs font-medium text-gray-700">Keyword</label>
                        <input type="text" name="q" value="{{ request('q') }}"
                               class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition"
                               placeholder="Nama / email / jurusan / lowongan / portofolio">
                    </div>

                    <div class="sm:col-span-4">
                        <label class="text-xs font-medium text-gray-700">Lowongan</label>
                        <select name="job_id"
                                class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition">
                            <option value="">Semua lowongan</option>
                            @foreach($jobs as $j)
                                <option value="{{ $j->id }}" @selected((string) $j->id === $jobSelected)>{{ $j->judul }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="text-xs font-medium text-gray-700">Status</label>
                        <select name="status"
                                class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition">
                            <option value="">Semua status</option>
                            @foreach($statusOptions as $st)
                                <option value="{{ $st }}" @selected((string) $st === $statusSelected)>{{ $st }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="text-xs font-medium text-gray-700">Urutkan</label>
                        <select name="sort"
                                class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition">
                            <option value="latest" @selected((request('sort') ?? 'latest') === 'latest')>Terbaru</option>
                            <option value="oldest" @selected(request('sort') === 'oldest')>Terlama</option>
                        </select>
                    </div>

                    <div class="sm:col-span-3">
                        <label class="text-xs font-medium text-gray-700">Pendidikan</label>
                        <input type="text" name="pendidikan" value="{{ request('pendidikan') }}"
                               class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition"
                               placeholder="Contoh: S1">
                    </div>

                    <div class="sm:col-span-3">
                        <label class="text-xs font-medium text-gray-700">Jurusan</label>
                        <input type="text" name="jurusan" value="{{ request('jurusan') }}"
                               class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition"
                               placeholder="Contoh: Teknik Informatika">
                    </div>

                    <div class="sm:col-span-3">
                        <label class="text-xs font-medium text-gray-700">Institusi</label>
                        <input type="text" name="institusi" value="{{ request('institusi') }}"
                               class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition"
                               placeholder="Nama kampus/sekolah">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="text-xs font-medium text-gray-700">Tahun Lulus</label>
                        <input type="number" name="tahun_lulus" value="{{ request('tahun_lulus') }}"
                               class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition"
                               placeholder="2024">
                    </div>

                    <div class="sm:col-span-4">
                        <label class="text-xs font-medium text-gray-700">Pengalaman</label>
                        <input type="text" name="pengalaman" value="{{ request('pengalaman') }}"
                               class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition"
                               placeholder="Keyword pengalaman (bio/portofolio)">
                    </div>

                    <div class="sm:col-span-12 flex flex-col sm:flex-row sm:justify-end gap-2 pt-2">
                        <a href="{{ route('hrd.applications.index') }}"
                           class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-5 py-3 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                            Reset
                        </a>
                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-2xl bg-gray-900 px-5 py-3 text-sm font-medium text-white hover:bg-black transition shadow-sm">
                            Terapkan
                        </button>
                    </div>
                </form>
            </div>

            <div class="mt-6 bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
                    <p class="text-sm font-semibold text-gray-900">Daftar Kandidat</p>
                    <p class="text-xs text-gray-500">Menampilkan hasil sesuai filter</p>
                </div>

                <div class="hidden sm:block">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="text-left px-6 py-3 font-medium">Kandidat</th>
                                <th class="text-left px-6 py-3 font-medium">Lowongan</th>
                                <th class="text-left px-6 py-3 font-medium">Status</th>
                                <th class="text-left px-6 py-3 font-medium">Tanggal</th>
                                <th class="text-right px-6 py-3 font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications as $a)
                                <tr class="border-t border-gray-200">
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-900">{{ $a->pelamar->name }}</p>
                                        <p class="text-xs text-gray-600">{{ $a->pelamar->email }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-gray-900">{{ $a->job->judul }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex text-xs px-3 py-1 rounded-full border font-medium {{ $statusClass($a->status) }}">
                                            {{ $a->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">{{ $a->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('hrd.applications.show', $a->id) }}"
                                           class="text-gray-900 underline underline-offset-4 hover:text-gray-700">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-600">
                                        Tidak ada data yang cocok.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="sm:hidden divide-y divide-gray-200">
                    @forelse($applications as $a)
                        <div class="px-6 py-5">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $a->pelamar->name }}</p>
                                    <p class="mt-1 text-xs text-gray-600 truncate">{{ $a->pelamar->email }}</p>
                                </div>
                                <span class="shrink-0 inline-flex text-xs px-3 py-1 rounded-full border font-medium {{ $statusClass($a->status) }}">
                                    {{ $a->status }}
                                </span>
                            </div>

                            <p class="mt-3 text-sm text-gray-900 font-medium truncate">{{ $a->job->judul }}</p>

                            <div class="mt-3 flex items-center justify-between">
                                <p class="text-xs text-gray-500">{{ $a->created_at->format('d M Y') }}</p>
                                <a href="{{ route('hrd.applications.show', $a->id) }}"
                                   class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700">
                                    Detail
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-10 text-center text-gray-600">
                            Tidak ada data yang cocok.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-6">
                {{ $applications->links() }}
            </div>
        </div>
    </div>
@endsection
