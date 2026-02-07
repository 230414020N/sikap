@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex items-start justify-between gap-6 mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">FR-A05 • Moderasi Showcase</h1>
                    <p class="mt-1 text-sm text-gray-600">Approve/Reject portofolio yang masuk showcase.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-2xl bg-gray-900 text-white px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 mb-6">
                <form method="GET" action="{{ route('admin.showcase.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <div class="sm:col-span-2">
                        <label class="text-sm font-medium text-gray-900">Cari</label>
                        <input type="text" name="q" value="{{ request('q') }}"
                               class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
                               placeholder="Judul, tools, kategori, nama/email pelamar">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-900">Status</label>
                        <select name="status"
                                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                            @foreach(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'all' => 'Semua'] as $k => $v)
                                <option value="{{ $k }}" @selected(($status ?? 'pending') === $k)>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-900">Urutkan</label>
                        <select name="sort"
                                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                            <option value="latest" @selected(request('sort','latest')==='latest')>Terbaru</option>
                            <option value="oldest" @selected(request('sort')==='oldest')>Terlama</option>
                        </select>
                    </div>

                    <div class="sm:col-span-4 flex justify-end">
                        <button type="submit"
                                class="rounded-xl bg-black px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-900 transition">
                            Terapkan
                        </button>
                    </div>
                </form>
            </div>

            @if($portofolios->isEmpty())
                <div class="rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700">
                    Tidak ada data.
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($portofolios as $p)
                        <a href="{{ route('admin.showcase.show', $p->id) }}"
                           class="block rounded-2xl border border-gray-200 bg-white overflow-hidden hover:shadow-sm transition">
                            <div class="h-40 bg-gray-100 overflow-hidden">
                                @if($p->thumbnail_path)
                                    <img src="{{ asset('storage/' . $p->thumbnail_path) }}" class="w-full h-full object-cover" alt="{{ $p->judul }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">No Thumbnail</div>
                                @endif
                            </div>

                            <div class="p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $p->judul }}</p>
                                        <p class="mt-1 text-xs text-gray-600 truncate">{{ $p->user?->name }} • {{ $p->user?->email }}</p>
                                    </div>

                                    @php
                                        $st = $p->moderation_status ?: 'pending';
                                        $label = strtoupper($st);
                                    @endphp
                                    <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-800 font-medium">
                                        {{ $label }}
                                    </span>
                                </div>

                                <p class="mt-2 text-xs text-gray-600">
                                    {{ $p->kategori ?: 'Tanpa kategori' }}
                                    @if($p->tools) • {{ $p->tools }} @endif
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $portofolios->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
