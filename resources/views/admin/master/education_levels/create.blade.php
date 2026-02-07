@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex items-start justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Tambah Pendidikan</h1>
                    <p class="mt-1 text-sm text-gray-600">Buat opsi pendidikan.</p>
                </div>

                <a href="{{ route('admin.master.education-levels.index') }}"
                   class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700">
                    ← Kembali
                </a>
            </div>

            @if($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    Input belum valid.
                </div>
            @endif

            <form method="POST" action="{{ route('admin.master.education-levels.store') }}"
                  class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 space-y-5">
                @csrf

                <div>
                    <label class="text-sm font-medium text-gray-900">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                           class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
                           required>
                    @error('nama') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-900">Urutan</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                           class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
                           min="0" max="65535">
                    @error('sort_order') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-gray-900 shadow-sm focus:ring-gray-900"
                               @checked(old('is_active', 1))>
                        <span class="text-sm text-gray-700">Aktif</span>
                    </label>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('admin.master.education-levels.index') }}"
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
