<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 @extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="mb-8">
                <h1 class="text-2xl font-semibold text-gray-900">Cari Lowongan</h1>
                <p class="mt-1 text-sm text-gray-600">Cari dan filter lowongan sesuai minat kamu.</p>
            </div>

            <form method="GET" class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <input name="q" value="{{ request('q') }}"
                        class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-black focus:border-black"
                        placeholder="Cari judul (contoh: UI/UX, Backend)" />

                    <input name="lokasi" value="{{ request('lokasi') }}"
                        class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-black focus:border-black"
                        placeholder="Lokasi" />

                    <select name="tipe" class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-black focus:border-black">
                        <option value="">Tipe</option>
                        @foreach(['Full-time','Part-time','Internship'] as $t)
                            <option value="{{ $t }}" @selected(request('tipe')==$t)>{{ $t }}</option>
                        @endforeach
                    </select>

                    <select name="level" class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-black focus:border-black">
                        <option value="">Level</option>
                        @foreach(['Junior','Mid','Senior'] as $l)
                            <option value="{{ $l }}" @selected(request('level')==$l)>{{ $l }}</option>
                        @endforeach
                    </select>

                    <select name="kategori" class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-black focus:border-black">
                        <option value="">Kategori</option>
                        @foreach(['Web','Mobile','UI/UX','Data','Design'] as $k)
                            <option value="{{ $k }}" @selected(request('kategori')==$k)>{{ $k }}</option>
                        @endforeach
                    </select>

                    <input name="gaji_min" value="{{ request('gaji_min') }}" placeholder="Gaji min"
                        class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-black focus:border-black" />

                    <input name="gaji_max" value="{{ request('gaji_max') }}" placeholder="Gaji max"
                        class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-black focus:border-black" />

                    <select name="sort" class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-black focus:border-black">
                        <option value="latest" @selected((request('sort') ?? 'latest') === 'latest')>Terbaru</option>
                        <option value="deadline" @selected(request('sort')==='deadline')>Deadline Terdekat</option>
                    </select>
                </div>

                <div class="mt-4 flex justify-end gap-3">
                    <a href="{{ route('pelamar.jobs.index') }}"
                        class="rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-50">
                        Reset
                    </a>
                    <button class="rounded-xl bg-black px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-900">
                        Filter
                    </button>
                </div>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse($jobs as $job)
                    <a href="{{ route('pelamar.jobs.show', $job->id) }}"
                       class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 hover:border-gray-300 transition block">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-base font-semibold text-gray-900">{{ $job->judul }}</h2>
                                <p class="mt-1 text-sm text-gray-600">{{ $job->company->nama }}</p>
                            </div>
                            <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-700">
                                {{ $job->tipe ?? '—' }}
                            </span>
                        </div>

                        <p class="mt-3 text-sm text-gray-700">
                            {{ $job->lokasi ?? 'Lokasi tidak disebutkan' }}
                            • {{ $job->level ?? 'Level —' }}
                            • {{ $job->kategori ?? 'Kategori —' }}
                        </p>

                        @if($job->deadline)
                            <p class="mt-3 text-xs text-gray-500">Deadline: {{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}</p>
                        @endif
                    </a>
                @empty
                    <div class="col-span-full bg-white border border-gray-200 rounded-2xl shadow-sm p-10 text-center text-gray-600">
                        Tidak ada lowongan ditemukan.
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
@endsection
py-10">
            <div class="mb-8">
                <h1 class="text-2xl font-semibold text-gray-900">Cari Lowongan</h1>
                <p class="mt-1 text-sm text-gray-600">Cari dan filter lowongan sesuai minat kamu.</p>
            </div>

            <form method="GET" class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <input name="q" value="{{ request('q') }}"
                        class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-black focus:border-black"
                        placeholder="Cari judul (contoh: UI/UX, Backend)" />

                    <input name="lokasi" value="{{ request('lokasi') }}"
                        class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-black focus:border-black"
                        placeholder="Lokasi" />

                    <select name="tipe" class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-black focus:border-black">
                        <option value="">Tipe</option>
                        @foreach(['Full-time','Part-time','Internship'] as $t)
                            <option value="{{ $t }}" @selected(request('tipe')==$t)>{{ $t }}</option>
                        @endforeach
                    </select>

                    <select name="level" class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-black focus:border-black">
                        <option value="">Level</option>
                        @foreach(['Junior','Mid','Senior'] as $l)
                            <option value="{{ $l }}" @selected(request('level')==$l)>{{ $l }}</option>
                        @endforeach
                    </select>

                    <select name="kategori" class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-black focus:border-black">
                        <option value="">Kategori</option>
                        @foreach(['Web','Mobile','UI/UX','Data','Design'] as $k)
                            <option value="{{ $k }}" @selected(request('kategori')==$k)>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4 flex justify-end gap-3">
                    <a href="{{ route('pelamar.jobs.index') }}"
                        class="rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-50">
                        Reset
                    </a>
                    <button class="rounded-xl bg-black px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-900">
                        Filter
                    </button>
                </div>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse($jobs as $job)
                    <a href="{{ route('pelamar.jobs.show', $job->id) }}"
                       class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 hover:border-gray-300 transition block">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-base font-semibold text-gray-900">{{ $job->judul }}</h2>
                                <p class="mt-1 text-sm text-gray-600">{{ $job->company->nama }}</p>
                            </div>
                            <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-700">
                                {{ $job->tipe ?? '—' }}
                            </span>
                        </div>

                        <p class="mt-3 text-sm text-gray-700">
                            {{ $job->lokasi ?? 'Lokasi tidak disebutkan' }}
                            • {{ $job->level ?? 'Level —' }}
                            • {{ $job->kategori ?? 'Kategori —' }}
                        </p>

                        @if($job->deadline)
                            <p class="mt-3 text-xs text-gray-500">Deadline: {{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}</p>
                        @endif
                    </a>
                @empty
                    <div class="col-span-full bg-white border border-gray-200 rounded-2xl shadow-sm p-10 text-center text-gray-600">
                        Tidak ada lowongan ditemukan.
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
<input name="gaji_min" value="{{ request('gaji_min') }}" placeholder="Gaji min"
  class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-black focus:border-black" />

<input name="gaji_max" value="{{ request('gaji_max') }}" placeholder="Gaji max"
  class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-black focus:border-black" />

<select name="sort" class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-black focus:border-black">
  <option value="latest" @selected(request('sort')==='latest')>Terbaru</option>
  <option value="deadline" @selected(request('sort')==='deadline')>Deadline Terdekat</option>
</select>
