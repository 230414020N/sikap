@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex items-start justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Perusahaan</h1>
                    <p class="mt-1 text-sm text-gray-600">Verifikasi, ubah, atau hapus data perusahaan.</p>
                </div>
            </div>

            @if(session('success'))
                <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
            @endif

            @if(session('error'))
                <x-alert type="danger" class="mb-6">{{ session('error') }}</x-alert>
            @endif

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-4 mb-6">
                <form method="GET" action="{{ route('admin.companies.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div class="md:col-span-2">
                        <input type="text" name="q" value="{{ $q }}"
                               class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
                               placeholder="Cari nama perusahaan / industri">
                    </div>

                    <div>
                        <select name="verified"
                                class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                            <option value="all" @selected($verified === 'all')>Verifikasi: Semua</option>
                            <option value="verified" @selected($verified === 'verified')>Terverifikasi</option>
                            <option value="unverified" @selected($verified === 'unverified')>Belum verifikasi</option>
                        </select>
                    </div>

                    <div>
                        <select name="active"
                                class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                            <option value="all" @selected($active === 'all')>Status: Semua</option>
                            <option value="active" @selected($active === 'active')>Aktif</option>
                            <option value="inactive" @selected($active === 'inactive')>Nonaktif</option>
                        </select>
                    </div>

                    <div class="md:col-span-4 flex justify-end gap-2">
                        <a href="{{ route('admin.companies.index') }}"
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
                            <th class="text-left px-5 py-3">Perusahaan</th>
                            <th class="text-left px-5 py-3">Verifikasi</th>
                            <th class="text-left px-5 py-3">Status</th>
                            <th class="text-right px-5 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($companies as $company)
                            <tr class="border-t border-gray-200">
                                <td class="px-5 py-4">
                                    <p class="font-medium text-gray-900">{{ $company->nama ?? '—' }}</p>
                                    <p class="text-xs text-gray-600">{{ $company->industri ?? '—' }}</p>
                                </td>

                                <td class="px-5 py-4">
                                    @if($company->is_verified)
                                        <span class="text-xs px-3 py-1 rounded-full bg-gray-900 text-white">Terverifikasi</span>
                                    @else
                                        <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-800 border border-gray-200">Belum</span>
                                    @endif
                                </td>

                                <td class="px-5 py-4">
                                    @if($company->is_active)
                                        <span class="text-xs px-3 py-1 rounded-full bg-gray-900 text-white">Aktif</span>
                                    @else
                                        <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-800 border border-gray-200">Nonaktif</span>
                                    @endif
                                </td>

                                <td class="px-5 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.companies.edit', $company->id) }}"
                                           class="rounded-xl border border-gray-300 px-4 py-2 text-sm hover:bg-gray-50 transition">
                                            Kelola
                                        </a>

                                        @if(!$company->is_verified)
                                            <form action="{{ route('admin.companies.verify', $company->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                        class="rounded-xl bg-black px-4 py-2 text-sm font-medium text-white hover:bg-gray-900 transition">
                                                    Verifikasi
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.companies.unverify', $company->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                        class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm hover:bg-gray-50 transition">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.companies.toggleActive', $company->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm hover:bg-gray-50 transition">
                                                {{ $company->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.companies.destroy', $company->id) }}" method="POST"
                                              onsubmit="return confirm('Hapus perusahaan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <x-button variant="danger" type="submit" class="px-4 py-2">Hapus</x-button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-10 text-center text-gray-600">
                                    Belum ada perusahaan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $companies->links() }}
            </div>
        </div>
    </div>
@endsection
``
