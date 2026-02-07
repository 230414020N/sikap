@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex items-start justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Kelola Perusahaan</h1>
                    <p class="mt-1 text-sm text-gray-600">{{ $company->nama ?? '—' }}</p>
                </div>

                <a href="{{ route('admin.companies.index') }}"
                   class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700">
                    ← Kembali
                </a>
            </div>

            @if($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    Input belum valid.
                </div>
            @endif

            <form method="POST" action="{{ route('admin.companies.update', $company->id) }}"
                  class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-900">Nama</label>
                        <input type="text" name="nama" value="{{ old('nama', $company->nama) }}"
                               class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                        @error('nama') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-900">Industri</label>
                        <input type="text" name="industri" value="{{ old('industri', $company->industri) }}"
                               class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                        @error('industri') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-900">Alamat</label>
                    <textarea name="alamat" rows="4"
                              class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">{{ old('alamat', $company->alamat) }}</textarea>
                    @error('alamat') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-900">Deskripsi</label>
                    <textarea name="deskripsi" rows="6"
                              class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">{{ old('deskripsi', $company->deskripsi) }}</textarea>
                    @error('deskripsi') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900">Verifikasi</p>
                            <label class="inline-flex items-center gap-2">
                                <input type="checkbox" name="is_verified" value="1"
                                       class="rounded border-gray-300 text-gray-900 shadow-sm focus:ring-gray-900"
                                       @checked(old('is_verified', $company->is_verified) ? true : false)>
                                <span class="text-sm text-gray-700">{{ $company->is_verified ? 'Terverifikasi' : 'Belum' }}</span>
                            </label>
                        </div>

                        <div class="mt-3">
                            <label class="text-sm font-medium text-gray-900">Catatan Verifikasi</label>
                            <input type="text" name="verification_note" value="{{ old('verification_note', $company->verification_note) }}"
                                   class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                            @error('verification_note') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="mt-3 text-xs text-gray-600">
                            @if($company->verified_at)
                                Terakhir diverifikasi: {{ $company->verified_at->format('d M Y, H:i') }}
                            @else
                                Belum pernah diverifikasi
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900">Status Perusahaan</p>
                            <label class="inline-flex items-center gap-2">
                                <input type="checkbox" name="is_active" value="1"
                                       class="rounded border-gray-300 text-gray-900 shadow-sm focus:ring-gray-900"
                                       @checked(old('is_active', $company->is_active) ? true : false)>
                                <span class="text-sm text-gray-700">{{ $company->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                            </label>
                        </div>

                        <div class="mt-3 text-xs text-gray-600">
                            Jika nonaktif, akun HRD/perusahaan tetap ada tapi operasional bisa kamu batasi di middleware/fitur lain.
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('admin.companies.index') }}"
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
