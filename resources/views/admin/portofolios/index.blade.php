@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex items-start justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Moderasi Portofolio</h1>
                    <p class="mt-1 text-sm text-gray-600">Take down atau hapus showcase yang tidak sesuai.</p>
                </div>
            </div>

            @if(session('success'))
                <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
            @endif

            @if(session('error'))
                <x-alert type="error" class="mb-6">{{ session('error') }}</x-alert>
            @endif

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-4 mb-6">
                <form method="GET" action="{{ route('admin.portofolios.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div class="md:col-span-3">
                        <input type="text" name="q" value="{{ $q }}"
                               class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
                               placeholder="Cari judul, deskripsi, kategori, tools, nama/email pemilik">
                    </div>

                    <div>
                        <select name="status"
                                class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                            <option value="all" @selected($status === 'all')>Status: Semua</option>
                            <option value="active" @selected($status === 'active')>Tampil Publik</option>
                            <option value="takedown" @selected($status === 'takedown')>Di-take down</option>
                        </select>
                    </div>

                    <div class="md:col-span-4 flex justify-end gap-2">
                        <a href="{{ route('admin.portofolios.index') }}"
                           class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm hover:bg-gray-50 transition">
                            Reset
                        </a>
                        <button type="submit"
                                class="rounded-xl bg-black px-4 py-2 text-sm font-medium text-white hover:bg-gray-900 transition">
                            Terapkan
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="text-left px-5 py-3">Portofolio</th>
                            <th class="text-left px-5 py-3">Pemilik</th>
                            <th class="text-left px-5 py-3">Likes</th>
                            <th class="text-left px-5 py-3">Status</th>
                            <th class="text-right px-5 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($portofolios as $p)
                            <tr class="border-t border-gray-200">
                                <td class="px-5 py-4">
                                    <p class="font-medium text-gray-900">{{ $p->judul }}</p>
                                    <p class="text-xs text-gray-600">{{ $p->kategori ?? '-' }} • {{ $p->tools ?? '-' }}</p>
                                </td>

                                <td class="px-5 py-4 text-gray-700">
                                    <p class="font-medium text-gray-900">{{ $p->user->name }}</p>
                                    <p class="text-xs text-gray-600">{{ $p->user->email }}</p>
                                </td>

                                <td class="px-5 py-4 text-gray-700">{{ $p->likes_count ?? 0 }}</td>

                                <td class="px-5 py-4">
                                    @if($p->is_taken_down)
                                        <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-800 border border-gray-200">Di-take down</span>
                                    @else
                                        <span class="text-xs px-3 py-1 rounded-full bg-gray-900 text-white">Tampil</span>
                                    @endif
                                </td>

                                <td class="px-5 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.portofolios.show', $p->id) }}"
                                           class="rounded-xl border border-gray-300 px-4 py-2 text-sm hover:bg-gray-50 transition">
                                            Detail
                                        </a>

                                        <form action="{{ route('admin.portofolios.destroy', $p->id) }}" method="POST"
                                              onsubmit="return confirm('Hapus portofolio ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <x-button variant="danger" type="submit" class="px-4 py-2">Hapus</x-button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-gray-600">
                                    Belum ada portofolio.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $portofolios->links() }}
            </div>
        </div>
    </div>
@endsection
