<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    @php
        $isAuth = auth()->check();
        $user = $isAuth ? auth()->user() : null;
        $role = $user?->role;

        $href = function (string $name, array $params = [], string $fallback = '#') {
            return \Illuminate\Support\Facades\Route::has($name) ? route($name, $params) : $fallback;
        };

        $homeHref = \Illuminate\Support\Facades\Route::has('home') ? route('home') : url('/');
        $logoSrc = asset('images/logo.png');

        $primaryNav = [];

        if ($role === 'pelamar') {
            $primaryNav = [
                ['label' => 'Dashboard', 'href' => $href('pelamar.dashboard'), 'active' => request()->routeIs('pelamar.dashboard')],
                ['label' => 'Cari Lowongan', 'href' => $href('pelamar.jobs.index'), 'active' => request()->routeIs('pelamar.jobs.*')],
                ['label' => 'Tracking', 'href' => $href('pelamar.applications.tracking'), 'active' => request()->routeIs('pelamar.applications.*')],
                ['label' => 'Portofolio', 'href' => $href('pelamar.portofolio.index'), 'active' => request()->routeIs('pelamar.portofolio.*')],
                ['label' => 'Notifikasi', 'href' => $href('pelamar.notifications.index'), 'active' => request()->routeIs('pelamar.notifications.*')],
            ];
        } elseif ($role === 'perusahaan') {
            $primaryNav = [
                ['label' => 'Dashboard', 'href' => $href('perusahaan.dashboard'), 'active' => request()->routeIs('perusahaan.dashboard')],
                ['label' => 'Lowongan', 'href' => $href('perusahaan.jobs.index'), 'active' => request()->routeIs('perusahaan.jobs.*')],
                ['label' => 'HRD', 'href' => $href('perusahaan.hrd.index'), 'active' => request()->routeIs('perusahaan.hrd.*')],
                ['label' => 'Profil Perusahaan', 'href' => $href('perusahaan.company.edit'), 'active' => request()->routeIs('perusahaan.company.*')],
            ];
        } elseif ($role === 'hrd') {
            $primaryNav = [
                ['label' => 'Dashboard', 'href' => $href('hrd.dashboard'), 'active' => request()->routeIs('hrd.dashboard')],
                ['label' => 'Lowongan', 'href' => $href('hrd.jobs.index'), 'active' => request()->routeIs('hrd.jobs.*')],
                ['label' => 'Lamaran', 'href' => $href('hrd.applications.index'), 'active' => request()->routeIs('hrd.applications.*')],
                ['label' => 'Profil Perusahaan', 'href' => $href('hrd.company.edit'), 'active' => request()->routeIs('hrd.company.*')],
            ];
        } elseif ($role === 'admin') {
            $primaryNav = [
                ['label' => 'Perusahaan', 'href' => $href('admin.companies.index'), 'active' => request()->routeIs('admin.companies.*')],
                ['label' => 'Portofolio', 'href' => $href('admin.portofolios.index'), 'active' => request()->routeIs('admin.portofolios.*')],
                ['label' => 'Master Data', 'href' => $href('admin.master.job-categories.index'), 'active' => request()->routeIs('admin.master.*')],
            ];
        } else {
            if ($isAuth) {
                $primaryNav = [
                    ['label' => 'Dashboard', 'href' => $href('dashboard'), 'active' => request()->routeIs('dashboard')],
                ];
            } else {
                $primaryNav = [
                    ['label' => 'Beranda', 'href' => $homeHref, 'active' => request()->is('/')],
                ];
            }
        }

        $profileHref = $href('profile.edit');
        if ($role === 'pelamar') $profileHref = $href('pelamar.profile.edit', [], $profileHref);
        if ($role === 'perusahaan') $profileHref = $href('perusahaan.company.edit', [], $profileHref);
        if ($role === 'hrd') $profileHref = $href('hrd.company.edit', [], $profileHref);

        $roleBadge = null;
        if ($role === 'pelamar') $roleBadge = 'Pelamar';
        if ($role === 'perusahaan') $roleBadge = 'Perusahaan';
        if ($role === 'hrd') $roleBadge = 'HRD';
        if ($role === 'admin') $roleBadge = 'Admin';

        $guestLinks = [
            ['label' => 'Login Pelamar', 'href' => $href('login.pelamar', [], $href('login', ['as' => 'pelamar']))],
            ['label' => 'Login Perusahaan', 'href' => $href('login.perusahaan', [], $href('login', ['as' => 'perusahaan']))],
            ['label' => 'Login HRD', 'href' => $href('login.hrd', [], $href('login', ['as' => 'hrd']))],
        ];
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between min-h-[80px] py-3">
            <div class="flex items-center gap-6">
                <a href="{{ $homeHref }}" class="flex items-center">
                    <img src="{{ $logoSrc }}" alt="Logo SIKAP" class="h-14 sm:h-16 lg:h-18 w-auto max-w-none object-contain">
                </a>

                <div class="hidden sm:flex items-center gap-1">
                    @foreach($primaryNav as $item)
                        <a href="{{ $item['href'] }}"
                           class="px-4 py-2 rounded-2xl text-sm font-medium transition {{ $item['active'] ? 'bg-gray-900 text-white shadow-sm' : 'text-gray-700 hover:bg-gray-100' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="hidden sm:flex items-center gap-2">
                @auth
                    @if($roleBadge)
                        <span class="text-xs px-3 py-1 rounded-full border border-gray-200 bg-gray-50 text-gray-800">
                            {{ $roleBadge }}
                        </span>
                    @endif

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 rounded-2xl border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-900/20 focus-visible:ring-offset-2">
                                <div class="h-8 w-8 rounded-2xl bg-gray-900 text-white flex items-center justify-center text-xs font-semibold">
                                    {{ mb_substr($user->name ?? 'U', 0, 1) }}
                                </div>
                                <div class="max-w-[160px] truncate">{{ $user->name }}</div>
                                <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.94a.75.75 0 111.08 1.04l-4.24 4.5a.75.75 0 01-1.08 0l-4.24-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="$profileHref">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth

                @guest
                    @foreach($guestLinks as $gl)
                        <a href="{{ $gl['href'] }}"
                           class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                            {{ $gl['label'] }}
                        </a>
                    @endforeach
                @endguest
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center rounded-2xl p-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-900/20 focus-visible:ring-offset-2">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 px-4">
            @foreach($primaryNav as $item)
                <a href="{{ $item['href'] }}"
                   class="block rounded-2xl px-4 py-3 text-sm font-medium transition {{ $item['active'] ? 'bg-gray-900 text-white' : 'border border-gray-200 bg-white text-gray-900 hover:bg-gray-50' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>

        @auth
            <div class="pt-4 pb-4 border-t border-gray-100">
                <div class="px-4">
                    <div class="text-base font-medium text-gray-900">{{ $user->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ $user->email }}</div>
                </div>

                <div class="mt-3 space-y-1 px-4">
                    <a href="{{ $profileHref }}"
                       class="block rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                        {{ __('Profile') }}
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full text-left rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        @endauth

        @guest
            <div class="pt-4 pb-4 border-t border-gray-100 px-4 space-y-2">
                @foreach($guestLinks as $gl)
                    <a href="{{ $gl['href'] }}"
                       class="block rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                        {{ $gl['label'] }}
                    </a>
                @endforeach
            </div>
        @endguest
    </div>
</nav>
