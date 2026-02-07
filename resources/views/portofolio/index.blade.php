@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between mb-8">
                <div class="min-w-0">
                    <h1 class="text-2xl font-semibold text-gray-900">Portofolio</h1>
                    <p class="mt-1 text-sm text-gray-600">Kelola proyek yang ingin kamu tampilkan.</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('pelamar.profile.edit') }}"
                       class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700">
                        ← Kembali ke Profil
                    </a>

                    <a href="{{ route('pelamar.portofolio.create') }}"
                       class="inline-flex items-center rounded-xl bg-black px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-900 transition">
                        + Tambah
                    </a>
                </div>
            </div>

            @if(session('success'))
                <x-alert type="success" class="mb-6">
                    {{ session('success') }}
                </x-alert>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse($portofolios as $p)
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                        <div class="relative">
                            @if($p->thumbnail_path)
                                <img src="{{ asset('storage/' . $p->thumbnail_path) }}"
                                     class="w-full h-44 object-cover">
                            @else
                                <div class="w-full h-44 bg-gray-100 flex items-center justify-center text-gray-400 text-sm">
                                    No Thumbnail
                                </div>
                            @endif

                            <div class="absolute top-3 left-3 flex flex-wrap gap-2">
                                @if(($p->is_public ?? true) === true)
                                    <span class="text-[11px] px-3 py-1 rounded-full bg-gray-900 text-white">
                                        Publik
                                    </span>
                                @else
                                    <span class="text-[11px] px-3 py-1 rounded-full bg-white/90 text-gray-900 border border-gray-200">
                                        Privat
                                    </span>
                                @endif

                                @if(($p->is_taken_down ?? false) === true)
                                    <span class="text-[11px] px-3 py-1 rounded-full bg-gray-100 text-gray-900 border border-gray-200">
                                        Diturunkan
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="p-5">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h2 class="text-base font-semibold text-gray-900 truncate">
                                        {{ $p->judul }}
                                    </h2>
                                    <p class="mt-1 text-xs text-gray-600 truncate">
                                        {{ $p->kategori ?? 'Tanpa kategori' }}
                                        @if($p->tools) • {{ $p->tools }} @endif
                                    </p>
                                </div>

                                <p class="shrink-0 text-xs text-gray-500">
                                    {{ $p->created_at?->format('d M Y') }}
                                </p>
                            </div>

                            @if($p->deskripsi)
                                <p class="mt-3 text-sm text-gray-700">
                                    {{ \Illuminate\Support\Str::limit($p->deskripsi, 110) }}
                                </p>
                            @endif

                            <div class="mt-4 flex flex-wrap gap-2">
                                @if($p->link_demo)
                                    <a href="{{ $p->link_demo }}" target="_blank"
                                       class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm hover:bg-gray-50 transition">
                                        Demo
                                    </a>
                                @endif

                                @if($p->link_github)
                                    <a href="{{ $p->link_github }}" target="_blank"
                                       class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm hover:bg-gray-50 transition">
                                        GitHub
                                    </a>
                                @endif
                            </div>

                            <div class="mt-5 flex items-center gap-2">
                                <a href="{{ route('pelamar.portofolio.edit', $p->id) }}"
                                   class="inline-flex items-center justify-center rounded-xl px-4 py-2 text-sm font-medium
                                   bg-white border border-gray-300 text-gray-900 hover:bg-gray-50 transition">
                                    Edit
                                </a>

                                <form action="{{ route('pelamar.portofolio.destroy', $p->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus portofolio ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-button variant="danger" type="submit" class="px-4 py-2">
                                        Hapus
                                    </x-button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-10 text-center text-gray-600 col-span-full">
                        <p>Belum ada portofolio.</p>
                        <p class="mt-2">Klik <span class="font-medium text-gray-900">Tambah</span> untuk membuat portofolio pertama.</p>
                        <a href="{{ route('pelamar.portofolio.create') }}"
                           class="mt-5 inline-flex items-center rounded-xl bg-black px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-900 transition">
                            + Tambah Portofolio
                        </a>
                    </div>
                @endforelse
            </div>

            @if(method_exists($portofolios, 'links'))
                <div class="mt-8">
                    {{ $portofolios->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
