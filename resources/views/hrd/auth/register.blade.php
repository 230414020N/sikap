@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-lg mx-auto px-4 py-12">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                <h1 class="text-xl font-semibold text-gray-900">Daftar Perusahaan</h1>

                @if($errors->any())
                    <div class="mt-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        Input belum valid. Coba cek lagi.
                    </div>
                @endif

                <form method="POST" action="{{ route('hrd.company.register.store') }}" class="mt-5 space-y-5">
                    @csrf

                    <div class="rounded-2xl border border-gray-200 p-4">
                        <p class="text-sm font-semibold text-gray-900">Data Perusahaan</p>

                        <div class="mt-4 space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-900">Nama Perusahaan</label>
                                <input type="text" name="company_nama" value="{{ old('company_nama') }}"
                                       class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                                @error('company_nama')
                                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-900">Email</label>
                                    <input type="email" name="company_email" value="{{ old('company_email') }}"
                                           class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-900">No HP</label>
                                    <input type="text" name="company_no_hp" value="{{ old('company_no_hp') }}"
                                           class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                                </div>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-900">Alamat</label>
                                <input type="text" name="company_alamat" value="{{ old('company_alamat') }}"
                                       class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-gray-200 p-4">
                        <p class="text-sm font-semibold text-gray-900">Akun HRD</p>

                        <div class="mt-4 space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-900">Nama</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                       class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                                @error('name')
                                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-900">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                       class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                                @error('email')
                                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-900">Password</label>
                                    <input type="password" name="password"
                                           class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                                    @error('password')
                                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-900">Konfirmasi</label>
                                    <input type="password" name="password_confirmation"
                                           class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full rounded-xl bg-black px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-900 transition">
                        Daftar & Masuk
                    </button>
                </form>

                <div class="mt-4 text-sm text-gray-700">
                    Sudah punya akun?
                    <a href="{{ route('hrd.login') }}" class="underline underline-offset-4">Login</a>
                </div>
            </div>
        </div>
    </div>
@endsection
