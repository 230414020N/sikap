@extends('layouts.app')

@section('header')
    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Buat Lowongan</h1>
            <p class="mt-1 text-sm text-gray-600">Lengkapi informasi lowongan sebelum dipublikasikan.</p>
        </div>

        <a href="{{ route('hrd.jobs.index') }}"
           class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700">
            ← Kembali
        </a>
    </div>
@endsection

@section('content')
    @php
        $defaultActive = (string) old('is_active', '1') === '1';
        $hasErrors = $errors->any();
    @endphp

    <div class="min-h-screen bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            @if($hasErrors)
                <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                    Input belum valid. Coba cek field yang bertanda merah.
                </div>
            @endif

            <form method="POST" action="{{ route('hrd.jobs.store') }}"
                  class="bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
                @csrf

                <div class="p-6 border-b border-gray-200">
                    <p class="text-sm font-semibold text-gray-900">Informasi Utama</p>
                    <p class="mt-1 text-xs text-gray-600">Judul, kategori, lokasi, pendidikan, dan tipe pekerjaan.</p>
                </div>

                <div class="p-6 space-y-6">
                    <div>
                        <label class="text-xs font-medium text-gray-700">Judul</label>
                        <input type="text" name="judul" value="{{ old('judul') }}"
                               @class([
                                   'mt-2 w-full rounded-2xl border px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/10 transition',
                                   'border-red-300 bg-red-50 focus:border-red-300' => $errors->has('judul'),
                                   'border-gray-200 bg-white focus:border-gray-300' => !$errors->has('judul'),
                               ])
                               placeholder="Contoh: Frontend Developer"
                               required>
                        @error('judul') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="text-xs font-medium text-gray-700">Kategori</label>
                            <select name="job_category_id"
                                    @class([
                                        'mt-2 w-full rounded-2xl border px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/10 transition',
                                        'border-red-300 bg-red-50 focus:border-red-300' => $errors->has('job_category_id'),
                                        'border-gray-200 bg-white focus:border-gray-300' => !$errors->has('job_category_id'),
                                    ])>
                                <option value="">— Pilih —</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" @selected((string) old('job_category_id') === (string) $c->id)>{{ $c->nama }}</option>
                                @endforeach
                            </select>
                            @error('job_category_id') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-xs font-medium text-gray-700">Lokasi</label>
                            <select name="job_location_id"
                                    @class([
                                        'mt-2 w-full rounded-2xl border px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/10 transition',
                                        'border-red-300 bg-red-50 focus:border-red-300' => $errors->has('job_location_id'),
                                        'border-gray-200 bg-white focus:border-gray-300' => !$errors->has('job_location_id'),
                                    ])>
                                <option value="">— Pilih —</option>
                                @foreach($locations as $l)
                                    <option value="{{ $l->id }}" @selected((string) old('job_location_id') === (string) $l->id)>{{ $l->nama }}</option>
                                @endforeach
                            </select>
                            @error('job_location_id') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-xs font-medium text-gray-700">Pendidikan</label>
                            <select name="education_level_id"
                                    @class([
                                        'mt-2 w-full rounded-2xl border px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/10 transition',
                                        'border-red-300 bg-red-50 focus:border-red-300' => $errors->has('education_level_id'),
                                        'border-gray-200 bg-white focus:border-gray-300' => !$errors->has('education_level_id'),
                                    ])>
                                <option value="">— Pilih —</option>
                                @foreach($educationLevels as $e)
                                    <option value="{{ $e->id }}" @selected((string) old('education_level_id') === (string) $e->id)>{{ $e->nama }}</option>
                                @endforeach
                            </select>
                            @error('education_level_id') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-medium text-gray-700">Tipe</label>
                            <input type="text" name="tipe" value="{{ old('tipe') }}"
                                   @class([
                                       'mt-2 w-full rounded-2xl border px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/10 transition',
                                       'border-red-300 bg-red-50 focus:border-red-300' => $errors->has('tipe'),
                                       'border-gray-200 bg-white focus:border-gray-300' => !$errors->has('tipe'),
                                   ])
                                   placeholder="Full-time / Part-time / Internship">
                            @error('tipe') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-xs font-medium text-gray-700">Level</label>
                            <input type="text" name="level" value="{{ old('level') }}"
                                   @class([
                                       'mt-2 w-full rounded-2xl border px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/10 transition',
                                       'border-red-300 bg-red-50 focus:border-red-300' => $errors->has('level'),
                                       'border-gray-200 bg-white focus:border-gray-300' => !$errors->has('level'),
                                   ])
                                   placeholder="Junior / Mid / Senior">
                            @error('level') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="px-6 py-5 border-t border-b border-gray-200 bg-gray-50">
                    <p class="text-sm font-semibold text-gray-900">Kompensasi & Timeline</p>
                    <p class="mt-1 text-xs text-gray-600">Rentang gaji dan batas akhir lamaran.</p>
                </div>

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-medium text-gray-700">Gaji Min</label>
                            <input type="number" name="gaji_min" value="{{ old('gaji_min') }}"
                                   @class([
                                       'mt-2 w-full rounded-2xl border px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/10 transition',
                                       'border-red-300 bg-red-50 focus:border-red-300' => $errors->has('gaji_min'),
                                       'border-gray-200 bg-white focus:border-gray-300' => !$errors->has('gaji_min'),
                                   ])
                                   min="0" placeholder="0">
                            @error('gaji_min') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-xs font-medium text-gray-700">Gaji Max</label>
                            <input type="number" name="gaji_max" value="{{ old('gaji_max') }}"
                                   @class([
                                       'mt-2 w-full rounded-2xl border px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/10 transition',
                                       'border-red-300 bg-red-50 focus:border-red-300' => $errors->has('gaji_max'),
                                       'border-gray-200 bg-white focus:border-gray-300' => !$errors->has('gaji_max'),
                                   ])
                                   min="0" placeholder="0">
                            @error('gaji_max') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                        <div>
                            <label class="text-xs font-medium text-gray-700">Deadline</label>
                            <input type="date" name="deadline" value="{{ old('deadline') }}"
                                   @class([
                                       'mt-2 w-full rounded-2xl border px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/10 transition',
                                       'border-red-300 bg-red-50 focus:border-red-300' => $errors->has('deadline'),
                                       'border-gray-200 bg-white focus:border-gray-300' => !$errors->has('deadline'),
                                   ])>
                            @error('deadline') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="rounded-3xl border border-gray-200 bg-white p-5">
                            <p class="text-xs font-semibold text-gray-900">Tips</p>
                            <p class="mt-2 text-xs text-gray-600">Tulis rentang gaji agar kandidat lebih tertarik. Deadline disarankan minimal 7 hari dari hari ini.</p>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-5 border-t border-b border-gray-200 bg-gray-50">
                    <p class="text-sm font-semibold text-gray-900">Deskripsi & Kualifikasi</p>
                    <p class="mt-1 text-xs text-gray-600">Jelaskan tanggung jawab, kriteria kandidat, dan ekspektasi.</p>
                </div>

                <div class="p-6 space-y-6">
                    <div>
                        <label class="text-xs font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" rows="6"
                                  @class([
                                      'mt-2 w-full rounded-2xl border px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/10 transition',
                                      'border-red-300 bg-red-50 focus:border-red-300' => $errors->has('deskripsi'),
                                      'border-gray-200 bg-white focus:border-gray-300' => !$errors->has('deskripsi'),
                                  ])
                                  placeholder="Tulis gambaran peran, tanggung jawab, dan ruang lingkup pekerjaan.">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-xs font-medium text-gray-700">Kualifikasi</label>
                        <textarea name="kualifikasi" rows="6"
                                  @class([
                                      'mt-2 w-full rounded-2xl border px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/10 transition',
                                      'border-red-300 bg-red-50 focus:border-red-300' => $errors->has('kualifikasi'),
                                      'border-gray-200 bg-white focus:border-gray-300' => !$errors->has('kualifikasi'),
                                  ])
                                  placeholder="Tulis kualifikasi minimum dan nilai plus.">{{ old('kualifikasi') }}</textarea>
                        @error('kualifikasi') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="is_active" value="1"
                                   class="rounded border-gray-300 text-gray-900 shadow-sm focus:ring-gray-900"
                                   @checked($defaultActive)>
                            <span class="text-sm text-gray-700">Aktif</span>
                        </label>

                        <div class="rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-xs text-gray-600">
                            Jika tidak aktif, lowongan tidak tampil di pencarian pelamar.
                        </div>
                    </div>
                </div>

                <div class="px-6 py-5 border-t border-gray-200 bg-white flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3">
                    <a href="{{ route('hrd.jobs.index') }}"
                       class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-5 py-3 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                        Batal
                    </a>

                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-2xl bg-gray-900 px-5 py-3 text-sm font-medium text-white hover:bg-black transition shadow-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
