@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="mb-8">
                <h1 class="text-2xl font-semibold text-gray-900">Portofolio Publik</h1>
                <p class="mt-1 text-sm text-gray-600">Jelajahi portofolio pengguna lain dan beri like.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse($portofolios as $p)
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                        @if($p->thumbnail_path)
                            <img src="{{ asset('storage/' . $p->thumbnail_path) }}" class="w-full h-44 object-cover">
                        @else
                            <div class="w-full h-44 bg-gray-100 flex items-center justify-center text-gray-400 text-sm">
                                No Thumbnail
                            </div>
                        @endif

                        <div class="p-5">
                            <h2 class="text-base font-semibold text-gray-900">{{ $p->judul }}</h2>
                            <p class="mt-1 text-sm text-gray-600">by {{ $p->user->name }}</p>

                            <p class="mt-3 text-sm text-gray-700">
                                {{ \Illuminate\Support\Str::limit($p->deskripsi, 110) }}
                            </p>

                            <div class="mt-5 flex items-center justify-between">
                                <span class="text-sm text-gray-600">
                                    {{ $p->likes_count ?? 0 }} likes
                                </span>

                                <form method="POST" action="{{ route('pelamar.portofolio.like', $p->id) }}">
                                    @csrf
                                    <button class="rounded-xl px-4 py-2 text-sm font-medium transition {{ ($p->is_liked ?? false) ? 'bg-gray-900 text-white' : 'bg-white border border-gray-300 text-gray-900 hover:bg-gray-50' }}">
                                        {{ ($p->is_liked ?? false) ? 'Liked' : 'Like' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white border border-gray-200 rounded-2xl shadow-sm p-10 text-center text-gray-600">
                        Belum ada portofolio publik.
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $portofolios->links() }}
            </div>
        </div>
    </div>
@endsection
