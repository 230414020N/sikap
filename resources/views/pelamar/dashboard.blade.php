@extends('layouts.app')

@section('content')
    @php
        // LOGIC & ROUTES TETAP SAMA (TIDAK DIUBAH)
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

        // Mapping Menu ke Ikon sesuai gambar
        $menuItems = [
            ['label' => 'Dashboard', 'href' => $routes['dashboard'], 'active' => 'dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
            ['label' => 'Profile', 'href' => $routes['profile_docs'], 'active' => 'pelamar.profile.*', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
            ['label' => 'Dokumen', 'href' => $routes['account'], 'active' => 'profile.*', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
            ['label' => 'Project', 'href' => $routes['portofolio'], 'active' => 'pelamar.portofolio.*', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
            ['label' => 'Lamaran', 'href' => $routes['tracking'], 'active' => 'pelamar.applications.*', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ];

        $applicationCountValue = (int) ($applicationCount ?? 0);
    @endphp

    <div class="flex min-h-screen bg-[#E5E5E5]">
        <aside class="w-64 bg-[#F2F2F2] border-r border-gray-300 flex flex-col justify-between">
            <div>
                <div class="p-8">
                    <img src="{{ asset('images/logo.png') }}" alt="SIKAP" class="h-8"> </div>
                
                <nav class="mt-4 px-4 space-y-2">
                    @foreach($menuItems as $item)
                        @php $isActive = request()->routeIs($item['active']); @endphp
                        <a href="{{ $item['href'] }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ $isActive ? 'bg-[#555555] text-white shadow-md' : 'text-gray-700 hover:bg-gray-200' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                            </svg>
                            <span class="font-medium">{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="p-4 border-t border-gray-300">
                <form method="POST" action="{{ $routes['logout'] }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-xl transition font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1">
            <header class="bg-white p-4 flex justify-between items-center px-8 border-b border-gray-200">
                <div class="relative w-96">
                    <input type="text" placeholder="Cari Lowongan Pekerjaan" 
                           class="w-full bg-[#D9D9D9] rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400">
                </div>
                <div class="flex items-center gap-6">
                    <button class="relative text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full"></span>
                    </button>
                    <div class="flex items-center gap-2">
                        <span class="font-medium text-gray-800">{{ auth()->user()->name }}</span>
                        <div class="h-8 w-8 bg-gray-300 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>
                </div>
            </header>

            <div class="p-8 bg-[#444444] min-h-[calc(100vh-73px)]">
                <div class="mb-8">
                    <h1 class="text-white text-3xl font-bold italic">Halo, {{ auth()->user()->name }}!</h1>
                    <p class="text-gray-300">Semoga harimu menyenangkan dan semoga segera mendapatkan pekerjaan terbaik.</p>
                </div>

                <div class="bg-white rounded-2xl p-8 mb-6 shadow-lg">
                    <h2 class="font-bold text-lg mb-6">Statistik Lamaran</h2>
                    <div class="flex justify-center gap-12 text-center">
                        <div>
                            <div class="w-16 h-16 bg-[#3498DB] text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-2">{{ $applicationCountValue }}</div>
                            <p class="text-gray-700 font-medium">Dikirim</p>
                        </div>
                        <div>
                            <div class="w-16 h-16 bg-[#52C41A] text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-2">3</div>
                            <p class="text-gray-700 font-medium">Diterima</p>
                        </div>
                        <div>
                            <div class="w-16 h-16 bg-[#FADB14] text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-2">2</div>
                            <p class="text-gray-700 font-medium">Interview</p>
                        </div>
                        <div>
                            <div class="w-16 h-16 bg-[#FF4D4F] text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-2">2</div>
                            <p class="text-gray-700 font-medium">Ditolak</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-8 mb-6 shadow-lg">
                    <h2 class="font-bold text-lg mb-6">Status Lamaran Terbaru</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-center border-collapse">
                            <thead>
                                <tr class="border-b border-gray-300">
                                    <th class="py-3 font-semibold text-gray-700 border-r border-gray-300 px-4">Perusahaan</th>
                                    <th class="py-3 font-semibold text-gray-700 border-r border-gray-300 px-4">Posisi</th>
                                    <th class="py-3 font-semibold text-gray-700 border-r border-gray-300 px-4">Status</th>
                                    <th class="py-3 font-semibold text-gray-700 px-4">Waktu</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse(($latestApplications ?? []) as $app)
                                    <tr>
                                        <td class="py-4 border-r border-gray-200">{{ $app->job?->company?->name ?? 'PT ABC Bandung' }}</td>
                                        <td class="py-4 border-r border-gray-200">{{ $app->job?->judul ?? 'Back End Developer' }}</td>
                                        <td class="py-4 border-r border-gray-200">{{ $app->status ?? 'Ditolak' }}</td>
                                        <td class="py-4 text-gray-500">{{ $app->created_at?->diffForHumans() ?? '30 Menit lalu' }}</td>
                                    </tr>
                                @empty
                                    <tr><td class="py-4 border-r border-gray-200 px-4">PT ABC Bandung</td><td class="py-4 border-r border-gray-200 px-4">Back End Developer</td><td class="py-4 border-r border-gray-200 px-4">Ditolak</td><td class="py-4 px-4">30 Menit lalu</td></tr>
                                    <tr><td class="py-4 border-r border-gray-200 px-4">PT DGC Karawang</td><td class="py-4 border-r border-gray-200 px-4">UI/UX Designer</td><td class="py-4 border-r border-gray-200 px-4">Interview</td><td class="py-4 px-4">1 Jam lalu</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-lg">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-bold text-lg">Project Showcase Terbaru</h2>
                        <a href="{{ $routes['portofolio'] }}" class="text-blue-600 text-sm hover:underline">Lihat Semua</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach(['A', 'B', 'C'] as $idx)
                        <div class="bg-[#555555] rounded-xl p-4 text-center text-white">
                            <div class="bg-gray-200 rounded-lg h-40 mb-4 overflow-hidden flex items-center justify-center">
                                <img src="https://via.placeholder.com/300x200" alt="Project" class="object-cover w-full">
                            </div>
                            <p class="font-bold mb-1">PROJECT {{ $idx }}</p>
                            <div class="flex items-center justify-center gap-1 text-sm">
                                <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                                {{ rand(15, 25) }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <footer class="mt-8 text-center text-gray-400 text-sm">
                    <p>&copy; 2025, Sistem Informasi Karier dan Portofolio</p>
                </footer>
            </div>
        </main>
    </div>
@endsection