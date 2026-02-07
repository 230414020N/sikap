@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 py-10">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Profil Perusahaan</h1>
                        <p class="mt-1 text-sm text-gray-600">Lengkapi profil untuk mulai rekrutmen.</p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="mt-4 rounded-2xl bg-gray-900 text-white px-4 py-3 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mt-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        Input belum valid. Coba cek lagi.
                    </div>
                @endif

                <form method="POST" action="{{ route('hrd.company.profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="text-sm font-medium text-gray-900">Nama Perusahaan</label>
                        <input type="text" name="nama" value="{{ old('nama', $company->nama) }}"
                               class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="text-sm font-medium text-gray-900">Email</label>
                            <input type="email" name="email" value="{{ old('email', $company->email) }}"
                                   class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-900">No HP</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $company->no_hp) }}"
                                   class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="text-sm font-medium text-gray-900">Website</label>
                            <input type="text" name="website" value="{{ old('website', $company->website) }}"
                                   class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-900">Industri</label>
                            <input type="text" name="industri" value="{{ old('industri', $company->industri) }}"
                                   class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-900">Ukuran</label>
                        <input type="text" name="ukuran" value="{{ old('ukuran', $company->ukuran) }}"
                               class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-900">Alamat</label>
                        <input type="text" name="alamat" value="{{ old('alamat', $company->alamat) }}"
                               class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-900">Deskripsi</label>
                        <textarea name="deskripsi" rows="5"
                                  class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">{{ old('deskripsi', $company->deskripsi) }}</textarea>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-900">Logo</label>
                        <input type="file" name="logo"
                               class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                        @if($company->logo_path)
                            <div class="mt-3">
                                <img src="{{ asset('storage/' . $company->logo_path) }}" class="h-14 rounded-xl border border-gray-200" alt="Logo">
                            </div>
                        @endif
                    </div>

                    <button type="submit"
                            class="w-full rounded-xl bg-black px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-900 transition">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
