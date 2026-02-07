@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white border border-gray-200 rounded-[28px] shadow-sm overflow-hidden">
            <div class="p-6 sm:p-8 border-b border-gray-200 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-gray-900">Edit HRD</h1>
                    <p class="mt-1 text-sm text-gray-600">Ubah data HRD. Password opsional kalau ingin reset.</p>
                </div>

                <a href="{{ route('perusahaan.hrd.index') }}"
                   class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-5 py-3 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                    Kembali
                </a>
            </div>

            <div class="p-6 sm:p-8">
                @if ($errors->any())
                    <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 p-5">
                        <p class="text-sm font-semibold text-red-800">Periksa input kamu:</p>
                        <ul class="mt-2 list-disc pl-5 text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('perusahaan.hrd.update', $hrd->id) }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-900">Nama HRD</label>
                            <input name="name" value="{{ old('name', $hrd->name) }}"
                                   class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition"
                                   placeholder="Nama lengkap" />
                            @error('name')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-900">Email HRD</label>
                            <input type="email" name="email" value="{{ old('email', $hrd->email) }}"
                                   class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition"
                                   placeholder="hrd@perusahaan.com" />
                            @error('email')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-900">Password Baru (opsional)</label>
                            <input type="password" name="password"
                                   class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition"
                                   placeholder="Kosongkan jika tidak diganti" />
                            @error('password')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-900">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation"
                                   class="mt-2 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition"
                                   placeholder="Ulangi password" />
                        </div>
                    </div>

                    <div class="pt-2 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-end">
                        <a href="{{ route('perusahaan.hrd.index') }}"
                           class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-5 py-3 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                            Batal
                        </a>

                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-2xl bg-gray-900 px-5 py-3 text-sm font-medium text-white hover:bg-black transition shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <form method="POST" action="{{ route('perusahaan.hrd.destroy', $hrd->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-5 py-3 text-sm font-medium text-gray-900 hover:bg-gray-50 transition"
                                onclick="return confirm('Hapus akun HRD ini?')">
                            Hapus Akun HRD
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
