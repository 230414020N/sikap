@extends('layouts.app')

@section('title', 'Tambah Lowongan')

@section('content')
@php
    $defaultActive = (string) old('is_active', '1') === '1';
@endphp

<div class="flex min-h-screen bg-[#E5E7EB]">
    <aside class="w-64 bg-[#E5E7EB] border-r border-gray-300 hidden md:flex flex-col p-6 sticky top-0 h-screen">
        <div class="mb-10 px-2 font-bold text-2xl tracking-tighter italic text-gray-900">
            SIKAP<span class="text-xs font-normal align-top not-italic">.</span>
        </div>
        <nav class="flex-1 space-y-2 text-sm font-medium">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-200 transition">
                <span>🏠</span> Dashboard
            </a>
            <a href="{{ route('hrd.jobs.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 bg-[#4B4B4B] text-white shadow-md transition">
                <span>💼</span> Kelola Lowongan
            </a>
            <a href="#" class="flex items-center gap-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-200 transition">
                <span>👥</span> Pelamar Masuk
            </a>
            <a href="#" class="flex items-center gap-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-200 transition">
                <span>🏢</span> Profil Perusahaan
            </a>
        </nav>
        <div class="mt-auto border-t border-gray-300 pt-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="flex items-center gap-3 w-full px-4 py-3 text-gray-600 hover:text-red-600 transition">
                    <span>🚪</span> Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 bg-[#4B4B4B] p-6 lg:p-10">
        <header class="flex justify-between items-center mb-10 text-white">
            <div>
                <h1 class="text-4xl font-black uppercase tracking-tight">BUAT LOWONGAN</h1>
                <p class="text-sm opacity-70">Publikasikan kesempatan kerja baru untuk talenta terbaik.</p>
            </div>
            <a href="{{ route('hrd.jobs.index') }}" class="text-sm font-bold border-b-2 border-white pb-1 hover:opacity-70 transition">
                ← KEMBALI
            </a>
        </header>

        @if($errors->any())
            <div class="mb-8 p-4 bg-red-500 text-white rounded-2xl font-bold text-sm shadow-lg">
                ⚠️ Ada beberapa kesalahan pada input Anda. Silakan periksa kembali.
            </div>
        @endif

        <form method="POST" action="{{ route('hrd.jobs.store') }}">
            @csrf
            
            <div class="space-y-8">
                <div class="bg-[#D1D5DB] rounded-[40px] p-8 shadow-inner">
                    <h2 class="text-xl font-black text-gray-900 mb-6 uppercase tracking-tight">1. Informasi Utama</h2>
                    <div class="bg-white rounded-[32px] p-8 space-y-6 shadow-sm">
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Judul Pekerjaan</label>
                            <input type="text" name="judul" value="{{ old('judul') }}"
                                   class="mt-2 w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-4 text-sm font-bold text-gray-900 focus:border-[#3498DB] focus:bg-white focus:outline-none transition"
                                   placeholder="Contoh: Senior UI/UX Designer" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Kategori</label>
                                <select name="job_category_id" class="mt-2 w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-4 text-sm font-bold text-gray-900 focus:border-[#3498DB] focus:outline-none transition">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}" @selected(old('job_category_id') == $c->id)>{{ $c->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Lokasi</label>
                                <select name="job_location_id" class="mt-2 w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-4 text-sm font-bold text-gray-900 focus:border-[#3498DB] focus:outline-none transition">
                                    <option value="">Pilih Lokasi</option>
                                    @foreach($locations as $l)
                                        <option value="{{ $l->id }}" @selected(old('job_location_id') == $l->id)>{{ $l->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pendidikan</label>
                                <select name="education_level_id" class="mt-2 w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-4 text-sm font-bold text-gray-900 focus:border-[#3498DB] focus:outline-none transition">
                                    <option value="">Minimal Pendidikan</option>
                                    @foreach($educationLevels as $e)
                                        <option value="{{ $e->id }}" @selected(old('education_level_id') == $e->id)>{{ $e->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tipe Pekerjaan</label>
                                <input type="text" name="tipe" value="{{ old('tipe') }}" placeholder="Full-time, Contract, Freelance"
                                       class="mt-2 w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-4 text-sm font-bold text-gray-900 focus:border-[#3498DB] focus:outline-none transition">
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Level Jabatan</label>
                                <input type="text" name="level" value="{{ old('level') }}" placeholder="Entry, Mid, Senior"
                                       class="mt-2 w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-4 text-sm font-bold text-gray-900 focus:border-[#3498DB] focus:outline-none transition">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-[#D1D5DB] rounded-[40px] p-8 shadow-inner">
                    <h2 class="text-xl font-black text-gray-900 mb-6 uppercase tracking-tight">2. Kompensasi & Batas Waktu</h2>
                    <div class="bg-white rounded-[32px] p-8 grid grid-cols-1 md:grid-cols-3 gap-6 shadow-sm">
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Gaji Minimal</label>
                            <input type="number" name="gaji_min" value="{{ old('gaji_min') }}" placeholder="Rp 0"
                                   class="mt-2 w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-4 text-sm font-bold text-gray-900 focus:border-[#3498DB] focus:outline-none transition">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Gaji Maksimal</label>
                            <input type="number" name="gaji_max" value="{{ old('gaji_max') }}" placeholder="Rp 0"
                                   class="mt-2 w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-4 text-sm font-bold text-gray-900 focus:border-[#3498DB] focus:outline-none transition">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Batas Lamaran</label>
                            <input type="date" name="deadline" value="{{ old('deadline') }}"
                                   class="mt-2 w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-4 text-sm font-bold text-gray-900 focus:border-[#3498DB] focus:outline-none transition">
                        </div>
                    </div>
                </div>

                <div class="bg-[#D1D5DB] rounded-[40px] p-8 shadow-inner">
                    <h2 class="text-xl font-black text-gray-900 mb-6 uppercase tracking-tight">3. Deskripsi & Kualifikasi</h2>
                    <div class="bg-white rounded-[32px] p-8 space-y-6 shadow-sm">
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Deskripsi Pekerjaan</label>
                            <textarea name="deskripsi" rows="6" 
                                      class="mt-2 w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-4 text-sm font-bold text-gray-900 focus:border-[#3498DB] focus:outline-none transition"
                                      placeholder="Jelaskan peran dan tanggung jawab pekerjaan ini...">{{ old('deskripsi') }}</textarea>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Kualifikasi Kandidat</label>
                            <textarea name="kualifikasi" rows="6" 
                                      class="mt-2 w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-4 text-sm font-bold text-gray-900 focus:border-[#3498DB] focus:outline-none transition"
                                      placeholder="Sebutkan keahlian atau syarat khusus yang dibutuhkan...">{{ old('kualifikasi') }}</textarea>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" name="is_active" value="1" id="is_active"
                                       class="w-5 h-5 rounded border-gray-300 text-[#3498DB] focus:ring-[#3498DB]"
                                       @checked($defaultActive)>
                                <label for="is_active" class="text-sm font-black text-gray-900 uppercase">Tampilkan Lowongan Sekarang</label>
                            </div>
                            <span class="text-[10px] font-bold text-gray-400 italic">OFF / ON</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 pb-10">
                    <button type="submit" class="bg-[#3498DB] hover:bg-blue-600 text-white font-black px-12 py-5 rounded-2xl shadow-xl transform active:scale-95 transition-all uppercase tracking-widest text-sm">
                        Publish Lowongan
                    </button>
                </div>
            </div>
        </form>

        <footer class="mt-4 text-center text-gray-400 text-xs py-6">
            © 2026, Sistem Informasi Karier dan Portofolio (SIKAP)
        </footer>
    </main>
</div>
@endsection