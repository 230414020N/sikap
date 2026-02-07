@extends('layouts.guest')

@section('content')
    <div class="w-full max-w-xl">
        <div class="bg-white border border-gray-200 rounded-3xl shadow-sm p-6 sm:p-7">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-[11px] font-semibold tracking-widest text-gray-500">PERUSAHAAN</p>
                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-gray-900">Registrasi Perusahaan</h1>
                    <p class="mt-1 text-sm text-gray-600">Buat akun perusahaan untuk mengelola akun HRD.</p>
                </div>
                <div class="h-11 w-11 rounded-3xl bg-gray-900 text-white flex items-center justify-center text-sm font-semibold shadow-sm">
                    🏢
                </div>
            </div>

            @if($errors->any())
                <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    Ada beberapa input yang belum valid. Coba cek lagi ya.
                </div>
            @endif

            <form method="POST" action="{{ route('perusahaan.register.store') }}" class="mt-7 space-y-6">
                @csrf

                <div class="rounded-3xl border border-gray-200 bg-gray-50 p-5 space-y-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Data Perusahaan</p>
                        <p class="mt-1 text-xs text-gray-600">Informasi ini akan tampil di lowongan (bisa diubah nanti).</p>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-3xl p-5 space-y-4">
                        <div>
                            <x-input-label for="company_nama" value="Nama Perusahaan" class="text-sm font-medium text-gray-900" />
                            <x-text-input
                                id="company_nama"
                                type="text"
                                name="company_nama"
                                value="{{ old('company_nama') }}"
                                required
                                class="mt-2 block w-full rounded-2xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-300 focus:ring-2 focus:ring-gray-900/10"
                                placeholder="Contoh: PT SIKAP Teknologi"
                            />
                            <x-input-error :messages="$errors->get('company_nama')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="company_industri" value="Industri (opsional)" class="text-sm font-medium text-gray-900" />
                                <x-text-input
                                    id="company_industri"
                                    type="text"
                                    name="company_industri"
                                    value="{{ old('company_industri') }}"
                                    class="mt-2 block w-full rounded-2xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-300 focus:ring-2 focus:ring-gray-900/10"
                                    placeholder="Contoh: Software / Fintech"
                                />
                                <x-input-error :messages="$errors->get('company_industri')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="company_lokasi" value="Lokasi (opsional)" class="text-sm font-medium text-gray-900" />
                                <x-text-input
                                    id="company_lokasi"
                                    type="text"
                                    name="company_lokasi"
                                    value="{{ old('company_lokasi') }}"
                                    class="mt-2 block w-full rounded-2xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-300 focus:ring-2 focus:ring-gray-900/10"
                                    placeholder="Contoh: Jakarta"
                                />
                                <x-input-error :messages="$errors->get('company_lokasi')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="company_website" value="Website (opsional)" class="text-sm font-medium text-gray-900" />
                            <x-text-input
                                id="company_website"
                                type="text"
                                name="company_website"
                                value="{{ old('company_website') }}"
                                class="mt-2 block w-full rounded-2xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-300 focus:ring-2 focus:ring-gray-900/10"
                                placeholder="https://perusahaan.com"
                            />
                            <x-input-error :messages="$errors->get('company_website')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="company_deskripsi" value="Deskripsi (opsional)" class="text-sm font-medium text-gray-900" />
                            <x-textarea
                                id="company_deskripsi"
                                name="company_deskripsi"
                                rows="4"
                                class="mt-2 block w-full rounded-2xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-300 focus:ring-2 focus:ring-gray-900/10"
                                placeholder="Ceritakan singkat tentang perusahaan (opsional)."
                            >{{ old('company_deskripsi') }}</x-textarea>
                            <x-input-error :messages="$errors->get('company_deskripsi')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-gray-200 bg-gray-50 p-5 space-y-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Akun Admin Perusahaan</p>
                        <p class="mt-1 text-xs text-gray-600">Akun ini untuk mengelola perusahaan dan membuat akun HRD.</p>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-3xl p-5 space-y-4">
                        <div>
                            <x-input-label for="name" value="Nama" class="text-sm font-medium text-gray-900" />
                            <x-text-input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                class="mt-2 block w-full rounded-2xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-300 focus:ring-2 focus:ring-gray-900/10"
                                placeholder="Nama admin"
                            />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" value="Email" class="text-sm font-medium text-gray-900" />
                            <x-text-input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                class="mt-2 block w-full rounded-2xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-300 focus:ring-2 focus:ring-gray-900/10"
                                placeholder="nama@perusahaan.com"
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="password" value="Password" class="text-sm font-medium text-gray-900" />
                                <x-text-input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    class="mt-2 block w-full rounded-2xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-300 focus:ring-2 focus:ring-gray-900/10"
                                    placeholder="••••••••"
                                />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="password_confirmation" value="Konfirmasi Password" class="text-sm font-medium text-gray-900" />
                                <x-text-input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    class="mt-2 block w-full rounded-2xl border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-300 focus:ring-2 focus:ring-gray-900/10"
                                    placeholder="••••••••"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-1">
                    <a href="{{ route('login') }}" class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700">
                        Sudah punya akun? Login
                    </a>

                    <x-primary-button class="justify-center rounded-2xl px-6 py-3">
                        Daftar Perusahaan
                    </x-primary-button>
                </div>
            </form>
        </div>

        <p class="mt-4 text-center text-xs text-gray-500">
            Dengan mendaftar, kamu menyetujui kebijakan dan ketentuan penggunaan.
        </p>
    </div>
@endsection
