@extends('layouts.app')

@section('content')
    @php
        $routes = [
            'dashboard' => route('dashboard'),
            'jobs' => route('pelamar.jobs.index'),
            'tracking' => route('pelamar.applications.tracking'),
            'portofolio' => route('pelamar.portofolio.index'),
            'portofolio_create' => route('pelamar.portofolio.create'),
            'notifications' => route('pelamar.notifications.index'),
            'profile_docs' => route('pelamar.profile.edit'),
            'account' => route('profile.edit'),
            'logout' => route('logout'),
        ];

        $primaryMenu = [
            [
                'label' => 'Dashboard',
                'href' => $routes['dashboard'],
                'active' => 'dashboard',
                'right' => '↵',
                'variant' => 'primary',
            ],
            [
                'label' => 'Cari Lowongan',
                'href' => $routes['jobs'],
                'active' => 'pelamar.jobs.*',
                'right' => '→',
                'variant' => 'secondary',
            ],
            [
                'label' => 'Tracking Lamaran',
                'href' => $routes['tracking'],
                'active' => 'pelamar.applications.*',
                'right' => '→',
                'variant' => 'secondary',
            ],
            [
                'label' => 'Portofolio',
                'href' => $routes['portofolio'],
                'active' => 'pelamar.portofolio.*',
                'right' => '→',
                'variant' => 'secondary',
            ],
            [
                'label' => 'Notifikasi',
                'href' => $routes['notifications'],
                'active' => 'pelamar.notifications.*',
                'right' => '→',
                'variant' => 'secondary',
            ],
        ];

        $generalMenu = [
            [
                'label' => 'Profil & Dokumen',
                'href' => $routes['profile_docs'],
                'active' => 'pelamar.profile.*',
                'right' => '→',
            ],
            [
                'label' => 'Pengaturan Akun',
                'href' => $routes['account'],
                'active' => 'profile.*',
                'right' => '→',
            ],
        ];

        $shortcutTabs = [
            ['label' => 'Jobs', 'href' => $routes['jobs'], 'active' => 'pelamar.jobs.*'],
            ['label' => 'Tracking', 'href' => $routes['tracking'], 'active' => 'pelamar.applications.*'],
            ['label' => 'Portofolio', 'href' => $routes['portofolio'], 'active' => 'pelamar.portofolio.*'],
        ];

        $moduleCardsTop = [
            ['label' => 'Profil', 'desc' => 'Edit data diri, CV, dan surat lamaran.', 'href' => $routes['profile_docs'], 'active' => 'pelamar.profile.*'],
            ['label' => 'Portofolio', 'desc' => 'Tambah, edit, dan kelola showcase.', 'href' => $routes['portofolio'], 'active' => 'pelamar.portofolio.*'],
            ['label' => 'Lowongan', 'desc' => 'Cari lowongan dan lihat detailnya.', 'href' => $routes['jobs'], 'active' => 'pelamar.jobs.*'],
        ];

        $moduleCardsBottom = [
            ['label' => 'Tracking', 'desc' => 'Lihat status lamaran dan detailnya.', 'href' => $routes['tracking'], 'active' => 'pelamar.applications.*'],
            ['label' => 'Notifikasi', 'desc' => 'Update status lamaran masuk di sini.', 'href' => $routes['notifications'], 'active' => 'pelamar.notifications.*'],
        ];

        $btnBase = 'inline-flex items-center justify-center rounded-2xl px-5 py-3 text-sm font-medium transition focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-900/20 focus-visible:ring-offset-2 focus-visible:ring-offset-gray-50';
        $btnSecondary = $btnBase . ' border border-gray-200 bg-white text-gray-900 hover:bg-gray-50';
        $btnPrimary = $btnBase . ' bg-gray-900 text-white hover:bg-black shadow-sm';

        $profileCompleteValue = (($profileComplete ?? false) === true);
        $portofolioCountValue = (int) ($portofolioCount ?? 0);
        $applicationCountValue = (int) ($applicationCount ?? 0);

        $target = (int) ($targetShowcase ?? 3);
        $progress = (int) ($progressProfile ?? min(100, round(($portofolioCountValue / max(1, $target)) * 100)));

        $statCards = [
            [
                'label' => 'Kelengkapan Profil',
                'value' => $profileCompleteValue ? 'Lengkap' : 'Belum',
                'desc' => $profileCompleteValue ? 'CV & surat lamaran tersedia' : 'Tambah CV & surat lamaran',
                'icon' => '↗',
                'iconClass' => 'bg-gray-900 text-white',
                'actionLabel' => 'Lengkapi',
                'actionHref' => $routes['profile_docs'],
                'actionClass' => $btnSecondary,
            ],
            [
                'label' => 'Portofolio',
                'value' => $portofolioCountValue,
                'desc' => 'Total showcase kamu',
                'icon' => '+',
                'iconClass' => 'border border-gray-200 bg-gray-50 text-gray-900',
                'actionLabel' => 'Kelola',
                'actionHref' => $routes['portofolio'],
                'actionClass' => $btnSecondary,
            ],
            [
                'label' => 'Lamaran',
                'value' => $applicationCountValue,
                'desc' => 'Total terkirim',
                'icon' => '→',
                'iconClass' => 'border border-gray-200 bg-white text-gray-900',
                'actionLabel' => 'Tracking',
                'actionHref' => $routes['tracking'],
                'actionClass' => $btnSecondary,
            ],
        ];
    @endphp

    <div class="min-h-screen bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-gray-50 border border-gray-200 rounded-[28px] shadow-sm overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] min-h-[78vh]">
                    <aside class="bg-white border-b lg:border-b-0 lg:border-r border-gray-200 lg:sticky lg:top-0 lg:h-screen">
                        <div class="p-6">
                            <div class="flex items-center gap-3">
                                <div class="h-11 w-11 rounded-3xl bg-gray-900 text-white flex items-center justify-center text-sm font-semibold shadow-sm">
                                    S
                                </div>
                                <div class="leading-tight">
                                    <p class="text-base font-semibold tracking-tight text-gray-900">SIKAP</p>
                                    <p class="text-xs text-gray-500">Pelamar</p>
                                </div>
                            </div>

                            <div class="mt-6">
                                <p class="text-[11px] font-semibold tracking-widest text-gray-500">MENU</p>

                                <div class="mt-3 space-y-2">
                                    @foreach($primaryMenu as $item)
                                        @php
                                            $isActive = request()->routeIs($item['active'])
                                                || ($item['variant'] === 'primary' && request()->routeIs('dashboard'));
                                        @endphp

                                        <a href="{{ $item['href'] }}"
                                           @class([
                                               'flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-medium transition focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-900/20 focus-visible:ring-offset-2',
                                               'bg-gray-900 text-white shadow-sm' => $isActive,
                                               'border border-gray-200 bg-white text-gray-900 hover:bg-gray-50' => !$isActive,
                                           ])>
                                            <span>{{ $item['label'] }}</span>
                                            <span @class([
                                                'text-xs',
                                                'text-white/70' => $isActive,
                                                'text-gray-500' => !$isActive,
                                            ])>{{ $item['right'] }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-8">
                                <p class="text-[11px] font-semibold tracking-widest text-gray-500">GENERAL</p>

                                <div class="mt-3 space-y-2">
                                    @foreach($generalMenu as $item)
                                        <a href="{{ $item['href'] }}"
                                           @class([
                                               'flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-medium transition focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-900/20 focus-visible:ring-offset-2',
                                               'border border-gray-200 bg-white text-gray-900 hover:bg-gray-50',
                                               'ring-2 ring-gray-900/10' => request()->routeIs($item['active']),
                                           ])>
                                            <span>{{ $item['label'] }}</span>
                                            <span class="text-xs text-gray-500">{{ $item['right'] }}</span>
                                        </a>
                                    @endforeach

                                    <form method="POST" action="{{ $routes['logout'] }}">
                                        @csrf
                                        <button type="submit"
                                                class="w-full flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-medium border border-gray-200 bg-white text-gray-900 hover:bg-gray-50 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-900/20 focus-visible:ring-offset-2">
                                            <span>Logout</span>
                                            <span class="text-xs text-gray-500">↩</span>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="mt-8 rounded-3xl border border-gray-200 bg-gray-50 p-5">
                                <p class="text-xs text-gray-600">Quick Action</p>
                                <p class="mt-2 text-sm font-semibold text-gray-900">Tambah showcase</p>
                                <p class="mt-1 text-xs text-gray-600">Portofolio rapi bikin peluang makin besar.</p>

                                <a href="{{ $routes['portofolio_create'] }}"
                                   class="mt-4 inline-flex items-center justify-center rounded-2xl bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-black transition w-full focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-900/20 focus-visible:ring-offset-2 focus-visible:ring-offset-gray-50">
                                    + Portofolio
                                </a>
                            </div>
                        </div>
                    </aside>

                    <main class="bg-gray-50">
                        <div class="p-6 sm:p-8">
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                                <div>
                                    <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-gray-900">Dashboard</h1>
                                    <p class="mt-1 text-sm text-gray-600">Kelola profil, portofolio, dan pantau lamaran kamu.</p>
                                </div>

                                <div class="flex flex-col sm:flex-row gap-3">
                                    <div class="relative w-full sm:w-80">
                                        <label class="sr-only" for="job-search">Cari lowongan</label>
                                        <input
                                            id="job-search"
                                            type="text"
                                            placeholder="Cari lowongan…"
                                            class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 transition"
                                        >
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 border border-gray-200 rounded-xl px-2 py-1 bg-gray-50">
                                            ⌘ K
                                        </div>
                                    </div>

                                    <a href="{{ $routes['jobs'] }}" class="{{ $btnSecondary }}">Cari Lowongan</a>
                                    <a href="{{ $routes['tracking'] }}" class="{{ $btnPrimary }}">Tracking</a>
                                </div>
                            </div>

                            <div class="mt-7 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                @foreach($statCards as $card)
                                    <div class="bg-white border border-gray-200 rounded-3xl shadow-sm p-5">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <p class="text-xs text-gray-600">{{ $card['label'] }}</p>
                                                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $card['value'] }}</p>
                                                <p class="mt-2 text-xs text-gray-500">{{ $card['desc'] }}</p>
                                            </div>

                                            <div class="h-10 w-10 rounded-2xl flex items-center justify-center text-xs font-semibold {{ $card['iconClass'] }}">
                                                {{ $card['icon'] }}
                                            </div>
                                        </div>

                                        <a href="{{ $card['actionHref'] }}" class="mt-4 w-full {{ $card['actionClass'] }}">
                                            {{ $card['actionLabel'] }}
                                        </a>
                                    </div>
                                @endforeach

                                <div class="bg-white border border-gray-200 rounded-3xl shadow-sm p-5">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <p class="text-xs text-gray-600">Progress Profil</p>
                                            <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $progress }}%</p>
                                            <p class="mt-2 text-xs text-gray-500">Target {{ $target }} showcase</p>
                                        </div>

                                        <div class="h-10 w-10 rounded-2xl bg-gray-900 text-white flex items-center justify-center text-xs font-semibold">
                                            ✓
                                        </div>
                                    </div>

                                    <div class="mt-4 h-2 rounded-full bg-gray-100 overflow-hidden">
                                        <div class="h-full bg-gray-900" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-4">
                                <div class="lg:col-span-2 bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
                                    <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">Lamaran Terbaru</p>
                                            <p class="mt-1 text-xs text-gray-600">Akses cepat untuk detail lamaran.</p>
                                        </div>

                                        <a href="{{ $routes['tracking'] }}"
                                           class="text-sm text-gray-900 underline underline-offset-4 hover:text-gray-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-900/20 focus-visible:ring-offset-2 focus-visible:ring-offset-white rounded-lg px-1">
                                            Lihat semua
                                        </a>
                                    </div>

                                    <div class="divide-y divide-gray-200">
                                        @forelse(($latestApplications ?? collect()) as $app)
                                            <div class="px-6 py-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                                <div class="min-w-0">
                                                    <p class="text-sm font-semibold text-gray-900 truncate">
                                                        {{ $app->job?->judul ?? 'Lowongan' }}
                                                    </p>
                                                    <p class="mt-1 text-sm text-gray-600 truncate">
                                                        {{ $app->job?->company?->nama ?? $app->job?->company?->name ?? 'Perusahaan' }}
                                                    </p>
                                                    <p class="mt-2 text-xs text-gray-500">
                                                        {{ $app->created_at?->format('d M Y, H:i') }}
                                                    </p>
                                                </div>

                                                <div class="flex items-center gap-2">
                                                    <span class="text-xs px-3 py-1 rounded-full border border-gray-200 bg-gray-50 text-gray-800">
                                                        {{ $app->status ?? 'Dikirim' }}
                                                    </span>

                                                    <a href="{{ route('pelamar.applications.show', $app->id) }}"
                                                       class="rounded-2xl bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-black transition shadow-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-900/20 focus-visible:ring-offset-2 focus-visible:ring-offset-white">
                                                        Detail
                                                    </a>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="px-6 py-10 text-center text-sm text-gray-600">
                                                Belum ada lamaran. Mulai cari lowongan dan apply.
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="bg-white border border-gray-200 rounded-3xl shadow-sm p-6">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">Checklist</p>
                                            <p class="mt-1 text-xs text-gray-600">Langkah cepat biar siap apply.</p>
                                        </div>

                                        <div class="h-10 w-10 rounded-2xl border border-gray-200 bg-gray-50 flex items-center justify-center text-xs font-semibold text-gray-900">
                                            ✓
                                        </div>
                                    </div>

                                    <div class="mt-5 space-y-3">
                                        <a href="{{ $routes['profile_docs'] }}"
                                           class="block rounded-2xl border border-gray-200 bg-gray-50 p-4 hover:bg-gray-100 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-900/20 focus-visible:ring-offset-2 focus-visible:ring-offset-white">
                                            <p class="text-sm font-semibold text-gray-900">Lengkapi dokumen</p>
                                            <p class="mt-1 text-sm text-gray-600">Tambah CV dan surat lamaran.</p>
                                        </a>

                                        <a href="{{ $routes['portofolio'] }}"
                                           class="block rounded-2xl border border-gray-200 bg-gray-50 p-4 hover:bg-gray-100 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-900/20 focus-visible:ring-offset-2 focus-visible:ring-offset-white">
                                            <p class="text-sm font-semibold text-gray-900">Rapikan portofolio</p>
                                            <p class="mt-1 text-sm text-gray-600">Tambahkan showcase terbaik.</p>
                                        </a>

                                        <a href="{{ $routes['jobs'] }}"
                                           class="block rounded-2xl border border-gray-200 bg-gray-50 p-4 hover:bg-gray-100 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-900/20 focus-visible:ring-offset-2 focus-visible:ring-offset-white">
                                            <p class="text-sm font-semibold text-gray-900">Cari lowongan</p>
                                            <p class="mt-1 text-sm text-gray-600">Gunakan filter untuk hasil relevan.</p>
                                        </a>

                                        <a href="{{ $routes['notifications'] }}"
                                           class="block rounded-2xl border border-gray-200 bg-gray-50 p-4 hover:bg-gray-100 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-900/20 focus-visible:ring-offset-2 focus-visible:ring-offset-white">
                                            <p class="text-sm font-semibold text-gray-900">Cek notifikasi</p>
                                            <p class="mt-1 text-sm text-gray-600">Update status lamaran masuk di sini.</p>
                                        </a>
                                    </div>

                                    <div class="mt-6 rounded-3xl border border-gray-200 bg-white p-5">
                                        <p class="text-xs text-gray-600">Status</p>

                                        @if($profileCompleteValue)
                                            <p class="mt-2 text-sm font-semibold text-gray-900">Siap untuk apply</p>
                                            <p class="mt-1 text-xs text-gray-500">Dokumen utama sudah lengkap.</p>
                                        @else
                                            <p class="mt-2 text-sm font-semibold text-gray-900">Perlu dilengkapi</p>
                                            <p class="mt-1 text-xs text-gray-500">Lengkapi CV & surat lamaran dulu.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
@endsection
