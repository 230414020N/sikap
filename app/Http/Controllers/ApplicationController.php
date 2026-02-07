<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationStatusHistory;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    public function applyForm(Job $job)
    {
        $profile = auth()->user()->pelamarProfile;

        $alreadyApplied = $job->applications()->where('user_id', auth()->id())->exists();
        abort_if($alreadyApplied, 403);

        // tampilkan info portofolio yang akan otomatis dilampirkan
        $portofolios = auth()->user()->portofolios()->latest()->get();

        return view('pelamar.applications.apply', compact('job', 'profile', 'portofolios'));
    }

    public function submit(Job $job, Request $request)
    {
        $alreadyApplied = $job->applications()->where('user_id', auth()->id())->exists();
        abort_if($alreadyApplied, 403);

        $request->validate([
            'catatan_pelamar' => ['nullable', 'string', 'max:2000'],
        ]);

        $profile = auth()->user()->pelamarProfile;

        // siapkan snapshot file dari profile
        $cvSnapshot = null;
        $suratSnapshot = null;

        try {
            if ($profile?->cv_path && Storage::exists($profile->cv_path)) {
                $cvSnapshot = 'snapshots/' . Str::uuid()->toString() . '_cv_' . basename($profile->cv_path);
                Storage::copy($profile->cv_path, $cvSnapshot);
            }

            if ($profile?->surat_lamaran_path && Storage::exists($profile->surat_lamaran_path)) {
                $suratSnapshot = 'snapshots/' . Str::uuid()->toString() . '_surat_' . basename($profile->surat_lamaran_path);
                Storage::copy($profile->surat_lamaran_path, $suratSnapshot);
            }

            $application = DB::transaction(function () use ($job, $request, $cvSnapshot, $suratSnapshot) {
                $app = Application::create([
                    'job_id' => $job->id,
                    'user_id' => auth()->id(),
                    'status' => 'Dikirim',
                    'catatan_pelamar' => $request->catatan_pelamar,
                    'cv_snapshot_path' => $cvSnapshot,
                    'surat_lamaran_snapshot_path' => $suratSnapshot,
                ]);

                // lampirkan semua portofolio pelamar secara otomatis
                $portfolioIds = auth()->user()->portofolios()->pluck('id')->all();
                $app->portofolios()->sync($portfolioIds);

                // history pertama
                ApplicationStatusHistory::create([
                    'application_id' => $app->id,
                    'status' => 'Dikirim',
                    'catatan_hrd' => null,
                    'updated_by' => null,
                ]);

                return $app;
            });

            return redirect()
                ->route('pelamar.applications.tracking')
                ->with('success', 'Lamaran berhasil dikirim!');

        } catch (\Throwable $e) {
            // cleanup snapshot kalau gagal insert
            if ($cvSnapshot && Storage::exists($cvSnapshot)) {
                Storage::delete($cvSnapshot);
            }
            if ($suratSnapshot && Storage::exists($suratSnapshot)) {
                Storage::delete($suratSnapshot);
            }

            throw $e;
        }
    }

    public function tracking()
    {
        $applications = Application::with(['job.company', 'histories.updater', 'portofolios'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(8);

        return view('pelamar.applications.tracking', compact('applications'));
    }

    public function show(Application $application)
    {
        abort_if($application->user_id !== auth()->id(), 403);

        $application->load(['job.company', 'histories.updater', 'portofolios']);

        return view('pelamar.applications.show', compact('application'));
    }
}
