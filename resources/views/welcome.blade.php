<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIKAP • Platform Karir & Rekrutmen</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    $href = function (string $name, array $params = [], string $fallback = '#') {
        return \Illuminate\Support\Facades\Route::has($name) ? route($name, $params) : $fallback;
    };

    $logoSrc = asset('images/logo.png');

    $topNav = [
        ['label' => 'Fitur', 'href' => '#fitur'],
        ['label' => 'Modul', 'href' => '#modul'],
        ['label' => 'Kontak', 'href' => '#kontak'],
    ];

    $loginLinks = [
        ['label' => 'Masuk sebagai Pelamar', 'href' => $href('login.pelamar')],
        ['label' => 'Masuk sebagai HRD', 'href' => $href('login.hrd')],
        ['label' => 'Masuk sebagai Perusahaan', 'href' => $href('login.perusahaan')],
    ];
@endphp
<body class="bg-white text-gray-900 antialiased" style="font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui;">
<header x-data="{ open:false }" class="sticky top-0 z-50">
    <div class="border-b border-gray-200 bg-white/75 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-20 flex items-center justify-between gap-4">
                <a href="{{ $href('home', [], url('/')) }}" class="flex items-center">
                    <img src="{{ $logoSrc }}" alt="Logo SIKAP" class="h-16 sm:h-20 lg:h-24 w-auto max-w-none object-contain">
                </a>
                <nav class="hidden lg:flex items-center gap-1">
                    @foreach($topNav as $n)
                        <a href="{{ $n['href'] }}"
                           class="px-4 py-2 rounded-xl text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 transition">
                            {{ $n['label'] }}
                        </a>
                    @endforeach
                </nav>

                <div class="flex items-center gap-2">
                    @auth
                        <a href="{{ $href('dashboard') }}"
                           class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-black transition shadow-sm">
                            Buka Dashboard
                        </a>
                    @else
                        <details class="relative hidden sm:block">
                            <summary class="list-none cursor-pointer inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-900 hover:bg-gray-50 transition">
                                Masuk <span class="ml-2 text-xs text-gray-500">▾</span>
                            </summary>

                            <div class="absolute right-0 mt-2 w-72 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
                                <div class="p-2">
                                    @foreach($loginLinks as $l)
                                        <a href="{{ $l['href'] }}"
                                           class="flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                                            <span>{{ $l['label'] }}</span>
                                            <span class="text-xs text-gray-500">↵</span>
                                        </a>
                                    @endforeach
                                </div>
                                <div class="border-t border-gray-200 p-2 grid grid-cols-2 gap-2">
                                    <a href="{{ $href('register') }}"
                                       class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-3 py-2.5 text-sm font-semibold text-white hover:bg-black transition">
                                        Daftar Pelamar
                                    </a>
                                    <a href="{{ $href('perusahaan.register') }}"
                                       class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-sm font-semibold text-gray-900 hover:bg-gray-50 transition">
                                        Daftar Perusahaan
                                    </a>
                                </div>
                            </div>
                        </details>

                        <a href="{{ $href('register') }}"
                           class="hidden sm:inline-flex items-center justify-center rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-black transition shadow-sm">
                            Daftar Pelamar
                        </a>

                        <a href="{{ $href('perusahaan.register') }}"
                           class="hidden sm:inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-900 hover:bg-gray-50 transition">
                            Daftar Perusahaan
                        </a>
                    @endauth

                    <button type="button"
                            class="lg:hidden inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-900 hover:bg-gray-50 transition"
                            @click="open = !open">
                        Menu
                    </button>
                </div>
            </div>

            <div class="lg:hidden pb-4" x-show="open" x-cloak>
                <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                    <div class="p-2 flex flex-col">
                        @foreach($topNav as $n)
                            <a href="{{ $n['href'] }}"
                               class="rounded-xl px-3 py-2.5 text-sm font-semibold text-gray-900 hover:bg-gray-50 transition"
                               @click="open = false">
                                {{ $n['label'] }}
                            </a>
                        @endforeach
                    </div>

                    @guest
                        <div class="border-t border-gray-200 p-2">
                            <div class="text-xs font-semibold text-gray-500 px-2 pb-2">Masuk</div>
                            @foreach($loginLinks as $l)
                                <a href="{{ $l['href'] }}"
                                   class="rounded-xl px-3 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-50 transition block">
                                    {{ $l['label'] }}
                                </a>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-200 p-2 grid grid-cols-2 gap-2">
                            <a href="{{ $href('register') }}"
                               class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-3 py-2.5 text-sm font-semibold text-white hover:bg-black transition">
                                Daftar Pelamar
                            </a>
                            <a href="{{ $href('perusahaan.register') }}"
                               class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-sm font-semibold text-gray-900 hover:bg-gray-50 transition">
                                Daftar Perusahaan
                            </a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</header>

<main>
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-gray-50 via-white to-white"></div>
        <div class="absolute -top-24 -left-24 h-80 w-80 rounded-full bg-gray-900/5 blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 h-80 w-80 rounded-full bg-gray-900/5 blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-14 sm:pt-16 sm:pb-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-7">
                    <div class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-4 py-2 text-xs font-medium text-gray-700 shadow-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-gray-900"></span>
                        Platform karir & rekrutmen end-to-end
                    </div>

                    <h1 class="mt-6 text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-gray-900 leading-[1.07]">
                        Rekrutmen lebih rapi.
                        <span class="block bg-gradient-to-r from-gray-900 via-gray-800 to-gray-500 bg-clip-text text-transparent">
                            Portofolio lebih meyakinkan.
                        </span>
                    </h1>

                    <p class="mt-5 text-base sm:text-lg text-gray-600 leading-relaxed max-w-2xl">
                        SIKAP membantu pelamar membangun profil & showcase, sementara HRD memproses kandidat dengan status yang konsisten,
                        riwayat yang jelas, dan keputusan yang lebih cepat.
                    </p>

                    <div class="mt-7 flex flex-col sm:flex-row gap-3">
                        @auth
                            <a href="{{ $href('dashboard') }}"
                               class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-6 py-3 text-sm font-semibold text-white hover:bg-black transition shadow-sm">
                                Buka Dashboard
                            </a>
                        @else
                            <a href="{{ $href('register') }}"
                               class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-6 py-3 text-sm font-semibold text-white hover:bg-black transition shadow-sm">
                                Daftar Pelamar
                            </a>
                            <a href="{{ $href('perusahaan.register') }}"
                               class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-900 hover:bg-gray-50 transition">
                                Daftar Perusahaan
                            </a>
                        @endauth
                    </div>

                    <div class="mt-7 grid grid-cols-1 sm:grid-cols-3 gap-3 max-w-2xl">
                        <div class="rounded-2xl border border-gray-200 bg-white p-4">
                            <div class="text-sm font-semibold text-gray-900">Tracking jelas</div>
                            <div class="mt-1 text-xs text-gray-600">Status & timeline lamaran transparan</div>
                        </div>
                        <div class="rounded-2xl border border-gray-200 bg-white p-4">
                            <div class="text-sm font-semibold text-gray-900">Dokumen rapi</div>
                            <div class="mt-1 text-xs text-gray-600">Snapshot CV & surat lamaran per aplikasi</div>
                        </div>
                        <div class="rounded-2xl border border-gray-200 bg-white p-4">
                            <div class="text-sm font-semibold text-gray-900">Showcase terkurasi</div>
                            <div class="mt-1 text-xs text-gray-600">Portofolio publik + moderasi admin</div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="rounded-3xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-200 bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-semibold text-gray-900">Ringkasan Workflow</div>
                                <span class="text-xs px-3 py-1 rounded-full bg-gray-900 text-white">Live</span>
                            </div>
                            <div class="mt-2 text-xs text-gray-600">Contoh alur rekrutmen yang konsisten</div>
                        </div>

                        <div class="p-6 space-y-4">
                            <div class="rounded-2xl border border-gray-200 p-4">
                                <div class="flex items-center justify-between">
                                    <div class="text-sm font-semibold text-gray-900">Lamaran Masuk</div>
                                    <span class="text-xs px-2.5 py-1 rounded-full bg-gray-100 text-gray-800">Pending</span>
                                </div>
                                <div class="mt-2 text-xs text-gray-600">CV tersimpan • Portofolio terhubung</div>
                            </div>

                            <div class="rounded-2xl border border-gray-200 p-4">
                                <div class="flex items-center justify-between">
                                    <div class="text-sm font-semibold text-gray-900">Review HRD</div>
                                    <span class="text-xs px-2.5 py-1 rounded-full bg-gray-900 text-white">In Review</span>
                                </div>
                                <div class="mt-2 text-xs text-gray-600">Catatan & riwayat perubahan tercatat</div>
                            </div>

                            <div class="rounded-2xl border border-gray-200 p-4">
                                <div class="flex items-center justify-between">
                                    <div class="text-sm font-semibold text-gray-900">Keputusan</div>
                                    <span class="text-xs px-2.5 py-1 rounded-full bg-gray-100 text-gray-800">Final</span>
                                </div>
                                <div class="mt-2 text-xs text-gray-600">Transparan untuk kandidat & tim</div>
                            </div>

                            <div class="grid grid-cols-2 gap-3 pt-2">
                                <a href="#fitur" class="rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-900 hover:bg-gray-50 transition text-center">
                                    Lihat Fitur
                                </a>
                                <a href="#modul" class="rounded-2xl bg-gray-900 px-4 py-3 text-sm font-semibold text-white hover:bg-black transition text-center">
                                    Lihat Modul
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-500">
                        <span class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-3 py-2">
                            <span class="h-1.5 w-1.5 rounded-full bg-gray-900"></span>
                            Terstruktur
                        </span>
                        <span class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-3 py-2">
                            <span class="h-1.5 w-1.5 rounded-full bg-gray-900"></span>
                            Audit-friendly
                        </span>
                        <span class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-3 py-2">
                            <span class="h-1.5 w-1.5 rounded-full bg-gray-900"></span>
                            Konsisten
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="modul" class="border-t border-gray-200 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="text-center">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-gray-900">Modul lengkap untuk rekrutmen modern</h2>
                <p class="mt-3 text-sm sm:text-base text-gray-600 max-w-2xl mx-auto">
                    Dari publikasi lowongan hingga evaluasi kandidat, semuanya dibuat rapi, cepat, dan mudah dipakai.
                </p>
            </div>

            <div class="mt-10 grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 rounded-3xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                    <div class="h-56 sm:h-64 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-700 relative">
                        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_30%_20%,white,transparent_55%)]"></div>
                        <div class="absolute inset-x-0 bottom-0 p-6 sm:p-7">
                            <p class="text-xs text-white/70">Pelamar</p>
                            <p class="mt-1 text-lg font-semibold text-white">Apply lowongan + snapshot dokumen</p>
                            <p class="mt-2 text-sm text-white/70 max-w-xl">
                                CV dan surat lamaran tersimpan rapi per aplikasi, memudahkan HRD menilai dengan konsisten.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                    <div class="h-56 sm:h-64 bg-gradient-to-br from-gray-100 to-gray-200 relative">
                        <div class="absolute inset-x-0 bottom-0 p-6 sm:p-7">
                            <p class="text-xs text-gray-600">HRD</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900">Manajemen lowongan</p>
                            <p class="mt-2 text-sm text-gray-600">
                                Buat, edit, aktif/nonaktif, dan pantau jumlah pelamar secara ringkas.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                    <div class="h-56 sm:h-64 bg-gradient-to-br from-gray-100 to-gray-200 relative">
                        <div class="absolute inset-x-0 bottom-0 p-6 sm:p-7">
                            <p class="text-xs text-gray-600">Pelamar</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900">Timeline lamaran</p>
                            <p class="mt-2 text-sm text-gray-600">
                                Notifikasi & status yang jelas untuk pengalaman kandidat yang lebih baik.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 rounded-3xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                    <div class="h-56 sm:h-64 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-700 relative">
                        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_70%_30%,white,transparent_55%)]"></div>
                        <div class="absolute inset-x-0 bottom-0 p-6 sm:p-7">
                            <p class="text-xs text-white/70">Admin</p>
                            <p class="mt-1 text-lg font-semibold text-white">Verifikasi & moderasi</p>
                            <p class="mt-2 text-sm text-white/70 max-w-xl">
                                Kelola verifikasi perusahaan serta moderasi portofolio publik dengan alasan yang jelas.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-gray-200 bg-white shadow-sm p-6">
                    <div class="text-sm font-semibold text-gray-900">Notifikasi</div>
                    <div class="mt-2 text-sm text-gray-600">Update otomatis saat status berubah</div>
                    <div class="mt-4 text-xs text-gray-500">Lebih cepat, lebih transparan</div>
                </div>
            </div>

            <div id="fitur" class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="rounded-3xl border border-gray-200 bg-white shadow-sm p-6">
                    <p class="text-sm font-semibold text-gray-900">Pencarian lowongan relevan</p>
                    <p class="mt-2 text-sm text-gray-600">Filter lokasi/tipe/level/kategori/gaji untuk hasil yang tepat sasaran.</p>
                </div>
                <div class="rounded-3xl border border-gray-200 bg-white shadow-sm p-6">
                    <p class="text-sm font-semibold text-gray-900">Detail kandidat satu layar</p>
                    <p class="mt-2 text-sm text-gray-600">Profil, CV, dokumen, dan showcase tersaji rapi dan cepat dibaca.</p>
                </div>
                <div class="rounded-3xl border border-gray-200 bg-white shadow-sm p-6">
                    <p class="text-sm font-semibold text-gray-900">Kontrol & governance</p>
                    <p class="mt-2 text-sm text-gray-600">Verifikasi perusahaan, status aktif, dan moderasi konten publik.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="kontak" class="border-t border-gray-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="rounded-3xl border border-gray-200 bg-gray-50 shadow-sm p-8 sm:p-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h3 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900">Siap dipakai untuk rekrutmen yang lebih profesional</h3>
                    <p class="mt-2 text-sm sm:text-base text-gray-600 max-w-xl">
                        UI konsisten, data tersusun, dan alur yang jelas—agar pelamar nyaman dan HRD lebih cepat ambil keputusan.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    @auth
                        <a href="{{ $href('dashboard') }}"
                           class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-6 py-3 text-sm font-semibold text-white hover:bg-black transition shadow-sm">
                            Buka Dashboard
                        </a>
                    @else
                        <a href="{{ $href('register') }}"
                           class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-6 py-3 text-sm font-semibold text-white hover:bg-black transition shadow-sm">
                            Daftar Pelamar
                        </a>
                        <a href="{{ $href('perusahaan.register') }}"
                           class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-900 hover:bg-gray-50 transition">
                            Daftar Perusahaan
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="border-t border-gray-200 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 text-xs text-gray-500 flex flex-col sm:flex-row items-center justify-between gap-2">
        <p>© {{ date('Y') }} SIKAP. All rights reserved.</p>
        <p class="text-gray-400">Platform Karir & Rekrutmen</p>
    </div>
</footer>
</body>
</html>
