@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
  <h1 class="text-2xl font-semibold mb-6">Buat Lowongan</h1>

  @if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900">
      <ul class="list-disc pl-5 space-y-1">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('perusahaan.jobs.store') }}" class="space-y-6">
    @csrf

    <div class="rounded-2xl border border-gray-200 bg-white p-6 space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
        <input type="text" name="judul" value="{{ old('judul') }}"
               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" required>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
        <textarea name="deskripsi" rows="5"
                  class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"
                  required>{{ old('deskripsi') }}</textarea>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Kriteria: Status Pekerjaan</label>
        <select name="employment_status_id" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
          <option value="">- Tidak ditentukan -</option>
          @foreach($employmentStatuses as $s)
            <option value="{{ $s->id }}" {{ old('employment_status_id') == $s->id ? 'selected' : '' }}>
              {{ $s->name }}
            </option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="flex justify-end">
      <button type="submit" class="rounded-xl bg-black px-5 py-3 text-sm font-medium text-white hover:opacity-90">
        Simpan
      </button>
    </div>
  </form>
</div>
@endsection
