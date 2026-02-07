<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>SIKAP • Platform Karir & Rekrutmen</title>

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
            rel="stylesheet"
        />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            [x-cloak] {
                display: none !important;
            }
            body {
                font-family: "Plus Jakarta Sans", sans-serif;
            }
        </style>
    </head>
    @php $href = function (string $name, array $params = [], string $fallback = '#') { return
    \Illuminate\Support\Facades\Route::has($name) ? route($name, $params) : $fallback; }; $logoSrc =
    asset('images/logo.png'); $topNav = [ ['label' => 'Fitur', 'href' => '#fitur'], ['label' => 'Modul', 'href' =>
    '#modul'], ['label' => 'Kontak', 'href' => '#kontak'], ]; $loginLinks = [ ['label' => 'Masuk sebagai Pelamar',
    'href' => $href('login.pelamar')], ['label' => 'Masuk sebagai HRD', 'href' => $href('login.hrd')], ['label' =>
    'Masuk sebagai Perusahaan', 'href' => $href('login.perusahaan')], ]; @endphp
    <body class="bg-white text-gray-900 antialiased">
        <header x-data="{ open:false, dropdown:false }" class="bg-white border-b border-gray-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="h-20 flex items-center justify-between">
                    <a href="{{ $href('home', [], url('/')) }}" class="flex items-center">
                        <img src="{{ $logoSrc }}" alt="SIKAP." class="h-8 w-auto" />
                    </a>

                    <div class="flex items-center gap-6">
                        <div class="hidden md:flex items-center gap-2 text-sm font-medium text-gray-700">
                            <span class="text-lg">❓</span>
                            <div class="relative" @click.away="dropdown = false">
                                <button @click="dropdown = !dropdown" class="hover:underline">
                                    Registrasi / Masuk
                                </button>

                                <div
                                    x-show="dropdown"
                                    x-cloak
                                    class="absolute right-0 mt-3 w-56 bg-white border border-gray-100 shadow-xl rounded-lg overflow-hidden py-2"
                                >
                                    @guest @foreach($loginLinks as $l)
                                    <a
                                        href="{{ $l['href'] }}"
                                        class="block px-4 py-2 text-xs hover:bg-gray-50 transition"
                                        >{{ $l['label'] }}</a
                                    >
                                    @endforeach
                                    <div class="border-t border-gray-50 mt-2 pt-2">
                                        <a
                                            href="{{ $href('register') }}"
                                            class="block px-4 py-2 text-xs font-bold text-gray-900"
                                            >Daftar Pelamar</a
                                        >
                                    </div>
                                    @else
                                    <a href="{{ $href('dashboard') }}" class="block px-4 py-2 text-xs font-bold"
                                        >Dashboard</a
                                    >
                                    @endguest
                                </div>
                            </div>
                        </div>

                        <a
                            href="{{ $href('perusahaan.register') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2 rounded-md text-sm font-medium transition"
                        >
                            Untuk Perusahaan
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <section class="bg-[#4a4a4a] relative min-h-[500px] flex items-center overflow-hidden">
                <div class="max-w-7xl mx-auto px-6 lg:px-8 w-full grid grid-cols-1 lg:grid-cols-2 items-center">
                    <div class="z-10 py-20">
                        <h2 class="text-white text-xl md:text-2xl font-light mb-2">
                            Bangun Karier Lebih Terarah Dengan
                        </h2>
                        <h1 class="text-white text-7xl md:text-9xl font-bold tracking-tighter">SIKAP.</h1>
                    </div>

                    <div class="hidden lg:block absolute right-0 bottom-0 h-full w-1/2">
                        <img
                            src="{{ asset('images/hero-img.png') }}"
                            alt="Karier"
                            class="h-full w-full object-contain object-bottom"
                        />
                    </div>
                </div>
            </section>

            <section class="bg-white py-24 border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                        <div>
                            <h2 class="text-8xl font-bold tracking-tighter leading-none mb-4">SIKAP.</h2>
                            <div
                                class="flex justify-between text-[10px] font-bold tracking-widest text-gray-500 uppercase"
                            >
                                <span>JOB FINDER</span>
                                <span>SINCE 2025</span>
                            </div>

                            <p class="mt-12 text-gray-700 text-lg leading-relaxed max-w-md">
                                SIKAP adalah sistem informasi karier dan portofolio berbasis web sebagai layanan
                                berbasis software yang berfokus pada pengelolaan karier dan proses rekrutmen.
                            </p>
                        </div>

                        <div class="lg:pl-20">
                            <h3 class="text-3xl font-bold mb-8">Tentang Kami</h3>
                            <ul class="space-y-4 text-gray-600">
                                <li><a href="#kontak" class="hover:text-black transition">Hubungi Kami</a></li>
                                {{-- <li><a href="#" class="hover:text-black transition">Pusat Bantuan</a></li> --}}
                                <li><a href="#" class="hover:text-black transition">Logo</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <section id="modul" class="bg-white py-20">
                <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
                    <h2 class="text-3xl font-bold mb-12">Modul & Fitur Utama</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                        <div class="p-8 border border-gray-100 rounded-2xl hover:shadow-lg transition">
                            <h4 class="font-bold mb-2">Tracking Jelas</h4>
                            <p class="text-sm text-gray-500">
                                Status & timeline lamaran yang transparan bagi setiap pelamar.
                            </p>
                        </div>
                        <div class="p-8 border border-gray-100 rounded-2xl hover:shadow-lg transition">
                            <h4 class="font-bold mb-2">Dokumen Rapi</h4>
                            <p class="text-sm text-gray-500">
                                Snapshot CV & surat lamaran tersimpan aman per aplikasi.
                            </p>
                        </div>
                        <div class="p-8 border border-gray-100 rounded-2xl hover:shadow-lg transition">
                            <h4 class="font-bold mb-2">Verifikasi Admin</h4>
                            <p class="text-sm text-gray-500">
                                Moderasi portofolio publik untuk menjaga kualitas konten.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-white py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 flex justify-center items-center">
                <div class="flex items-center gap-2 text-sm font-medium text-gray-800">
                    <div
                        class="w-6 h-6 border-2 border-black rounded-full flex items-center justify-center font-bold text-[10px]"
                    >
                        C
                    </div>
                    <span>2025, Sistem Informasi Karier dan Portofolio</span>
                </div>
            </div>
        </footer>
    </body>
</html>
