{{-- @extends('layouts.app')

@section('content')
<style>
    /* Reset & Base Styles */
    body { background-color: #D1D1D1 !important; margin: 0; font-family: 'Inter', sans-serif; }
    
    .sikap-container { display: flex; min-height: 100vh; background-color: #D1D1D1; }

    /* Sidebar */
    .sikap-sidebar { width: 280px; padding: 40px 20px; flex-shrink: 0; display: flex; flex-direction: column; }
    .sikap-logo { font-size: 38px; font-weight: 900; letter-spacing: -2px; color: #111; margin-bottom: 50px; padding-left: 20px; }
    .nav-item { display: flex; align-items: center; gap: 15px; padding: 14px 20px; border-radius: 16px; color: #444; font-weight: 600; text-decoration: none; margin-bottom: 8px; transition: 0.3s; }
    .nav-item.active { background-color: #555555; color: white; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .nav-item:hover:not(.active) { background-color: rgba(0,0,0,0.05); }

    /* Main Content Area */
    .sikap-main { flex: 1; background-color: #4A4A4A; border-radius: 60px 0 0 60px; padding: 50px; margin-left: 0; box-shadow: -10px 0 30px rgba(0,0,0,0.2); }
    
    /* Header & Top Nav */
    .top-nav { display: flex; justify-content: flex-end; align-items: center; gap: 20px; color: white; margin-bottom: 40px; }
    .user-profile { display: flex; align-items: center; gap: 12px; font-weight: 500; }
    .avatar-circle { width: 40px; height: 40px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: black; font-weight: bold; }

    .welcome-text { color: white; margin-bottom: 40px; }
    .welcome-text h1 { font-size: 34px; font-weight: 800; margin: 0; letter-spacing: -0.5px; }
    .welcome-text p { font-size: 16px; opacity: 0.8; margin-top: 8px; }

    /* Dashboard Cards */
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
    .stat-card { border-radius: 24px; padding: 30px 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; border: 4px solid white; transition: transform 0.3s; }
    .stat-card:hover { transform: translateY(-5px); }
    .stat-card p { font-size: 14px; font-weight: 700; margin-bottom: 10px; }
    .stat-card h2 { font-size: 56px; font-weight: 900; margin: 0; }

    /* White Section (Graphics & Tables) */
    .content-card { background: white; border-radius: 40px; padding: 40px; margin-bottom: 30px; }
    .section-title { font-size: 18px; font-weight: 800; color: #111; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }

    /* Table Styles */
    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th { text-align: left; color: #999; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; padding: 15px; border-bottom: 1px solid #eee; }
    .custom-table td { padding: 20px 15px; border-bottom: 1px solid #f9f9f9; }
    
    .badge-status { padding: 6px 14px; border-radius: 12px; font-size: 11px; font-weight: 800; text-transform: uppercase; }

    /* Sidebar Footer */
    .sidebar-footer { margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(0,0,0,0.05); }
</style>

<div class="sikap-container">
    <aside class="sikap-sidebar">
        <div class="sikap-logo">SIKAP.</div>
        <nav>
            <a href="{{ route('hrd.dashboard') }}" class="nav-item active">
                <span>Dashboard</span>
            </a>
            <a href="#" class="nav-item">
                <span>Profile</span>
            </a>
            <a href="#" class="nav-item">
                <span>Kelola Akun HRD</span>
            </a>
            <a href="{{ route('hrd.jobs.index') }}" class="nav-item">
                <span>Lowongan</span>
            </a>
            <a href="{{ route('hrd.applications.index') }}" class="nav-item">
                <span>Laporan Rekrutmen</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-item" style="width: 100%; background: none; border: none; cursor: pointer; text-align: left;">
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="sikap-main">
        <div class="top-nav">
            <div class="user-profile">
                <span>(nama perusahaan)</span>
                <div class="avatar-circle">P</div>
            </div>
        </div>

        <div class="welcome-text">
            <h1>Selamat datang, (nama perusahaan)!</h1>
            <p>Mari kelola dan pantau proses rekrutmen Anda dengan praktis.</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card" style="background-color: #BDE3FF; color: #0077CC;">
                <p>Lowongan Aktif</p>
                <h2>{{ (int) $jobCount }}</h2>
            </div>
            <div class="stat-card" style="background-color: #FFEDC2; color: #D4A017;">
                <p>Lamaran Masuk</p>
                <h2>{{ (int) $applicationCount }}</h2>
            </div>
            <div class="stat-card" style="background-color: #D1FFD6; color: #28A745;">
                <p>Diterima</p>
                <h2>0</h2>
            </div>
            <div class="stat-card" style="background-color: #FFD1D1; color: #DC3545;">
                <p>Ditolak</p>
                <h2>0</h2>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1.2fr; gap: 25px;">
            <div class="content-card">
                <div class="section-title">
                    <span>Lamaran Terbaru</span>
                    <a href="{{ route('hrd.applications.index') }}" style="font-size: 14px; color: #555; text-decoration: underline;">Lihat Semua</a>
                </div>
                
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Kandidat</th>
                            <th>Lowongan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestApplications as $app)
                        <tr>
                            <td>
                                <div style="font-weight: 800; color: #111;">{{ $app->user?->name ?? 'Pelamar' }}</div>
                                <div style="font-size: 11px; color: #999;">{{ optional($app->created_at)->format('d M Y') }}</div>
                            </td>
                            <td style="font-weight: 600; color: #444;">{{ $app->job?->judul ?? 'Lowongan' }}</td>
                            <td>
                                <span class="badge-status" style="background: #eee; color: #666;">
                                    {{ $app->status ?? 'Masuk' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('hrd.applications.show', $app->id) }}" style="font-weight: 800; color: #111; text-decoration: none; border-bottom: 2px solid #111;">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 40px; color: #999;">Belum ada lamaran masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="content-card">
                <div class="section-title">Aksi Cepat</div>
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <a href="{{ route('hrd.jobs.create') }}" style="background: #111; color: white; padding: 20px; border-radius: 20px; text-decoration: none; text-align: center; font-weight: 800;">
                        + Buat Lowongan Baru
                    </a>
                    <div style="padding: 20px; border: 2px dashed #ddd; border-radius: 20px; text-align: center;">
                        <p style="font-size: 12px; color: #999; margin-bottom: 10px;">Status Profil Perusahaan</p>
                        <span style="background: #28A745; color: white; padding: 5px 15px; border-radius: 10px; font-size: 10px; font-weight: 900;">AKTIF</span>
                    </div>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 40px; color: rgba(255,255,255,0.3); font-size: 12px;">
            &copy; 2025, Sistem Informasi Karier dan Portofolio (SIKAP)
        </div>
    </main>
</div>
@endsection --}}
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-10 text-white">
        <h1 class="text-4xl font-black tracking-tight italic mb-2 uppercase">
            Selamat datang, {{ auth()->user()->name }}!
        </h1>
        <p class="text-gray-400 font-medium text-lg">Mari kelola dan pantau proses rekrutmen Anda dengan praktis.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-[#BDE3FF] border-[4px] border-white rounded-[35px] p-8 shadow-xl transform transition hover:scale-105">
            <p class="text-[#005696] font-black text-xs uppercase tracking-widest mb-4">Lowongan Aktif</p>
            <h2 class="text-7xl font-[1000] text-[#005696] leading-none">{{ $jobCount }}</h2>
        </div>

        <div class="bg-[#FFEDC2] border-[4px] border-white rounded-[35px] p-8 shadow-xl transform transition hover:scale-105">
            <p class="text-[#916A08] font-black text-xs uppercase tracking-widest mb-4">Lamaran Masuk</p>
            <h2 class="text-7xl font-[1000] text-[#916A08] leading-none">{{ $applicationCount }}</h2>
        </div>

        <div class="bg-[#D1FFD6] border-[4px] border-white rounded-[35px] p-8 shadow-xl transform transition hover:scale-105">
            <p class="text-[#1E7E34] font-black text-xs uppercase tracking-widest mb-4">Diterima</p>
            <h2 class="text-7xl font-[1000] text-[#1E7E34] leading-none">30</h2>
        </div>

        <div class="bg-[#FFD1D1] border-[4px] border-white rounded-[35px] p-8 shadow-xl transform transition hover:scale-105">
            <p class="text-[#A91E2C] font-black text-xs uppercase tracking-widest mb-4">Ditolak</p>
            <h2 class="text-7xl font-[1000] text-[#A91E2C] leading-none">10</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-8 bg-white rounded-[45px] p-10 shadow-2xl">
            <div class="mb-8">
                <h3 class="text-xl font-black text-black uppercase tracking-tight">Rekapitulasi Terbaru</h3>
                <p class="text-gray-400 text-sm font-bold">Tren jumlah lamaran masuk dan perbandingan status kandidat.</p>
            </div>
            
            <div class="w-full bg-gray-50 rounded-[30px] border-2 border-dashed border-gray-200 flex flex-col items-center justify-center p-12 min-h-[350px]">
                <div class="flex gap-4 items-end mb-6">
                    <div class="w-12 bg-blue-400 rounded-t-lg h-32"></div>
                    <div class="w-12 bg-blue-600 rounded-t-lg h-48"></div>
                    <div class="w-12 bg-blue-300 rounded-t-lg h-20"></div>
                </div>
                <p class="font-black italic text-gray-400 text-center">
                    Visualisasi Statistik Rekrutmen<br>
                    <span class="text-[10px] uppercase tracking-[0.2em] not-italic opacity-50">Data Real-time akan dimuat di sini</span>
                </p>
            </div>
        </div>

        <div class="lg:col-span-4 bg-white rounded-[45px] p-10 shadow-2xl flex flex-col">
            <div class="mb-8">
                <h3 class="text-xl font-black text-black uppercase tracking-tight">Status Lowongan</h3>
                <p class="text-gray-400 text-sm font-bold">Pantau publikasi Anda.</p>
            </div>
            
            <div class="flex-1 space-y-6">
                @php
                    $jobs = [
                        ['title' => 'Software Engineer', 'status' => 'Aktif', 'bg' => 'bg-green-500'],
                        ['title' => 'UI/UX Designer', 'status' => 'Aktif', 'bg' => 'bg-green-500'],
                        ['title' => 'Digital Marketing', 'status' => 'Non-Aktif', 'bg' => 'bg-red-500'],
                        ['title' => 'Data Analyst', 'status' => 'Aktif', 'bg' => 'bg-green-500'],
                    ];
                @endphp

                @foreach($jobs as $j)
                <div class="flex justify-between items-center pb-4 border-b border-gray-100 last:border-0">
                    <span class="font-black text-gray-800 text-sm uppercase tracking-tighter">{{ $j['title'] }}</span>
                    <span class="{{ $j['bg'] }} text-white px-4 py-1.5 rounded-xl text-[9px] font-black uppercase shadow-sm">
                        {{ $j['status'] }}
                    </span>
                </div>
                @endforeach
            </div>

            <div class="mt-10">
                <a href="{{ route('hrd.jobs.create') }}" class="group flex items-center justify-center gap-3 w-full bg-black text-white py-5 rounded-[22px] font-black text-xs tracking-widest hover:bg-gray-800 transition-all shadow-xl">
                    <span>+</span> BUAT LOWONGAN BARU
                </a>
            </div>
        </div>

    </div>

    <div class="mt-16 mb-4 text-center">
        <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.4em]">
            &copy; 2025 SIKAP • Sistem Informasi Karier dan Portofolio
        </p>
    </div>
</div>

<style>
    /* Mengoptimalkan ketebalan font untuk look premium */
    h2 { font-family: 'Inter', sans-serif; letter-spacing: -3px; }
    h3 { letter-spacing: -0.5px; }
</style>
@endsection