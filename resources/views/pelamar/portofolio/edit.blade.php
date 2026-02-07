@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-[#E5E7EB]">
    <aside class="w-64 bg-[#E5E7EB] border-r border-gray-300 hidden md:flex flex-col p-6 sticky top-0 h-screen">
        <div class="mb-10 px-2 font-bold text-2xl tracking-tighter italic text-gray-900">
            SIKAP<span class="text-xs font-normal align-top not-italic">.</span>
        </div>
        <nav class="flex-1 space-y-2">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-200 transition">
                <span>🏠</span> Dashboard
            </a>
             <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-200 transition">
                <span>👤</span> Profile
            </a>
            <a href="{{ route('pelamar.portofolio.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium bg-[#4B4B4B] text-white shadow-md transition">
                <span>📂</span> Project
            </a>
            <a href="{{ route('pelamar.applications.tracking') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-200 transition">
                <span>💼</span> Lamaran
            </a>
            </nav>
        <div class="pt-10 border-t border-gray-300">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-sm font-medium text-gray-600 hover:text-red-600 transition">
                    <span>🚪</span> Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 bg-[#4B4B4B] p-6 lg:p-10 overflow-y-auto">
        <header class="flex justify-between items-center mb-10">
            <div class="relative w-72">
                <input type="text" placeholder="Cari Lowongan Pekerjaan" class="w-full bg-gray-200 border-none rounded-xl py-2 px-4 text-sm focus:ring-0">
            </div>
            <div class="flex items-center gap-4 text-white">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-medium">({{ Auth::user()->name }})</span>
                    <div class="w-8 h-8 rounded-full bg-black flex items-center justify-center text-xs border border-gray-600">👤</div>
                </div>
            </div>
        </header>

        <div class="max-w-4xl mx-auto bg-[#D1D5DB] rounded-[40px] p-10 shadow-lg">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Ubah Proyek Anda</h1>
                <p class="text-gray-600 text-sm mt-1">Lengkapi detail proyek di bawah ini untuk menampilkan portofolio terbaikmu.</p>
            </div>

            @if($errors->any())
                <div class="mb-6 rounded-xl bg-red-100 border border-red-200 text-red-700 p-4 text-sm">
                    Terdapat kesalahan pada input Anda. Silakan periksa kembali.
                </div>
            @endif

            <form method="POST" action="{{ route('pelamar.portofolio.update', $portofolio->id) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-transparent focus-within:border-gray-400 transition">
                    <input type="text" name="judul" value="{{ old('judul', $portofolio->judul) }}" 
                        placeholder="Masukkan Judul Proyek Anda"
                        class="w-full border-none px-6 py-4 text-gray-700 focus:ring-0 placeholder-gray-400" required>
                </div>
                @error('judul') <p class="text-red-600 text-xs ml-2">{{ $message }}</p> @enderror

                <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-transparent focus-within:border-gray-400 transition">
                    <textarea name="deskripsi" rows="6" 
                        placeholder="Masukkan Deskripsi Proyek Anda"
                        class="w-full border-none px-6 py-4 text-gray-700 focus:ring-0 placeholder-gray-400 leading-relaxed">{{ old('deskripsi', $portofolio->deskripsi) }}</textarea>
                </div>
                @error('deskripsi') <p class="text-red-600 text-xs ml-2">{{ $message }}</p> @enderror

                <div class="bg-white rounded-xl overflow-hidden shadow-sm flex items-center px-6 border border-transparent focus-within:border-gray-400 transition">
                    <span class="text-gray-400">🔗</span>
                    <input type="url" name="link_github" value="{{ old('link_github', $portofolio->link_github) }}" 
                        placeholder="Masukkan Link GitHub/Website Anda"
                        class="w-full border-none py-4 bg-transparent text-gray-700 focus:ring-0 placeholder-gray-400 ml-2">
                </div>
                @error('link_github') <p class="text-red-600 text-xs ml-2">{{ $message }}</p> @enderror

                <div class="py-4">
                    <hr class="border-gray-400">
                </div>

                <div class="relative group">
                    <label for="thumbnail" class="cursor-pointer">
                        <div class="w-full aspect-[21/9] border-4 border-dashed border-gray-400 rounded-[32px] flex flex-col items-center justify-center bg-white/50 hover:bg-white transition-all overflow-hidden relative group">
                            @if($portofolio->thumbnail_path)
                                <img id="img_preview" src="{{ asset('storage/' . $portofolio->thumbnail_path) }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:opacity-40 transition">
                            @endif
                            
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="bg-white p-4 rounded-full shadow-md mb-4">
                                    <svg class="w-10 h-10 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-xl font-bold text-gray-800 uppercase tracking-wide">Unggah Thumbnail</span>
                                <span class="text-sm text-gray-500 font-medium">( max. 5 MB )</span>
                            </div>
                        </div>
                    </label>
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="hidden" onchange="previewImage(this)">
                </div>
                @error('thumbnail') <p class="text-red-600 text-xs ml-2">{{ $message }}</p> @enderror

                <div class="flex justify-end pt-6">
                    <button type="submit" class="bg-[#00D1A0] text-gray-900 font-extrabold px-12 py-3.5 rounded-2xl hover:bg-emerald-400 transition-all shadow-[0_4px_14px_0_rgba(0,209,160,0.39)] uppercase tracking-tight">
                        Simpan Proyek
                    </button>
                </div>

                <input type="hidden" name="is_public" value="{{ $portofolio->is_public }}">
            </form>
        </div>

        <footer class="mt-20 text-center text-gray-400 text-xs py-6">
            © 2025, Sistem Informasi Karier dan Portofolio
        </footer>
    </main>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                let img = document.getElementById('img_preview');
                if (!img) {
                    // Jika belum ada tag img (dari database), buat baru
                    img = document.createElement('img');
                    img.id = 'img_preview';
                    img.className = 'absolute inset-0 w-full h-full object-cover opacity-60 transition';
                    input.parentElement.querySelector('div').prepend(img);
                }
                img.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection