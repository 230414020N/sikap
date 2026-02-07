@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-[#E5E7EB]">
    <aside class="w-64 bg-white border-r border-gray-300 hidden md:flex flex-col p-6 sticky top-0 h-screen">
        <div class="mb-10 px-2 font-bold text-2xl tracking-tighter italic text-gray-900">
            SIKAP<span class="text-xs font-normal align-top not-italic">.</span>
        </div>
        <nav class="flex-1 space-y-2">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-200 transition">
                <span>🏠</span> Dashboard
            </a>
            <a href="{{ route('pelamar.jobs.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-200 transition">
                <span>🔍</span> Cari Lowongan
            </a>
            <a href="{{ route('pelamar.portofolio.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-200 transition">
                <span>📂</span> Portofolio
            </a>
            <a href="/profile" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium bg-[#4B4B4B] text-white shadow-md transition">
                <span>👤</span> Profil Saya
            </a>
        </nav>
    </aside>

    <main class="flex-1 bg-[#4B4B4B] p-6 lg:p-10 overflow-y-auto">
        <header class="flex justify-between items-center mb-10">
            <div class="text-white">
                <h1 class="text-2xl font-bold tracking-tight">Pengaturan Profil</h1>
                <p class="text-sm opacity-70">Kelola informasi publik dan dokumen profesional Anda.</p>
            </div>
            <div class="flex items-center gap-4 text-white">
                <span class="text-sm font-medium">({{ Auth::user()->name }})</span>
                <div class="w-10 h-10 rounded-full bg-black flex items-center justify-center border border-gray-600 shadow-lg">👤</div>
            </div>
        </header>

        <div class="max-w-4xl mx-auto mb-6">
            @if(session('success'))
                <div class="mb-4 rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-400 backdrop-blur-md">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-400 backdrop-blur-md">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="max-w-4xl mx-auto bg-[#D1D5DB] rounded-[40px] p-8 lg:p-12 shadow-xl">
            @php
                $fotoUrl = $profile->foto_path ? asset('storage/'.$profile->foto_path) : null;
                $tanggalLahir = old('tanggal_lahir', $profile->tanggal_lahir ? (is_string($profile->tanggal_lahir) ? $profile->tanggal_lahir : $profile->tanggal_lahir->format('Y-m-d')) : '');
                $jk = old('jenis_kelamin', $profile->jenis_kelamin);
            @endphp

            <form method="POST" action="{{ route('pelamar.profile.update') }}" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="bg-white rounded-[32px] p-8 shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-[#00D1A0] rounded-full"></span> Foto & Ringkasan
                    </h2>
                    
                    <div class="flex flex-col md:flex-row gap-8 items-start">
                        <div class="relative group">
                            <div class="w-32 h-32 rounded-[2rem] overflow-hidden border-4 border-[#D1D5DB] bg-gray-100 flex items-center justify-center shadow-inner">
                                @if($fotoUrl)
                                    <img id="fotoPreview" src="{{ $fotoUrl }}" alt="Profile" class="w-full h-full object-cover" />
                                @else
                                    <span class="text-4xl">👤</span>
                                    <img id="fotoPreview" src="" class="hidden w-full h-full object-cover" />
                                @endif
                            </div>
                            <label class="absolute -bottom-2 -right-2 bg-black text-white p-2 rounded-xl cursor-pointer hover:bg-[#00D1A0] transition shadow-lg">
                                📷 <input type="file" name="foto" class="hidden" onchange="previewFoto(event)">
                            </label>
                        </div>

                        <div class="flex-1 w-full space-y-4">
                            <div>
                                <label class="text-xs font-bold uppercase tracking-widest text-gray-400 ml-1">Headline Profesional</label>
                                <input type="text" name="headline" value="{{ old('headline', $profile->headline) }}" placeholder="Contoh: Web Developer | UI Designer"
                                    class="mt-1 w-full rounded-2xl border-none bg-gray-100 px-5 py-3.5 text-sm focus:ring-2 focus:ring-[#00D1A0] transition">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400 ml-1">Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $profile->nama_lengkap) }}"
                                        class="mt-1 w-full rounded-2xl border-none bg-gray-100 px-5 py-3.5 text-sm focus:ring-2 focus:ring-[#00D1A0] transition">
                                </div>
                                <div>
                                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400 ml-1">Nomor HP</label>
                                    <input type="text" name="no_hp" value="{{ old('no_hp', $profile->no_hp) }}"
                                        class="mt-1 w-full rounded-2xl border-none bg-gray-100 px-5 py-3.5 text-sm focus:ring-2 focus:ring-[#00D1A0] transition">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <label class="text-xs font-bold uppercase tracking-widest text-gray-400 ml-1">Bio Singkat</label>
                        <textarea name="bio" rows="3" class="mt-1 w-full rounded-2xl border-none bg-gray-100 px-5 py-3.5 text-sm focus:ring-2 focus:ring-[#00D1A0] transition" 
                            placeholder="Ceritakan pengalaman singkat Anda...">{{ old('bio', $profile->bio) }}</textarea>
                    </div>
                </div>

                <div class="bg-white rounded-[32px] p-8 shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-[#00D1A0] rounded-full"></span> Data & Pendidikan
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs font-bold uppercase tracking-widest text-gray-400 ml-1">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" value="{{ $tanggalLahir }}" class="mt-1 w-full rounded-2xl border-none bg-gray-100 px-5 py-3.5 text-sm focus:ring-2 focus:ring-[#00D1A0] transition">
                            </div>
                            <div>
                                <label class="text-xs font-bold uppercase tracking-widest text-gray-400 ml-1">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="mt-1 w-full rounded-2xl border-none bg-gray-100 px-5 py-3.5 text-sm focus:ring-2 focus:ring-[#00D1A0] transition">
                                    <option value="pria" {{ $jk === 'pria' ? 'selected' : '' }}>Pria</option>
                                    <option value="wanita" {{ $jk === 'wanita' ? 'selected' : '' }}>Wanita</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-bold uppercase tracking-widest text-gray-400 ml-1">Domisili</label>
                                <input type="text" name="domisili" value="{{ old('domisili', $profile->domisili) }}" class="mt-1 w-full rounded-2xl border-none bg-gray-100 px-5 py-3.5 text-sm focus:ring-2 focus:ring-[#00D1A0] transition">
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs font-bold uppercase tracking-widest text-gray-400 ml-1">Pendidikan Terakhir</label>
                                <input type="text" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir', $profile->pendidikan_terakhir) }}" placeholder="S1 Teknik Informatika" class="mt-1 w-full rounded-2xl border-none bg-gray-100 px-5 py-3.5 text-sm focus:ring-2 focus:ring-[#00D1A0] transition">
                            </div>
                            <div>
                                <label class="text-xs font-bold uppercase tracking-widest text-gray-400 ml-1">Institusi / Universitas</label>
                                <input type="text" name="institusi" value="{{ old('institusi', $profile->institusi) }}" class="mt-1 w-full rounded-2xl border-none bg-gray-100 px-5 py-3.5 text-sm focus:ring-2 focus:ring-[#00D1A0] transition">
                            </div>
                            <div>
                                <label class="text-xs font-bold uppercase tracking-widest text-gray-400 ml-1">Tahun Lulus</label>
                                <input type="number" name="tahun_lulus" value="{{ old('tahun_lulus', $profile->tahun_lulus) }}" class="mt-1 w-full rounded-2xl border-none bg-gray-100 px-5 py-3.5 text-sm focus:ring-2 focus:ring-[#00D1A0] transition">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[32px] p-8 shadow-sm space-y-8">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-2 flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-[#00D1A0] rounded-full"></span> Keterampilan
                        </h2>
                        <div class="flex gap-2 mb-4">
                            <input id="skillInput" type="text" placeholder="Tambah skill..." class="flex-1 rounded-2xl border-none bg-gray-100 px-5 py-3 text-sm focus:ring-2 focus:ring-[#00D1A0]">
                            <button type="button" onclick="addChip('skill')" class="bg-black text-white px-6 rounded-2xl text-sm font-bold">Tambah</button>
                        </div>
                        <div id="skillChips" class="flex flex-wrap gap-2"></div>
                        <div id="skillHidden"></div>
                    </div>

                    <hr class="border-gray-100">

                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-[#00D1A0] rounded-full"></span> Dokumen Pendukung
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-6 rounded-[24px] border border-dashed border-gray-300">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Curriculum Vitae (PDF)</label>
                                <input type="file" name="cv" class="text-xs mb-3">
                                @if($profile->cv_path)
                                    <a href="{{ asset('storage/'.$profile->cv_path) }}" target="_blank" class="text-[10px] bg-[#00D1A0] text-black font-bold px-3 py-1 rounded-full uppercase">Lihat CV Saat Ini</a>
                                @endif
                            </div>
                            <div class="bg-gray-50 p-6 rounded-[24px] border border-dashed border-gray-300">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Surat Lamaran (PDF)</label>
                                <input type="file" name="surat_lamaran" class="text-xs mb-3">
                                @if($profile->surat_lamaran_path)
                                    <a href="{{ asset('storage/'.$profile->surat_lamaran_path) }}" target="_blank" class="text-[10px] bg-[#00D1A0] text-black font-bold px-3 py-1 rounded-full uppercase">Lihat Surat</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <button type="submit" class="bg-[#00D1A0] text-gray-900 font-extrabold px-12 py-4 rounded-2xl hover:bg-emerald-400 transition-all shadow-lg uppercase tracking-tight">
                        Simpan Perubahan Profil
                    </button>
                </div>
            </form>
        </div>

        <footer class="mt-20 text-center text-gray-400 text-xs py-6">
            © 2026, Sistem Informasi Karier dan Portofolio (SIKAP)
        </footer>
    </main>
</div>

<script>
    // Preview Foto Logic
    function previewFoto(event) {
        const file = event.target.files[0];
        if (!file) return;
        const url = URL.createObjectURL(file);
        const img = document.getElementById('fotoPreview');
        img.src = url;
        img.classList.remove('hidden');
    }

    // Chips Logic (Skills & Language)
    const state = { skill: new Set(), lang: new Set() };
    const initialSkills = @json($profile->keterampilan ?? []);
    const initialLangs = @json($profile->bahasa ?? []);

    if(Array.isArray(initialSkills)) initialSkills.forEach(v => state.skill.add(String(v)));
    if(Array.isArray(initialLangs)) initialLangs.forEach(v => state.lang.add(String(v)));

    function addChip(type) {
        const input = document.getElementById(type + 'Input');
        const val = input.value.trim();
        if (val) {
            state[type].add(val);
            input.value = '';
            render(type);
        }
    }

    function removeChip(type, val) {
        state[type].delete(val);
        render(type);
    }

    function render(type) {
        const container = document.getElementById(type + 'Chips');
        const hidden = document.getElementById(type + 'Hidden');
        container.innerHTML = '';
        hidden.innerHTML = '';

        state[type].forEach(val => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'bg-gray-900 text-white text-xs px-4 py-2 rounded-full flex items-center gap-2 hover:bg-red-500 transition';
            btn.innerHTML = `${val} <span>×</span>`;
            btn.onclick = () => removeChip(type, val);
            container.appendChild(btn);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = type === 'skill' ? 'keterampilan[]' : 'bahasa[]';
            input.value = val;
            hidden.appendChild(input);
        });
    }

    render('skill');
</script>
@endsection