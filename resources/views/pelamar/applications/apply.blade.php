@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex items-start justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Ajukan Lamaran</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ $job->judul }} • {{ $job->company->nama }}
                        @if($job->lokasi) • {{ $job->lokasi }} @endif
                    </p>
                </div>

                <a href="{{ route('pelamar.jobs.show', $job->id) }}"
                   class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700">
                    ← Kembali
                </a>
            </div>

            @if($errors->any())
                <x-alert type="error" class="mb-6">
                    Ada beberapa input yang belum valid. Coba cek lagi ya.
                </x-alert>
            @endif

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 space-y-6">
                {{-- Ringkasan lowongan --}}
                <div class="rounded-2xl border border-gray-200 p-5">
                    <div class="flex flex-wrap gap-2">
                        @foreach([$job->tipe, $job->level, $job->kategori] as $tag)
                            @if($tag)
                                <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-700">
                                    {{ $tag }}
                                </span>
                            @endif
                        @endforeach
                    </div>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                        <div>
                            <p class="text-xs text-gray-500">Deadline</p>
                            <p class="mt-1 font-medium text-gray-900">
                                @if($job->deadline)
                                    {{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}
                                @else
                                    —
                                @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">Rentang Gaji</p>
                            <p class="mt-1 font-medium text-gray-900">
                                @if($job->gaji_min || $job->gaji_max)
                                    {{ $job->gaji_min ? number_format($job->gaji_min, 0, ',', '.') : '—' }}
                                    -
                                    {{ $job->gaji_max ? number_format($job->gaji_max, 0, ',', '.') : '—' }}
                                @else
                                    —
                                @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">Perusahaan</p>
                            <p class="mt-1 font-medium text-gray-900">{{ $job->company->nama }}</p>
                        </div>
                    </div>
                </div>

                {{-- Info lampiran --}}
                <x-alert type="info">
                    Sistem akan melampirkan <span class="font-medium">dokumen (CV & surat lamaran)</span> dan
                    <span class="font-medium">portofolio</span> kamu secara otomatis saat lamaran dikirim.
                </x-alert>

                <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 space-y-5">
                    {{-- Dokumen --}}
                    <div>
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Dokumen</p>
                                <p class="mt-1 text-xs text-gray-600">Diambil dari halaman Profil.</p>
                            </div>

                            <a href="{{ route('pelamar.profile.edit') }}"
                               class="text-xs text-gray-900 underline underline-offset-4 hover:text-gray-700">
                                Kelola Profil
                            </a>
                        </div>

                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                            {{-- CV --}}
                            <div class="rounded-xl border border-gray-200 bg-white p-4 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">CV</p>
                                    <p class="mt-1 text-xs text-gray-600">PDF/DOC, max 10MB</p>
                                </div>

                                @if($profile?->cv_path)
                                    <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-800 font-medium">
                                        Ada
                                    </span>
                                @else
                                    <span class="text-xs px-3 py-1 rounded-full bg-red-600 text-white font-medium">
                                        Belum ada
                                    </span>
                                @endif
                            </div>

                            {{-- Surat Lamaran --}}
                            <div class="rounded-xl border border-gray-200 bg-white p-4 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Surat Lamaran</p>
                                    <p class="mt-1 text-xs text-gray-600">PDF/DOC, max 10MB</p>
                                </div>

                                @if($profile?->surat_lamaran_path)
                                    <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-800 font-medium">
                                        Ada
                                    </span>
                                @else
                                    <span class="text-xs px-3 py-1 rounded-full bg-red-600 text-white font-medium">
                                        Belum ada
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if(!$profile?->cv_path || !$profile?->surat_lamaran_path)
                            <p class="mt-3 text-xs text-gray-600">
                                Kamu tetap bisa mengirim lamaran, tapi disarankan lengkapi dokumen dulu di
                                <a class="underline underline-offset-4" href="{{ route('pelamar.profile.edit') }}">Profil</a>.
                            </p>
                        @endif
                    </div>

                    {{-- Portofolio --}}
                    <div class="border-t border-gray-200 pt-5">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Portofolio</p>
                                <p class="mt-1 text-xs text-gray-600">
                                    Yang dilampirkan otomatis: <span class="font-medium text-gray-900">{{ $portofolios->count() }}</span> item.
                                </p>
                            </div>

                            <a href="{{ route('pelamar.portofolio.index') }}"
                               class="text-xs text-gray-900 underline underline-offset-4 hover:text-gray-700">
                                Kelola Portofolio
                            </a>
                        </div>

                        @if($portofolios->isEmpty())
                            <div class="mt-4 rounded-xl border border-gray-200 bg-white p-4">
                                <p class="text-sm text-gray-700">
                                    Kamu belum punya portofolio. Portofolio opsional, tapi bisa membantu HRD menilai kamu lebih cepat.
                                </p>
                                <a href="{{ route('pelamar.portofolio.create') }}"
                                   class="mt-3 inline-flex items-center rounded-xl bg-black px-4 py-2 text-sm font-medium text-white hover:bg-gray-900 transition">
                                    + Tambah Portofolio
                                </a>
                            </div>
                        @else
                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($portofolios as $p)
                                    <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
                                        <div class="flex">
                                            <div class="w-24 h-24 bg-gray-100 flex-shrink-0 overflow-hidden">
                                                @if($p->thumbnail_path)
                                                    <img src="{{ asset('storage/' . $p->thumbnail_path) }}"
                                                         alt="{{ $p->judul }}"
                                                         class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">
                                                        No Thumbnail
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="p-4 min-w-0 flex-1">
                                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $p->judul }}</p>
                                                <p class="mt-1 text-xs text-gray-600">
                                                    {{ $p->kategori ?? 'Tanpa kategori' }}
                                                    @if($p->tools) • {{ $p->tools }} @endif
                                                </p>

                                                <div class="mt-3 flex flex-wrap gap-2">
                                                    @if($p->link_demo)
                                                        <a href="{{ $p->link_demo }}" target="_blank"
                                                           class="text-xs rounded-full border border-gray-300 px-3 py-1 hover:bg-gray-50">
                                                            Demo
                                                        </a>
                                                    @endif
                                                    @if($p->link_github)
                                                        <a href="{{ $p->link_github }}" target="_blank"
                                                           class="text-xs rounded-full border border-gray-300 px-3 py-1 hover:bg-gray-50">
                                                            GitHub
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        @if($p->deskripsi)
                                            <div class="px-4 pb-4">
                                                <p class="text-sm text-gray-700">
                                                    {{ \Illuminate\Support\Str::limit($p->deskripsi, 110) }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Form --}}
                <form action="{{ route('pelamar.jobs.apply', $job->id) }}" method="POST" class="space-y-6"
                      onsubmit="return confirm('Kirim lamaran untuk lowongan ini sekarang?')">
                    @csrf

                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-900">Catatan untuk HRD (opsional)</label>
                        <textarea name="catatan_pelamar" rows="5"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900
                            focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
                            placeholder="Tulis pesan singkat (contoh: alasan tertarik, pengalaman relevan, ketersediaan jadwal, dll).">{{ old('catatan_pelamar') }}</textarea>

                        @error('catatan_pelamar')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('pelamar.jobs.show', $job->id) }}"
                           class="rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                            Batal
                        </a>

                        <button type="submit"
                                class="rounded-xl bg-black px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-900 transition">
                            Kirim Lamaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
