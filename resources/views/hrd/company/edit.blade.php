@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="mb-8">
                <h1 class="text-2xl font-semibold text-gray-900">Profil Perusahaan</h1>
                <p class="mt-1 text-sm text-gray-600">Kelola informasi perusahaan yang tampil di lowongan.</p>
            </div>

            @if(session('success'))
                <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
            @endif

            <form method="POST" action="{{ route('hrd.company.update') }}" enctype="multipart/form-data"
                  class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 space-y-6">
                @csrf

                <x-input name="nama" label="Nama Perusahaan" :value="$company->nama" />
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <x-input name="industri" label="Industri" :value="$company->industri" />
                    <x-input name="website" label="Website" :value="$company->website" />
                </div>
                <x-input name="lokasi" label="Lokasi" :value="$company->lokasi" />
                <x-textarea name="deskripsi" label="Deskripsi" rows="5" :value="$company->deskripsi" />

                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-900">Logo (opsional)</label>
                    <input type="file" name="logo"
                        class="block w-full text-sm text-gray-700 file:mr-4 file:rounded-xl file:border-0
                        file:bg-gray-900 file:text-white file:px-4 file:py-2 file:text-sm hover:file:bg-black transition" />

                    @if($company->logo_path)
                        <div class="mt-3">
                            <p class="text-xs text-gray-600 mb-2">Logo saat ini:</p>
                            <img src="{{ asset('storage/' . $company->logo_path) }}" class="w-32 rounded-xl border border-gray-200">
                        </div>
                    @endif
                </div>

                <div class="flex justify-end">
                    <x-button>Simpan</x-button>
                </div>
            </form>
        </div>
    </div>
@endsection
