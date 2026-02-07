@extends('layouts.app')

@section('title', 'Detail Showcase')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-start justify-between gap-6 mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Detail Showcase</h1>
                <p class="mt-1 text-sm text-gray-600">
                    {{ $portofolio->user?->name }} • {{ $portofolio->user?->email }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.showcase.index') }}"
                   class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                    ← Kembali
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-2xl bg-gray-900 text-white px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                Input belum valid. Coba cek lagi.
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="h-72 bg-gray-100 overflow-hidden">
                        @if($portofolio->thumbnail_path)
                            <img src="{{ asset('storage/' . $portofolio->thumbnail_path) }}" class="w-full h-full object-cover" alt="{{ $portofolio->judul }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">No Thumbnail</div>
                        @endif
                    </div>

                    <div class="p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-xl font-semibold text-gray-900 truncate">{{ $portofolio->judul }}</p>
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ $portofolio->kategori ?: 'Tanpa kategori' }}
                                    @if($portofolio->tools) • {{ $portofolio->tools }} @endif
                                </p>
                            </div>

                            <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-800 font-medium">
                                {{ strtoupper($portofolio->moderation_status ?: 'pending') }}
                            </span>
                        </div>

                        @if($portofolio->deskripsi)
                            <div class="mt-5 border-t border-gray-200 pt-5">
                                <p class="text-sm font-semibold text-gray-900">Deskripsi</p>
                                <p class="mt-2 text-sm text-gray-700 whitespace-pre-line">{{ $portofolio->deskripsi }}</p>
                            </div>
                        @endif

                        <div class="mt-5 flex flex-wrap gap-2">
                            @if($portofolio->link_demo)
                                <a href="{{ $portofolio->link_demo }}" target="_blank" rel="noopener noreferrer"
                                   class="text-xs rounded-full border border-gray-300 px-3 py-1 hover:bg-gray-50">
                                    Demo
                                </a>
                            @endif
                            @if($portofolio->link_github)
                                <a href="{{ $portofolio->link_github }}" target="_blank" rel="noopener noreferrer"
                                   class="text-xs rounded-full border border-gray-300 px-3 py-1 hover:bg-gray-50">
                                    GitHub
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                @if($portofolio->moderation_status === 'rejected' && $portofolio->moderation_reason)
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                        <p class="text-sm font-semibold text-gray-900">Alasan Ditolak</p>
                        <p class="mt-2 text-sm text-gray-700 whitespace-pre-line">{{ $portofolio->moderation_reason }}</p>
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                    <p class="text-sm font-semibold text-gray-900">Aksi Moderasi</p>

                    <div class="mt-4 space-y-3">
                        <form method="POST" action="{{ route('admin.showcase.approve', $portofolio->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="w-full rounded-xl bg-black px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-900 transition">
                                Approve
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.showcase.reject', $portofolio->id) }}" class="space-y-3">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label class="text-sm font-medium text-gray-900">Alasan Reject</label>
                                <textarea name="moderation_reason" rows="5"
                                          class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
                                          placeholder="Contoh: link demo tidak valid, konten tidak pantas, dsb.">{{ old('moderation_reason') }}</textarea>
                                @error('moderation_reason')
                                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                    class="w-full rounded-xl bg-red-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-red-700 transition">
                                Reject
                            </button>
                        </form>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                    <p class="text-sm font-semibold text-gray-900">Info Moderasi</p>

                    <div class="mt-4 space-y-3 text-sm">
                        <div>
                            <p class="text-xs text-gray-500">Status</p>
                            <p class="mt-1 font-medium text-gray-900">{{ $portofolio->moderation_status ?: 'pending' }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">Dimoderasi oleh</p>
                            <p class="mt-1 font-medium text-gray-900">{{ $portofolio->moderator?->name ?: '—' }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">Waktu moderasi</p>
                            <p class="mt-1 font-medium text-gray-900">{{ $portofolio->moderated_at?->format('d M Y, H:i') ?: '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
