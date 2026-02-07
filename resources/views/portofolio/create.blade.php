@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex items-start justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Tambah Portofolio</h1>
                    <p class="mt-1 text-sm text-gray-600">Isi detail proyek dan lampirkan thumbnail jika ada.</p>
                </div>

                <a href="{{ route('pelamar.portofolio.index') }}"
                   class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700">
                    ← Kembali
                </a>
            </div>

            <form action="{{ route('pelamar.portofolio.store') }}" method="POST" enctype="multipart/form-data"
                  class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 space-y-6">
                @csrf

                <x-input name="judul" label="Judul" placeholder="Contoh: Sistem Informasi Karir & Portofolio" />

                <x-textarea name="deskripsi" label="Deskripsi" rows="5"
                            placeholder="Jelaskan tujuan proyek, fitur utama, dan kontribusi kamu." />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <x-input name="kategori" label="Kategori" placeholder="Web / Mobile / UI/UX / Data" />
                    <x-input name="tools" label="Tools" placeholder="Laravel, Figma, Python..." />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <x-input name="link_demo" label="Link Demo" type="url" placeholder="https://..." />
                    <x-input name="link_github" label="Link GitHub" type="url" placeholder="https://..." />
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-900">Thumbnail (jpg/png, max 10MB)</label>
                    <input type="file" name="thumbnail"
                           class="block w-full text-sm text-gray-700 file:mr-4 file:rounded-xl file:border-0
                           file:bg-gray-900 file:text-white file:px-4 file:py-2 file:text-sm hover:file:bg-black transition" />
                    @error('thumbnail')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('pelamar.portofolio.index') }}"
                       class="inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-medium
                       bg-white border border-gray-300 text-gray-900 hover:bg-gray-50 transition">
                        Batal
                    </a>

                    <x-button>Simpan</x-button>
                </div>
            </form>
        </div>
    </div>
@endsection
