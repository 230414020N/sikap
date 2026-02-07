@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex items-start justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Tambah Portofolio</h1>
                    <p class="mt-1 text-sm text-gray-600">Buat showcase baru untuk portofolio kamu.</p>
                </div>

                <a href="{{ route('pelamar.portofolio.index') }}"
                   class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700">
                    ← Kembali
                </a>
            </div>

            @if($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    Input belum valid.
                </div>
            @endif

            <form method="POST" action="{{ route('pelamar.portofolio.store') }}" enctype="multipart/form-data"
                  class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 space-y-6">
                @csrf

                <div>
                    <label class="text-sm font-medium text-gray-900">Judul</label>
                    <input type="text" name="judul" value="{{ old('judul') }}"
                           class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
                           required>
                    @error('judul') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-900">Deskripsi</label>
                    <textarea name="deskripsi" rows="6"
                              class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-900">Kategori</label>
                        <input type="text" name="kategori" value="{{ old('kategori') }}"
                               class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
                               placeholder="UI/UX, Web, Mobile, Data, dsb">
                        @error('kategori') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-900">Tools</label>
                        <input type="text" name="tools" value="{{ old('tools') }}"
                               class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
                               placeholder="Figma, Laravel, React, dsb">
                        @error('tools') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-900">Link Demo</label>
                        <input type="url" name="link_demo" value="{{ old('link_demo') }}"
                               class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
                               placeholder="https://...">
                        @error('link_demo') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-900">Link GitHub</label>
                        <input type="url" name="link_github" value="{{ old('link_github') }}"
                               class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
                               placeholder="https://...">
                        @error('link_github') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-900">Thumbnail</label>
                    <input type="file" name="thumbnail" accept="image/*"
                           class="mt-2 block w-full text-sm text-gray-700 file:mr-4 file:rounded-xl file:border-0 file:bg-gray-900 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-gray-800 transition">
                    @error('thumbnail') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="is_public" value="1"
                                   class="rounded border-gray-300 text-gray-900 shadow-sm focus:ring-gray-900"
                                   @checked(old('is_public', 1))>
                            <span class="text-sm text-gray-700">Tampilkan ke publik</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('pelamar.portofolio.index') }}"
                       class="rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                        Batal
                    </a>

                    <button type="submit"
                            class="rounded-xl bg-black px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-900 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
