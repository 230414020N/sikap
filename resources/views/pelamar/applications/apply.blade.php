@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-[#E5E7EB]">
    <aside class="w-64 bg-[#E5E7EB] border-r border-gray-300 hidden md:flex flex-col p-6 sticky top-0 h-screen">
        <div class="mb-10 px-2 font-bold text-2xl tracking-tighter italic text-gray-900">
            SIKAP<span class="text-xs font-normal align-top not-italic">.</span>
        </div>
        <nav class="flex-1 space-y-2 text-sm font-medium">
            <a href="{{ route('pelamar.jobs.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 bg-[#4B4B4B] text-white shadow-md transition">
                <span>🔍</span> Cari Lowongan
            </a>
            <a href="{{ route('pelamar.profile.show') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-200 transition">
                <span>👤</span> Profil Saya
            </a>
        </nav>
    </aside>

    <main class="flex-1 bg-[#4B4B4B] p-6 lg:p-10 overflow-y-auto">
        <header class="flex justify-between items-center mb-10 text-white">
            <div>
                <h1 class="text-2xl font-black uppercase tracking-tight">Kirim Lamaran</h1>
                <p class="text-sm opacity-70">Langkah terakhir sebelum impianmu jadi nyata.</p>
            </div>
            <a href="{{ route('pelamar.jobs.show', $job->id) }}" class="text-xs font-bold uppercase tracking-widest hover:text-[#00D1A0] transition">
                ← Kembali ke Detail
            </a>
        </header>

        <div class="max-w-4xl mx-auto bg-[#D1D5DB] rounded-[40px] p-8 lg:p-12 shadow-2xl space-y-8">
            
            <div class="bg-white rounded-[32px] p-8 shadow-sm">
                <div class="flex flex-col md:flex-row justify-between gap-6">
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#00D1A0] mb-2 block">Anda Melamar Untuk:</span>
                        <h2 class="text-3xl font-black text-gray-900 leading-tight">{{ $job->judul }}</h2>
                        <p class="text-gray-500 font-bold text-lg italic">{{ $job->company->nama }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2 content-start">
                        <span class="px-4 py-1.5 bg-gray-900 text-white rounded-full text-[10px] font-bold uppercase">{{ $job->tipe }}</span>
                        <span class="px-4 py-1.5 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-bold uppercase">{{ $job->lokasi }}</span>
                    </div>
                </div>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl text-red-700 text-sm">
                    ⚠️ Ada beberapa input yang belum valid. Mohon periksa kembali.
                </div>
            @endif

            <div class="bg-white rounded-[32px] p-8 shadow-sm space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-[#00D1A0] rounded-full"></span> Lampiran Dokumen
                    </h3>
                    <a href="/pelamar/profile" class="text-xs font-bold text-[#00D1A0] hover:underline uppercase">Kelola Profil →</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-6 rounded-2xl border-2 {{ $profile?->cv_path ? 'border-emerald-100 bg-emerald-50/30' : 'border-dashed border-gray-300' }}">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-bold uppercase text-gray-400">Curriculum Vitae</span>
                            @if($profile?->cv_path)
                                <span class="text-[10px] font-bold bg-emerald-500 text-white px-2 py-0.5 rounded">READY</span>
                            @else
                                <span class="text-[10px] font-bold bg-red-500 text-white px-2 py-0.5 rounded">MISSING</span>
                            @endif
                        </div>
                        <p class="text-sm font-black text-gray-800 tracking-tight">{{ $profile?->cv_path ? 'CV_Utama.pdf' : 'Belum diunggah' }}</p>
                    </div>

                    <div class="p-6 rounded-2xl border-2 {{ $portofolios->count() > 0 ? 'border-emerald-100 bg-emerald-50/30' : 'border-dashed border-gray-300' }}">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-bold uppercase text-gray-400">Portofolio</span>
                            <span class="text-[10px] font-bold bg-gray-900 text-white px-2 py-0.5 rounded">{{ $portofolios->count() }} ITEMS</span>
                        </div>
                        <p class="text-sm font-black text-gray-800 tracking-tight">Portofolio akan dilampirkan otomatis</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[32px] p-8 shadow-sm">
                <form action="{{ route('pelamar.jobs.apply', $job->id) }}" method="POST" onsubmit="return confirm('Kirim lamaran sekarang?')">
                    @csrf
                    
                    <div class="space-y-4">
                        <label class="text-sm font-black uppercase tracking-widest text-gray-900 block">Pesan Singkat Untuk HRD (Opsional)</label>
                        <textarea name="catatan_pelamar" rows="4"
                            class="w-full rounded-[20px] border-2 border-gray-100 bg-gray-50 px-6 py-4 text-sm text-gray-900
                            focus:outline-none focus:border-[#00D1A0] transition-all duration-300 italic"
                            placeholder="Ceritakan singkat mengapa kamu kandidat yang tepat...">{{ old('catatan_pelamar') }}</textarea>
                    </div>

                    <div class="mt-10 flex flex-col sm:flex-row gap-4">
                        <button type="submit" class="flex-1 bg-[#00D1A0] hover:bg-emerald-400 text-gray-900 font-black uppercase tracking-widest py-4 rounded-2xl shadow-lg transition-all transform hover:-translate-y-1">
                            Kirim Lamaran Sekarang
                        </button>
                        <a href="{{ route('pelamar.jobs.show', $job->id) }}" class="px-8 py-4 text-center font-bold text-gray-400 hover:text-gray-900 transition uppercase tracking-widest text-xs">
                            Batalkan
                        </a>
                    </div>
                    @if(session('success'))
                    <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
                        <div class="bg-white rounded-[40px] p-10 max-w-md w-full text-center shadow-2xl mx-4">
                            <div class="w-20 h-20 bg-black rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-black mb-2">Berhasil!</h2>
                            <p class="text-gray-500 mb-8 leading-relaxed">
                                Lamaran kamu telah terkirim ke <span class="font-bold text-gray-800">[{{ $job->company->nama }}]</span>. <br>
                                Kamu bisa memantau statusnya di menu 'Lamaran'.
                            </p>
                            <button onclick="document.getElementById('successModal').remove()" 
                                class="w-full bg-[#00D1A0] text-gray-900 font-black py-4 rounded-2xl uppercase tracking-widest hover:bg-emerald-400 transition">
                                Oke, Mengerti
                            </button>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </div>

        <footer class="mt-20 text-center text-gray-400 text-xs py-6">
            © 2026, Sistem Informasi Karier dan Portofolio (SIKAP)
        </footer>
    </main>
</div>
@endsection