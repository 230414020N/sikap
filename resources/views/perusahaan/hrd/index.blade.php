@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white border border-gray-200 rounded-[28px] shadow-sm overflow-hidden">
            <div class="p-6 sm:p-8 border-b border-gray-200 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-gray-900">HRD</h1>
                    <p class="mt-1 text-sm text-gray-600">Kelola akun HRD untuk membantu rekrutmen.</p>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('perusahaan.dashboard') }}"
                       class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-5 py-3 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                        Dashboard
                    </a>
                    <a href="{{ route('perusahaan.hrd.create') }}"
                       class="inline-flex items-center justify-center rounded-2xl bg-gray-900 px-5 py-3 text-sm font-medium text-white hover:bg-black transition shadow-sm">
                        + Tambah HRD
                    </a>
                </div>
            </div>

            <div class="p-6 sm:p-8">
                @if(session('success'))
                    <div class="mb-6 rounded-3xl border border-green-200 bg-green-50 p-5 text-sm text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <p class="text-sm font-semibold text-gray-900">Daftar HRD</p>
                        <p class="text-xs text-gray-500">Total: {{ $hrdUsers->total() }}</p>
                    </div>

                    <div class="divide-y divide-gray-200">
                        @forelse($hrdUsers as $hrd)
                            @php
                                $link = $activationLinks[$hrd->id] ?? null;
                                $expiresAt = $activationExpiresAt[$hrd->id] ?? null;
                                $isActivated = !empty($hrd->email_verified_at);
                                $inputId = 'actlink-'.$hrd->id;
                            @endphp

                            <div class="px-6 py-5 flex flex-col gap-4">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $hrd->name ?? 'HRD' }}</p>
                                        <p class="mt-1 text-sm text-gray-600 truncate">{{ $hrd->email ?? '—' }}</p>
                                        <div class="mt-2 flex flex-wrap items-center gap-2 text-xs">
                                            <span class="px-3 py-1 rounded-full border border-gray-200 bg-gray-50 text-gray-800">
                                                {{ $isActivated ? 'Aktif' : 'Belum Aktivasi' }}
                                            </span>
                                            @if(!$isActivated && $expiresAt)
                                                <span class="text-gray-500">
                                                    Exp: {{ $expiresAt->format('d M Y, H:i') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('perusahaan.hrd.edit', $hrd->id) }}"
                                           class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('perusahaan.hrd.destroy', $hrd->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center justify-center rounded-2xl bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-black transition"
                                                    onclick="return confirm('Hapus akun HRD ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                @if(!$isActivated)
                                    <div class="rounded-3xl border border-gray-200 bg-gray-50 p-5">
                                        @if($link)
                                            <p class="text-sm font-semibold text-gray-900">Link aktivasi</p>
                                            <p class="mt-1 text-sm text-gray-600">Copy dan kirim ke HRD.</p>

                                            <div class="mt-4 flex flex-col sm:flex-row gap-2">
                                                <input id="{{ $inputId }}" readonly value="{{ $link }}"
                                                       class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition" />
                                                <button type="button"
                                                        onclick="navigator.clipboard.writeText(document.getElementById('{{ $inputId }}').value)"
                                                        class="inline-flex items-center justify-center rounded-2xl bg-gray-900 px-5 py-3 text-sm font-medium text-white hover:bg-black transition shadow-sm">
                                                    Copy
                                                </button>
                                            </div>

                                            <div class="mt-3 flex flex-wrap items-center gap-4">
                                                <a class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700"
                                                   href="{{ $link }}" target="_blank" rel="noopener">
                                                    Buka link
                                                </a>

                                                <form method="POST" action="{{ route('perusahaan.hrd.activation-link', $hrd->id) }}">
                                                    @csrf
                                                    <button type="submit"
                                                            class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700">
                                                        Generate ulang
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <p class="text-sm font-semibold text-gray-900">Link aktivasi belum tersedia / expired</p>
                                            <p class="mt-1 text-sm text-gray-600">Generate ulang untuk membuat link baru.</p>

                                            <form method="POST" action="{{ route('perusahaan.hrd.activation-link', $hrd->id) }}" class="mt-4">
                                                @csrf
                                                <button type="submit"
                                                        class="inline-flex items-center justify-center rounded-2xl bg-gray-900 px-5 py-3 text-sm font-medium text-white hover:bg-black transition shadow-sm">
                                                    Generate Link Aktivasi
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="px-6 py-12 text-center">
                                <p class="text-sm font-semibold text-gray-900">Belum ada HRD</p>
                                <p class="mt-1 text-sm text-gray-600">Tambah HRD pertama untuk bantu kelola rekrutmen.</p>
                                <a href="{{ route('perusahaan.hrd.create') }}"
                                   class="mt-5 inline-flex items-center justify-center rounded-2xl bg-gray-900 px-5 py-3 text-sm font-medium text-white hover:bg-black transition shadow-sm">
                                    + Tambah HRD
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="mt-6">
                    {{ $hrdUsers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
