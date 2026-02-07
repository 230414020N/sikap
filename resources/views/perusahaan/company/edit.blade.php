@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
  <div class="max-w-5xl mx-auto px-4 py-8">
    <div class="flex items-start justify-between gap-4">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900">Profil Perusahaan</h1>
        <p class="mt-1 text-sm text-gray-600">Lengkapi profil untuk meningkatkan kepercayaan pelamar.</p>
      </div>

      <a href="{{ route('perusahaan.dashboard') }}"
         class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
        Kembali ke Dashboard
      </a>
    </div>

    @if(session('success'))
      <div class="mt-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div class="mt-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900">
        <div class="font-medium mb-2">Ada input yang perlu diperbaiki:</div>
        <ul class="list-disc pl-5 space-y-1">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @php
      $logoUrl = !empty($company->logo) ? asset('storage/' . $company->logo) : null;
      $bannerUrl = !empty($company->banner) ? asset('storage/' . $company->banner) : null;

      $logoFallback = "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='64' height='64'><rect width='100%25' height='100%25' fill='%23F3F4F6'/><text x='50%25' y='52%25' dominant-baseline='middle' text-anchor='middle' fill='%239CA3AF' font-size='10'>Logo</text></svg>";
      $bannerFallback = "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='800' height='260'><rect width='100%25' height='100%25' fill='%23F3F4F6'/><text x='50%25' y='52%25' dominant-baseline='middle' text-anchor='middle' fill='%239CA3AF' font-size='14'>Banner</text></svg>";
    @endphp

    <form class="mt-6 space-y-8"
          method="PUT"
          action="{{ route('perusahaan.company.update') }}"
          enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="rounded-2xl border border-gray-200 bg-white p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-1">Branding</h2>
        <p class="text-sm text-gray-600 mb-5">Tambahkan logo dan banner agar profil perusahaan terlihat profesional.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="md:col-span-1">
            <label class="block text-sm font-medium text-gray-900 mb-2">Logo</label>

            <div class="flex items-center gap-4">
              <div class="h-16 w-16 rounded-xl overflow-hidden border border-gray-200 bg-gray-50 flex items-center justify-center">
                <img id="logoPreview"
                     src="{{ $logoUrl ?: $logoFallback }}"
                     alt="Logo perusahaan"
                     class="h-full w-full object-cover" />
              </div>

              <div class="flex-1">
                <input type="file"
                       name="logo"
                       accept="image/png,image/jpeg,image/webp"
                       class="block w-full text-sm text-gray-700"
                       onchange="previewImg(event,'logoPreview')" />
                <p class="mt-1 text-xs text-gray-500">Format: JPG/PNG/WEBP. Maks 2MB.</p>
                @error('logo') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
              </div>
            </div>
          </div>

          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-900 mb-2">Banner</label>

            <div class="rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
              <img id="bannerPreview"
                   src="{{ $bannerUrl ?: $bannerFallback }}"
                   alt="Banner perusahaan"
                   class="w-full h-40 object-cover" />
            </div>

            <input type="file"
                   name="banner"
                   accept="image/png,image/jpeg,image/webp"
                   class="mt-3 block w-full text-sm text-gray-700"
                   onchange="previewImg(event,'bannerPreview')" />
            <p class="mt-1 text-xs text-gray-500">Format: JPG/PNG/WEBP. Maks 4MB.</p>
            @error('banner') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>
        </div>
      </div>

      <div class="rounded-2xl border border-gray-200 bg-white p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-1">Informasi Perusahaan</h2>
        <p class="text-sm text-gray-600 mb-5">Pastikan data sesuai agar kandidat lebih percaya.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-900 mb-1">Nama perusahaan</label>
            <input type="text"
                   name="nama_perusahaan"
                   value="{{ old('nama_perusahaan', $company->nama_perusahaan) }}"
                   class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
                   required />
            @error('nama_perusahaan') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-900 mb-1">Bidang usaha</label>
            <input type="text"
                   name="bidang_usaha"
                   value="{{ old('bidang_usaha', $company->bidang_usaha) }}"
                   class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition" />
            @error('bidang_usaha') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-900 mb-1">Website</label>
            <input type="url"
                   name="website"
                   value="{{ old('website', $company->website) }}"
                   placeholder="https://perusahaanmu.com"
                   class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition" />
            @error('website') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-900 mb-1">Lokasi (Kota)</label>
            <input type="text"
                   name="lokasi"
                   value="{{ old('lokasi', $company->lokasi) }}"
                   class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition" />
            @error('lokasi') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>

          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-900 mb-1">Deskripsi</label>
            <textarea name="deskripsi"
                      rows="5"
                      class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
                      placeholder="Ceritakan tentang perusahaan, budaya kerja, benefit, dan hal menarik lainnya...">{{ old('deskripsi', $company->deskripsi) }}</textarea>
            @error('deskripsi') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>
        </div>
      </div>

      <div class="flex justify-end">
        <button type="submit"
                class="rounded-xl bg-black px-5 py-3 text-sm font-medium text-white hover:bg-gray-900 transition">
          Simpan Profil
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function previewImg(event, id) {
    const file = event.target.files && event.target.files[0]
    if (!file) return
    document.getElementById(id).src = URL.createObjectURL(file)
  }
</script>
@endsection
