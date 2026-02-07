@extends('layouts.app')

@section('title', 'Manajemen Akun')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div class="min-w-0">
                <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Manajemen Akun</h1>
                <p class="mt-1 text-sm text-gray-600">Kelola semua akun, termasuk aktif/nonaktif.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}"
                   class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                    Dashboard
                </a>

                <a href="{{ route('admin.users.create') }}"
                   class="inline-flex items-center justify-center rounded-xl bg-black px-4 py-2 text-sm font-medium text-white hover:bg-gray-900 transition">
                    + Tambah Akun
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mt-6 rounded-2xl bg-gray-900 text-white px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                Input filter belum valid.
            </div>
        @endif

        <div class="mt-8 bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
            <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                <div class="sm:col-span-4">
                    <input type="text" name="q" value="{{ request('q') }}"
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition"
                           placeholder="Cari nama / email">
                </div>

                <div class="sm:col-span-2">
                    <select name="role"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                        <option value="">Semua role</option>
                        @foreach(['pelamar','hrd','perusahaan','admin'] as $r)
                            <option value="{{ $r }}" @selected(request('role') === $r)>{{ strtoupper($r) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <select name="status"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                        <option value="">Semua status</option>
                        <option value="active" @selected(request('status') === 'active')>Aktif</option>
                        <option value="inactive" @selected(request('status') === 'inactive')>Nonaktif</option>
                    </select>
                </div>

                <div class="sm:col-span-3">
                    <select name="company_id"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                        <option value="">Semua perusahaan</option>
                        @foreach($companies as $c)
                            <option value="{{ $c->id }}" @selected((string) request('company_id') === (string) $c->id)>{{ $c->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-1">
                    <select name="sort"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                        <option value="latest" @selected((request('sort') ?? 'latest') === 'latest')>Baru</option>
                        <option value="oldest" @selected(request('sort') === 'oldest')>Lama</option>
                    </select>
                </div>

                <div class="sm:col-span-12 flex justify-end gap-2">
                    <a href="{{ route('admin.users.index') }}"
                       class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                        Reset
                    </a>
                    <button type="submit"
                            class="rounded-xl bg-black px-4 py-2 text-sm font-medium text-white hover:bg-gray-900 transition">
                        Terapkan
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-6 bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr class="text-left text-gray-600">
                            <th class="px-6 py-3 font-medium">User</th>
                            <th class="px-6 py-3 font-medium">Role</th>
                            <th class="px-6 py-3 font-medium">Perusahaan</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 font-medium">Dibuat</th>
                            <th class="px-6 py-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($users as $u)
                            <tr class="text-gray-900">
                                <td class="px-6 py-4">
                                    <p class="font-medium">{{ $u->name }}</p>
                                    <p class="text-xs text-gray-600">{{ $u->email }}</p>
                                </td>
                                <td class="px-6 py-4">{{ strtoupper($u->role) }}</td>
                                <td class="px-6 py-4">{{ $u->company?->nama ?: '—' }}</td>
                                <td class="px-6 py-4">
                                    @if($u->is_active)
                                        <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-800 font-medium">Aktif</span>
                                    @else
                                        <span class="text-xs px-3 py-1 rounded-full bg-red-50 text-red-700 font-medium">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $u->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.users.edit', $u->id) }}"
                                           class="rounded-xl border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium hover:bg-gray-50">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('admin.users.status', $u->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="is_active" value="{{ $u->is_active ? 0 : 1 }}">
                                            <button type="submit"
                                                    class="rounded-xl border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium hover:bg-gray-50">
                                                {{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}"
                                              onsubmit="return confirm('Hapus akun ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="rounded-xl bg-red-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-600">
                                    Tidak ada data.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
