@extends('layouts.app')

@section('content')
    @php
        $hasErrors = $errors->any();
        $defaultActive = (string) old('is_active', (string) (int) ($job->is_active ?? 0)) === '1';
    @endphp

<div class="max-w-6xl mx-auto px-4 py-8">
    {{-- Header Section --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Lowongan Kerja</h1>
        <p class="text-sm text-gray-500">Kelola dan perbarui informasi lowongan posisi {{ $job->judul }}</p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-500 text-white px-6 py-3 rounded-xl font-medium shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('hrd.jobs.update', $job->id) }}">
        @csrf
        @method('PUT')

        {{-- Main Card (Mirip tampilan Detail di Gambar) --}}
        <div class="bg-white p-8 rounded-[20px] shadow-sm border border-gray-100 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Sisi Kiri: Info Posisi --}}
                <div class="space-y-4">
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Judul Posisi</label>
                        <input type="text" name="judul" value="{{ old('judul', $job->judul) }}" 
                               class="block w-full mt-1 text-xl font-bold text-gray-800 border-none focus:ring-0 p-0 placeholder-gray-300" 
                               placeholder="Masukkan Judul Lowongan..." required>
                        @error('judul') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-wrap gap-3 mt-4">
                        {{-- Badge Style Inputs (Border hitam tipis sesuai gambar) --}}
                        <div class="border border-black rounded-lg px-4 py-2 flex items-center gap-2">
                            <span class="text-sm font-medium">Tipe:</span>
                            <input type="text" name="tipe" value="{{ old('tipe', $job->tipe) }}" 
                                   class="border-none focus:ring-0 p-0 text-sm w-24 bg-transparent" placeholder="Full-time">
                        </div>
                        
                        <div class="border border-black rounded-lg px-4 py-2 flex items-center gap-2">
                            <span class="text-sm font-medium">Gaji:</span>
                            <input type="number" name="gaji_min" value="{{ old('gaji_min', $job->gaji_min) }}" class="border-none focus:ring-0 p-0 text-sm w-20 bg-transparent text-right" placeholder="Min">
                            <span>-</span>
                            <input type="number" name="gaji_max" value="{{ old('gaji_max', $job->gaji_max) }}" class="border-none focus:ring-0 p-0 text-sm w-20 bg-transparent" placeholder="Max">
                        </div>

                        <div class="border border-black rounded-lg px-4 py-2 flex items-center gap-2">
                            <span class="text-sm font-medium">Level:</span>
                            <input type="text" name="level" value="{{ old('level', $job->level) }}" class="border-none focus:ring-0 p-0 text-sm w-24 bg-transparent" placeholder="2 Tahun">
                        </div>
                    </div>
                </div>

                {{-- Sisi Kanan: Metadata --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Kategori</label>
                        <select name="job_category_id" class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-[#3AB4F2] focus:ring-[#3AB4F2]">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}" @selected((string) old('job_category_id', $job->job_category_id) === (string) $c->id)>{{ $c->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Lokasi</label>
                        <select name="job_location_id" class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-[#3AB4F2] focus:ring-[#3AB4F2]">
                            <option value="">Pilih Lokasi</option>
                            @foreach($locations as $l)
                                <option value="{{ $l->id }}" @selected((string) old('job_location_id', $job->job_location_id) === (string) $l->id)>{{ $l->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Pendidikan</label>
                        <select name="education_level_id" class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-[#3AB4F2] focus:ring-[#3AB4F2]">
                            @foreach($educationLevels as $e)
                                <option value="{{ $e->id }}" @selected((string) old('education_level_id', $job->education_level_id) === (string) $e->id)>{{ $e->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Deadline</label>
                        <input type="date" name="deadline" value="{{ old('deadline', $job->deadline ? \Illuminate\Support\Carbon::parse($job->deadline)->format('Y-m-d') : null) }}"
                               class="w-full rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-[#3AB4F2] focus:ring-[#3AB4F2]">
                    </div>
                </div>
            </div>

            <hr class="my-8 border-gray-100">

            {{-- Deskripsi & Kualifikasi --}}
            <div class="space-y-8">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">Deskripsi Pekerjaan</h3>
                    <textarea name="deskripsi" rows="4" class="w-full rounded-xl border-gray-100 bg-gray-50 p-4 text-sm focus:ring-[#3AB4F2] focus:border-[#3AB4F2]" placeholder="Tuliskan deskripsi pekerjaan...">{{ old('deskripsi', $job->deskripsi) }}</textarea>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">Kualifikasi</h3>
                    <textarea name="kualifikasi" rows="4" class="w-full rounded-xl border-gray-100 bg-gray-50 p-4 text-sm focus:ring-[#3AB4F2] focus:border-[#3AB4F2]" placeholder="Tuliskan kualifikasi yang dibutuhkan...">{{ old('kualifikasi', $job->kualifikasi) }}</textarea>
                </div>
            </div>

            {{-- Status Toggle --}}
            <div class="mt-8 pt-6 border-t border-gray-50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" id="is_active" @checked($defaultActive) class="w-5 h-5 rounded border-gray-300 text-[#3AB4F2] focus:ring-[#3AB4F2]">
                    <label for="is_active" class="text-sm font-bold text-gray-700">Tampilkan Lowongan ke Publik</label>
                </div>
                <span class="text-xs text-gray-400 italic font-medium">Status saat ini: {{ $job->is_active ? 'Aktif' : 'Non-Aktif' }}</span>
            </div>
        </div>

        {{-- Action Buttons (Mirip Gambar: Kanan Bawah) --}}
        <div class="flex justify-end items-center gap-4 mt-8">
            <a href="{{ route('hrd.jobs.index') }}" 
               class="px-10 py-3 bg-[#3AB4F2] text-white rounded-lg font-bold text-sm hover:bg-blue-500 transition-all shadow-md shadow-blue-100">
                Kembali
            </a>
            <button type="submit" 
                    class="px-10 py-3 bg-[#2ECC71] text-white rounded-lg font-bold text-sm hover:bg-green-600 transition-all shadow-md shadow-green-100">
                Simpan Perubahan
            </button>
        </div>
    </form>

    {{-- Danger Zone (Opsional, diletakkan terpisah agar tidak merusak UI simpan) --}}
    <div class="mt-20 border-t border-red-100 pt-8">
        <div class="flex items-center justify-between opacity-50 hover:opacity-100 transition">
            <p class="text-xs text-red-400 font-medium">Ingin menghapus lowongan ini secara permanen?</p>
            <form method="POST" action="{{ route('hrd.jobs.destroy', $job->id) }}" onsubmit="return confirm('Hapus lowongan ini?');">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-500 text-xs font-bold underline">Hapus Lowongan</button>
            </form>
        </div>
    </div>
</div>

<style>
    body { background-color: #F8FAFC; font-family: 'Plus Jakarta Sans', sans-serif; }
    input[type="number"]::-webkit-inner-spin-button, 
    input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
</style>
@endsection