@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex items-start justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Detail Portofolio</h1>
                    <p class="mt-1 text-sm text-gray-600">{{ $portofolio->judul }}</p>
                </div>

                <a href="{{ route('admin.portofolios.index') }}"
                   class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700">
                    ← Kembali
                </a>
            </div>

            @if(session('success'))
                <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
            @endif

            @if($errors->any())
                <x-alert type="error" class="mb-6">Input belum valid.</x-alert>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    @if($portofolio->thumbnail_path)
                        <img src="{{ asset('storage/' . $portofolio->thumbnail_path) }}" class="w-full h-72 object-cover">
                    @else
                        <div class="w-full h-72 bg-gray-100 flex items-center justify-center text-gray-400 text-sm">
                            No Thumbnail
                        </div>
                    @endif

                    <div class="p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">{{ $portofolio->judul }}</h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    by {{ $portofolio->user->name }} • {{ $portofolio->user->email }}
                                </p>
                            </div>

                            <div class="text-right">
                                <p class="text-sm text-gray-700">{{ $portofolio->likes_count ?? 0 }} likes</p>
                                <p class="text-xs text-gray-500">{{ $portofolio->created_at?->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                                <p class="text-xs text-gray-600">Kategori</p>
                                <p class="mt-1 text-sm font-medium text-gray-900">{{ $portofolio->kategori ?? '-' }}</p>
                            </div>

                            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                                <p class="text-xs text-gray-600">Tools</p>
                                <p class="mt-1 text-sm font-medium text-gray-900">{{ $portofolio->tools ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="mt-5 bg-gray-50 border border-gray-200 rounded-2xl p-4">
                            <p class="text-xs text-gray-600">Deskripsi</p>
                            <p class="mt-2 text-sm text-gray-800 whitespace-pre-line">{{ $portofolio->deskripsi ?? '-' }}</p>
                        </div>

                        <div class="mt-5 flex flex-wrap gap-2">
                            @if($portofolio->link_demo)
                                <a href="{{ $portofolio->link_demo }}" target="_blank"
                                   class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm hover:bg-gray-50 transition">
                                    Demo
                                </a>
                            @endif

                            @if($portofolio->link_github)
                                <a href="{{ $portofolio->link_github }}" target="_blank"
                                   class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm hover:bg-gray-50 transition">
                                    GitHub
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-gray-900">Status</p>
                        @if($portofolio->is_taken_down)
                            <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-800 border border-gray-200">Di-take down</span>
                        @else
                            <span class="text-xs px-3 py-1 rounded-full bg-gray-900 text-white">Tampil</span>
                        @endif
                    </div>

                    <div class="mt-4">
                        <p class="text-xs text-gray-600">Catatan</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $portofolio->taken_down_reason ?? '-' }}</p>
                    </div>

                    <div class="mt-4 text-xs text-gray-600">
                        @if($portofolio->taken_down_at)
                            Diturunkan: {{ $portofolio->taken_down_at->format('d M Y, H:i') }}
                        @else
                            -
                        @endif
                    </div>

                    <div class="mt-6 border-t border-gray-200 pt-6">
                        @if(!$portofolio->is_taken_down)
                            <form method="POST" action="{{ route('admin.portofolios.takedown', $portofolio->id) }}" class="space-y-3">
                                @csrf
                                <div>
                                    <label class="text-sm font-medium text-gray-900">Alasan take down</label>
                                    <input type="text" name="taken_down_reason" value="{{ old('taken_down_reason') }}"
                                           class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                                    @error('taken_down_reason') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <x-button variant="primary" type="submit" class="w-full">Take Down</x-button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.portofolios.restore', $portofolio->id) }}">
                                @csrf
                                <x-button variant="secondary" type="submit" class="w-full">Pulihkan</x-button>
                            </form>
                        @endif

                        <form action="{{ route('admin.portofolios.destroy', $portofolio->id) }}" method="POST" class="mt-3"
                              onsubmit="return confirm('Hapus portofolio ini?')">
                            @csrf
                            @method('DELETE')
                            <x-button variant="danger" type="submit" class="w-full">Hapus Permanen</x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
