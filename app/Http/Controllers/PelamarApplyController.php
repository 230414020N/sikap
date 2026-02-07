<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PelamarApplyController extends Controller
{
    public function store(Request $request, Job $job)
    {
        abort_if(!$job->is_active, 404);

        $validated = $request->validate([
            'catatan_pelamar' => ['nullable', 'string', 'max:2000'],
        ]);

        $already = Application::query()
            ->where('job_id', $job->id)
            ->where('pelamar_id', auth()->id())
            ->exists();

        abort_if($already, 422);

        $profile = auth()->user()->pelamarProfile;

        $application = Application::create([
            'job_id' => $job->id,
            'pelamar_id' => auth()->id(),
            'status' => 'Dikirim',
            'catatan_pelamar' => $validated['catatan_pelamar'] ?? null,
            'cv_snapshot_path' => $profile?->cv_path,
            'surat_lamaran_snapshot_path' => $profile?->surat_lamaran_path,
        ]);

        $this->snapshotPortofolios($application);

        return redirect()
            ->route('pelamar.applications.show', $application->id)
            ->with('success', 'Lamaran berhasil dikirim.');
    }

    private function snapshotPortofolios(Application $application): void
    {
        if ($application->portofolios()->exists()) {
            return;
        }

        $items = auth()->user()->portofolios()->get();

        if ($items->isEmpty()) {
            return;
        }

        $payload = [];

        foreach ($items as $p) {
            $thumb = $this->copyPublicFile($p->thumbnail_path, 'applications/' . $application->id . '/portofolios');

            $payload[] = [
                'judul' => $p->judul,
                'kategori' => $p->kategori,
                'tools' => $p->tools,
                'deskripsi' => $p->deskripsi,
                'link_demo' => $p->link_demo,
                'link_github' => $p->link_github,
                'thumbnail_path' => $thumb,
            ];
        }

        $application->portofolios()->createMany($payload);
    }

    private function copyPublicFile(?string $path, string $destDir): ?string
    {
        if (!$path) {
            return null;
        }

        $path = ltrim($path, '/');
        if (Str::startsWith($path, 'public/')) {
            $path = Str::after($path, 'public/');
        }

        if (!Storage::disk('public')->exists($path)) {
            return $path;
        }

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $name = (string) Str::uuid();
        $dest = rtrim($destDir, '/') . '/' . $name . ($ext ? '.' . $ext : '');

        Storage::disk('public')->copy($path, $dest);

        return $dest;
    }
}
