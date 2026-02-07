@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
  <div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-900">Profil Pelamar</h1>
    <p class="mt-1 text-sm text-gray-600">Lengkapi informasi agar proses lamaran kamu terlihat lebih profesional dan meyakinkan.</p>
  </div>

  @if(session('success'))
    <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">
      {{ session('success') }}
    </div>
  @endif

  @if(session('warning'))
    <div class="mb-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
      {{ session('warning') }}
    </div>
  @endif

  @if ($errors->any())
    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900">
      <div class="font-medium mb-2">Ada beberapa bagian yang perlu diperbaiki:</div>
      <ul class="list-disc pl-5 space-y-1">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @php
    $fotoUrl = $profile->foto_path ? asset('storage/'.$profile->foto_path) : null;
    $tanggalLahir = old('tanggal_lahir');
    if ($tanggalLahir === null) {
      $tanggalLahir = $profile->tanggal_lahir
        ? (is_string($profile->tanggal_lahir) ? $profile->tanggal_lahir : $profile->tanggal_lahir->format('Y-m-d'))
        : '';
    }
    $jk = old('jenis_kelamin', $profile->jenis_kelamin);
  @endphp

  <form method="POST" action="{{ route('pelamar.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="rounded-2xl border border-gray-200 bg-white p-6">
      <div class="flex items-start justify-between gap-4">
        <div>
          <h2 class="text-lg font-semibold text-gray-900">Foto & Ringkasan</h2>
          <p class="mt-1 text-sm text-gray-600">Tambahkan foto dan ringkasan singkat agar profil lebih kredibel.</p>
        </div>
      </div>

      <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-1">
          <div class="flex items-center gap-4">
            <div class="w-24 h-24 rounded-2xl overflow-hidden border border-gray-200 bg-gray-50 flex items-center justify-center">
              @if($fotoUrl)
                <img id="fotoPreview" src="{{ $fotoUrl }}" alt="Foto profil" class="w-full h-full object-cover" />
              @else
                <div class="text-xs text-gray-500 px-3 text-center">Belum ada foto</div>
                <img id="fotoPreview" src="" alt="Preview foto profil" class="hidden w-full h-full object-cover" />
              @endif
            </div>

            <div class="flex-1">
              <label class="block text-sm font-medium text-gray-900">Foto profil</label>
              <input
                type="file"
                name="foto"
                accept="image/png,image/jpeg,image/webp"
                class="mt-2 block w-full text-sm text-gray-700 file:mr-3 file:rounded-xl file:border file:border-gray-200 file:bg-white file:px-3 file:py-2 file:text-sm file:font-medium hover:file:bg-gray-50"
                onchange="previewFoto(event)"
              />
              <p class="mt-1 text-xs text-gray-500">Format JPG/PNG/WEBP, maksimal 2 MB.</p>
              @error('foto') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
          </div>
        </div>

        <div class="md:col-span-2 space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-900">Headline</label>
            <input
              type="text"
              name="headline"
              value="{{ old('headline', $profile->headline) }}"
              placeholder="Contoh: Backend Developer | Laravel | 2+ tahun pengalaman"
              class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
            />
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-900">Nama lengkap</label>
              <input
                type="text"
                name="nama_lengkap"
                value="{{ old('nama_lengkap', $profile->nama_lengkap) }}"
                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-900">Nomor HP</label>
              <input
                type="text"
                name="no_hp"
                value="{{ old('no_hp', $profile->no_hp) }}"
                placeholder="08xxxxxxxxxx"
                class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
              />
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-900">Bio singkat</label>
            <textarea
              name="bio"
              rows="3"
              class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
              placeholder="Jelaskan ringkas tentang keahlian, minat, dan pencapaian kamu."
            >{{ old('bio', $profile->bio) }}</textarea>
          </div>
        </div>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6">
      <h2 class="text-lg font-semibold text-gray-900">Data Personal</h2>
      <p class="mt-1 text-sm text-gray-600">Informasi dasar untuk kebutuhan administrasi rekrutmen.</p>

      <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-900">Tanggal lahir</label>
          <input
            type="date"
            name="tanggal_lahir"
            value="{{ $tanggalLahir }}"
            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-900">Jenis kelamin</label>
          <select name="jenis_kelamin" class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
            <option value="">Pilih</option>
            <option value="pria" {{ $jk === 'pria' ? 'selected' : '' }}>Pria</option>
            <option value="wanita" {{ $jk === 'wanita' ? 'selected' : '' }}>Wanita</option>
            <option value="lainnya" {{ $jk === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-900">Domisili (Kota)</label>
          <input
            type="text"
            name="domisili"
            value="{{ old('domisili', $profile->domisili) }}"
            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-900">Kode pos</label>
          <input
            type="text"
            name="kode_pos"
            value="{{ old('kode_pos', $profile->kode_pos) }}"
            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
          />
        </div>

        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-900">Alamat</label>
          <input
            type="text"
            name="alamat"
            value="{{ old('alamat', $profile->alamat) }}"
            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
          />
        </div>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6">
      <h2 class="text-lg font-semibold text-gray-900">Pendidikan</h2>
      <p class="mt-1 text-sm text-gray-600">Riwayat pendidikan terbaru untuk melengkapi profil.</p>

      <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-900">Pendidikan terakhir</label>
          <input
            type="text"
            name="pendidikan_terakhir"
            value="{{ old('pendidikan_terakhir', $profile->pendidikan_terakhir) }}"
            placeholder="Contoh: S1 / D3 / SMA"
            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-900">Jurusan</label>
          <input
            type="text"
            name="jurusan"
            value="{{ old('jurusan', $profile->jurusan) }}"
            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-900">Institusi</label>
          <input
            type="text"
            name="institusi"
            value="{{ old('institusi', $profile->institusi) }}"
            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-900">Tahun lulus</label>
          <input
            type="number"
            name="tahun_lulus"
            value="{{ old('tahun_lulus', $profile->tahun_lulus) }}"
            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
          />
        </div>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6">
      <h2 class="text-lg font-semibold text-gray-900">Link Profesional</h2>
      <p class="mt-1 text-sm text-gray-600">Cantumkan tautan yang mendukung portofolio dan reputasi profesional.</p>

      <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-900">LinkedIn</label>
          <input
            type="url"
            name="linkedin_url"
            value="{{ old('linkedin_url', $profile->linkedin_url) }}"
            placeholder="https://linkedin.com/in/..."
            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-900">GitHub</label>
          <input
            type="url"
            name="github_url"
            value="{{ old('github_url', $profile->github_url) }}"
            placeholder="https://github.com/..."
            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-900">Website/Portfolio</label>
          <input
            type="url"
            name="portfolio_url"
            value="{{ old('portfolio_url', $profile->portfolio_url) }}"
            placeholder="https://..."
            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
          />
        </div>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6">
      <h2 class="text-lg font-semibold text-gray-900">Keterampilan & Bahasa</h2>
      <p class="mt-1 text-sm text-gray-600">Ketik lalu tekan Enter atau koma untuk menambahkan.</p>

      <div class="mt-5 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-900 mb-2">Keterampilan</label>

          <div class="flex gap-2">
            <input
              id="skillInput"
              type="text"
              class="flex-1 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
              placeholder="Contoh: Laravel, MySQL, Figma"
            />
            <button
              type="button"
              class="rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium hover:bg-gray-50 transition"
              onclick="addChip('skill')"
            >Tambah</button>
          </div>

          <div id="skillChips" class="mt-3 flex flex-wrap gap-2"></div>
          <div id="skillHidden"></div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-900 mb-2">Bahasa</label>

          <div class="flex gap-2">
            <input
              id="langInput"
              type="text"
              class="flex-1 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
              placeholder="Contoh: Indonesia, English"
            />
            <button
              type="button"
              class="rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium hover:bg-gray-50 transition"
              onclick="addChip('lang')"
            >Tambah</button>
          </div>

          <div id="langChips" class="mt-3 flex flex-wrap gap-2"></div>
          <div id="langHidden"></div>
        </div>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6">
      <h2 class="text-lg font-semibold text-gray-900">Preferensi Kerja</h2>
      <p class="mt-1 text-sm text-gray-600">Opsional, namun membantu HRD memahami ekspektasi kamu.</p>

      <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-900">Posisi yang diinginkan</label>
          <input
            type="text"
            name="posisi_diinginkan"
            value="{{ old('posisi_diinginkan', $profile->posisi_diinginkan) }}"
            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-900">Gaji harapan (Rp)</label>
          <input
            type="number"
            name="gaji_harapan"
            value="{{ old('gaji_harapan', $profile->gaji_harapan) }}"
            min="0"
            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-900">Ketersediaan mulai</label>
          <input
            type="date"
            name="ketersediaan_mulai"
            value="{{ old('ketersediaan_mulai', $profile->ketersediaan_mulai ? (is_string($profile->ketersediaan_mulai) ? $profile->ketersediaan_mulai : $profile->ketersediaan_mulai->format('Y-m-d')) : '') }}"
            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
          />
        </div>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6">
      <h2 class="text-lg font-semibold text-gray-900">Dokumen</h2>
      <p class="mt-1 text-sm text-gray-600">Unggah dokumen pendukung agar proses seleksi lebih cepat.</p>

      <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-900">CV</label>
          <input type="file" name="cv" class="mt-2 block w-full text-sm text-gray-700 file:mr-3 file:rounded-xl file:border file:border-gray-200 file:bg-white file:px-3 file:py-2 file:text-sm file:font-medium hover:file:bg-gray-50" />
          @if($profile->cv_path)
            <p class="text-xs text-gray-600 mt-2">
              CV sudah tersimpan:
              <a class="underline underline-offset-4" href="{{ asset('storage/'.$profile->cv_path) }}" target="_blank" rel="noreferrer">Lihat</a>
            </p>
          @endif
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-900">Surat Lamaran</label>
          <input type="file" name="surat_lamaran" class="mt-2 block w-full text-sm text-gray-700 file:mr-3 file:rounded-xl file:border file:border-gray-200 file:bg-white file:px-3 file:py-2 file:text-sm file:font-medium hover:file:bg-gray-50" />
          @if($profile->surat_lamaran_path)
            <p class="text-xs text-gray-600 mt-2">
              Surat lamaran sudah tersimpan:
              <a class="underline underline-offset-4" href="{{ asset('storage/'.$profile->surat_lamaran_path) }}" target="_blank" rel="noreferrer">Lihat</a>
            </p>
          @endif
        </div>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6">
      <h2 class="text-lg font-semibold text-gray-900">Kontak Darurat</h2>
      <p class="mt-1 text-sm text-gray-600">Opsional, untuk kebutuhan administrasi tertentu.</p>

      <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-900">Nama</label>
          <input
            type="text"
            name="kontak_darurat_nama"
            value="{{ old('kontak_darurat_nama', $profile->kontak_darurat_nama) }}"
            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-900">Nomor HP</label>
          <input
            type="text"
            name="kontak_darurat_hp"
            value="{{ old('kontak_darurat_hp', $profile->kontak_darurat_hp) }}"
            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
          />
        </div>
      </div>
    </div>

    <div class="flex items-center justify-end gap-3">
      <button
        type="submit"
        class="rounded-xl bg-black px-5 py-3 text-sm font-medium text-white hover:bg-gray-900 transition"
      >
        Simpan Perubahan
      </button>
    </div>
  </form>
</div>

<script>
  function previewFoto(event) {
    const file = event.target.files && event.target.files[0];
    if (!file) return;
    const url = URL.createObjectURL(file);
    const img = document.getElementById('fotoPreview');
    img.src = url;
    img.classList.remove('hidden');
  }

  const state = {
    skill: new Set(),
    lang: new Set(),
  };

  const initialSkills = @json(old('keterampilan', $profile->keterampilan ?? []));
  const initialLangs  = @json(old('bahasa', $profile->bahasa ?? []));

  (Array.isArray(initialSkills) ? initialSkills : []).forEach(v => state.skill.add(String(v)));
  (Array.isArray(initialLangs) ? initialLangs : []).forEach(v => state.lang.add(String(v)));

  function normalizeToken(str) {
    return String(str || '').trim().replace(/\s+/g, ' ');
  }

  function addFromInput(type, raw) {
    const parts = String(raw).split(',').map(normalizeToken).filter(Boolean);
    if (!parts.length) return;
    parts.forEach(p => state[type].add(p));
    render(type);
  }

  function addChip(type) {
    const inputId = type === 'skill' ? 'skillInput' : 'langInput';
    const el = document.getElementById(inputId);
    addFromInput(type, el.value);
    el.value = '';
    el.focus();
  }

  function removeChip(type, value) {
    state[type].delete(value);
    render(type);
  }

  function render(type) {
    const chipsId = type === 'skill' ? 'skillChips' : 'langChips';
    const hiddenId = type === 'skill' ? 'skillHidden' : 'langHidden';
    const inputName = type === 'skill' ? 'keterampilan[]' : 'bahasa[]';

    const chipsEl = document.getElementById(chipsId);
    const hiddenEl = document.getElementById(hiddenId);

    chipsEl.innerHTML = '';
    hiddenEl.innerHTML = '';

    const values = Array.from(state[type]).sort((a,b) => a.localeCompare(b));

    values.forEach((val) => {
      const chip = document.createElement('button');
      chip.type = 'button';
      chip.className = 'inline-flex items-center gap-2 rounded-full border border-gray-300 bg-white px-3 py-1.5 text-sm hover:bg-gray-50 transition';
      chip.innerHTML = `<span>${escapeHtml(val)}</span><span aria-hidden="true" class="text-gray-500">×</span>`;
      chip.addEventListener('click', () => removeChip(type, val));
      chipsEl.appendChild(chip);

      const hidden = document.createElement('input');
      hidden.type = 'hidden';
      hidden.name = inputName;
      hidden.value = val;
      hiddenEl.appendChild(hidden);
    });
  }

  function escapeHtml(str) {
    return String(str)
      .replaceAll('&', '&amp;')
      .replaceAll('<', '&lt;')
      .replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;')
      .replaceAll("'", '&#039;');
  }

  function bindChipInput(type, inputId) {
    const el = document.getElementById(inputId);

    el.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        addChip(type);
      }
    });

    el.addEventListener('input', (e) => {
      if (e.target.value.includes(',')) {
        addChip(type);
      }
    });
  }

  bindChipInput('skill', 'skillInput');
  bindChipInput('lang', 'langInput');

  render('skill');
  render('lang');
</script>
@endsection
