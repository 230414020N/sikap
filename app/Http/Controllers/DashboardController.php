<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Portofolio;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'perusahaan') {
            return redirect()->route('perusahaan.dashboard');
        }

        if ($user->role === 'hrd') {
            return redirect()->route('hrd.jobs.dashboard');
        }

        $profile = $user->pelamarProfile;
        $profileComplete = (bool) ($profile?->cv_path && $profile?->surat_lamaran_path);

        $portofolioCount = Portofolio::query()
            ->where('user_id', $user->id)
            ->count();

        $applicationCount = Application::query()
            ->where('user_id', $user->id)
            ->count();

        $latestApplications = Application::query()
            ->with(['job:id,company_id,judul,lokasi,tipe,level,kategori,deadline', 'job.company:id,nama'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('pelamar.dashboard', compact(
            'profileComplete',
            'portofolioCount',
            'applicationCount',
            'latestApplications'
        ));
    }
}
