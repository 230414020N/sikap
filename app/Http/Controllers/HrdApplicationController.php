<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationStatusHistory;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HrdApplicationController extends Controller
{
    public function index(Request $request)
    {
        $companyId = auth()->user()->company_id;

        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'status' => ['nullable', 'string', 'max:50'],
            'pendidikan' => ['nullable', 'string', 'max:100'],
            'jurusan' => ['nullable', 'string', 'max:100'],
            'institusi' => ['nullable', 'string', 'max:120'],
            'tahun_lulus' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'pengalaman' => ['nullable', 'string', 'max:120'],
            'job_id' => ['nullable', 'integer', 'min:1'],
            'sort' => ['nullable', 'in:latest,oldest'],
        ]);

        if (!empty($validated['job_id'])) {
            $owned = Job::query()
                ->where('id', $validated['job_id'])
                ->where('company_id', $companyId)
                ->exists();

            abort_if(!$owned, 404);
        }

        $query = Application::query()
            ->with(['job.company', 'pelamar.pelamarProfile', 'pelamar.portofolios'])
            ->whereHas('job', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });

        if (!empty($validated['job_id'])) {
            $query->where('job_id', $validated['job_id']);
        }

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        if (!empty($validated['pendidikan'])) {
            $like = '%' . $this->escapeLike($validated['pendidikan']) . '%';
            $query->whereHas('pelamar', function ($u) use ($like) {
                $u->whereHas('pelamarProfile', function ($p) use ($like) {
                    $p->where('pendidikan_terakhir', 'like', $like);
                });
            });
        }

        if (!empty($validated['jurusan'])) {
            $like = '%' . $this->escapeLike($validated['jurusan']) . '%';
            $query->whereHas('pelamar', function ($u) use ($like) {
                $u->whereHas('pelamarProfile', function ($p) use ($like) {
                    $p->where('jurusan', 'like', $like);
                });
            });
        }

        if (!empty($validated['institusi'])) {
            $like = '%' . $this->escapeLike($validated['institusi']) . '%';
            $query->whereHas('pelamar', function ($u) use ($like) {
                $u->whereHas('pelamarProfile', function ($p) use ($like) {
                    $p->where('institusi', 'like', $like);
                });
            });
        }

        if (!empty($validated['tahun_lulus'])) {
            $query->whereHas('pelamar', function ($u) use ($validated) {
                $u->whereHas('pelamarProfile', function ($p) use ($validated) {
                    $p->where('tahun_lulus', $validated['tahun_lulus']);
                });
            });
        }

        if (!empty($validated['pengalaman'])) {
            $like = '%' . $this->escapeLike($validated['pengalaman']) . '%';
            $query->where(function ($outer) use ($like) {
                $outer->whereHas('pelamar', function ($u) use ($like) {
                    $u->whereHas('pelamarProfile', function ($p) use ($like) {
                        $p->where('bio', 'like', $like);
                    });
                })->orWhereHas('pelamar', function ($u) use ($like) {
                    $u->whereHas('portofolios', function ($p) use ($like) {
                        $p->where('judul', 'like', $like)
                            ->orWhere('deskripsi', 'like', $like)
                            ->orWhere('tools', 'like', $like)
                            ->orWhere('kategori', 'like', $like);
                    });
                });
            });
        }

        if (!empty($validated['q'])) {
            $terms = preg_split('/\s+/', trim($validated['q'])) ?: [];

            $query->where(function ($outer) use ($terms) {
                foreach ($terms as $term) {
                    if ($term === '') {
                        continue;
                    }

                    $like = '%' . $this->escapeLike($term) . '%';

                    $outer->where(function ($sub) use ($like) {
                        $sub->whereHas('pelamar', function ($u) use ($like) {
                            $u->where('name', 'like', $like)
                                ->orWhere('email', 'like', $like);
                        })->orWhereHas('pelamar', function ($u) use ($like) {
                            $u->whereHas('pelamarProfile', function ($p) use ($like) {
                                $p->where('nama_lengkap', 'like', $like)
                                    ->orWhere('pendidikan_terakhir', 'like', $like)
                                    ->orWhere('jurusan', 'like', $like)
                                    ->orWhere('institusi', 'like', $like)
                                    ->orWhere('bio', 'like', $like);
                            });
                        })->orWhereHas('job', function ($j) use ($like) {
                            $j->where('judul', 'like', $like);
                        })->orWhereHas('pelamar', function ($u) use ($like) {
                            $u->whereHas('portofolios', function ($p) use ($like) {
                                $p->where('judul', 'like', $like)
                                    ->orWhere('deskripsi', 'like', $like)
                                    ->orWhere('tools', 'like', $like)
                                    ->orWhere('kategori', 'like', $like);
                            });
                        });
                    });
                }
            });
        }

        $sort = $validated['sort'] ?? 'latest';
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $applications = $query->paginate(10)->withQueryString();

        $jobs = Job::query()
            ->where('company_id', $companyId)
            ->orderBy('judul')
            ->get(['id', 'judul']);

        $statusOptions = Application::query()
            ->whereHas('job', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })
            ->select('status')
            ->distinct()
            ->orderBy('status')
            ->pluck('status');

        return view('hrd.applications.index', compact('applications', 'jobs', 'statusOptions'));
    }

    public function indexByJob(Request $request, Job $job)
    {
        abort_if($job->company_id !== auth()->user()->company_id, 404);

        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'status' => ['nullable', 'string', 'max:50'],
            'pendidikan' => ['nullable', 'string', 'max:100'],
            'jurusan' => ['nullable', 'string', 'max:100'],
            'institusi' => ['nullable', 'string', 'max:120'],
            'tahun_lulus' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'pengalaman' => ['nullable', 'string', 'max:120'],
            'sort' => ['nullable', 'in:latest,oldest'],
        ]);

        $query = Application::query()
            ->with(['job.company', 'pelamar.pelamarProfile', 'pelamar.portofolios'])
            ->where('job_id', $job->id);

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        if (!empty($validated['pendidikan'])) {
            $like = '%' . $this->escapeLike($validated['pendidikan']) . '%';
            $query->whereHas('pelamar', function ($u) use ($like) {
                $u->whereHas('pelamarProfile', function ($p) use ($like) {
                    $p->where('pendidikan_terakhir', 'like', $like);
                });
            });
        }

        if (!empty($validated['jurusan'])) {
            $like = '%' . $this->escapeLike($validated['jurusan']) . '%';
            $query->whereHas('pelamar', function ($u) use ($like) {
                $u->whereHas('pelamarProfile', function ($p) use ($like) {
                    $p->where('jurusan', 'like', $like);
                });
            });
        }

        if (!empty($validated['institusi'])) {
            $like = '%' . $this->escapeLike($validated['institusi']) . '%';
            $query->whereHas('pelamar', function ($u) use ($like) {
                $u->whereHas('pelamarProfile', function ($p) use ($like) {
                    $p->where('institusi', 'like', $like);
                });
            });
        }

        if (!empty($validated['tahun_lulus'])) {
            $query->whereHas('pelamar', function ($u) use ($validated) {
                $u->whereHas('pelamarProfile', function ($p) use ($validated) {
                    $p->where('tahun_lulus', $validated['tahun_lulus']);
                });
            });
        }

        if (!empty($validated['pengalaman'])) {
            $like = '%' . $this->escapeLike($validated['pengalaman']) . '%';
            $query->where(function ($outer) use ($like) {
                $outer->whereHas('pelamar', function ($u) use ($like) {
                    $u->whereHas('pelamarProfile', function ($p) use ($like) {
                        $p->where('bio', 'like', $like);
                    });
                })->orWhereHas('pelamar', function ($u) use ($like) {
                    $u->whereHas('portofolios', function ($p) use ($like) {
                        $p->where('judul', 'like', $like)
                            ->orWhere('deskripsi', 'like', $like)
                            ->orWhere('tools', 'like', $like)
                            ->orWhere('kategori', 'like', $like);
                    });
                });
            });
        }

        if (!empty($validated['q'])) {
            $terms = preg_split('/\s+/', trim($validated['q'])) ?: [];

            $query->where(function ($outer) use ($terms) {
                foreach ($terms as $term) {
                    if ($term === '') {
                        continue;
                    }

                    $like = '%' . $this->escapeLike($term) . '%';

                    $outer->where(function ($sub) use ($like) {
                        $sub->whereHas('pelamar', function ($u) use ($like) {
                            $u->where('name', 'like', $like)
                                ->orWhere('email', 'like', $like);
                        })->orWhereHas('pelamar', function ($u) use ($like) {
                            $u->whereHas('pelamarProfile', function ($p) use ($like) {
                                $p->where('nama_lengkap', 'like', $like)
                                    ->orWhere('pendidikan_terakhir', 'like', $like)
                                    ->orWhere('jurusan', 'like', $like)
                                    ->orWhere('institusi', 'like', $like)
                                    ->orWhere('bio', 'like', $like);
                            });
                        })->orWhereHas('pelamar', function ($u) use ($like) {
                            $u->whereHas('portofolios', function ($p) use ($like) {
                                $p->where('judul', 'like', $like)
                                    ->orWhere('deskripsi', 'like', $like)
                                    ->orWhere('tools', 'like', $like)
                                    ->orWhere('kategori', 'like', $like);
                            });
                        });
                    });
                }
            });
        }

        $sort = $validated['sort'] ?? 'latest';
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $applications = $query->paginate(10)->withQueryString();

        $statusOptions = Application::query()
            ->where('job_id', $job->id)
            ->select('status')
            ->distinct()
            ->orderBy('status')
            ->pluck('status');

        $jobs = Job::query()
            ->where('company_id', auth()->user()->company_id)
            ->orderBy('judul')
            ->get(['id', 'judul']);

        return view('hrd.applications.by_job', compact('job', 'applications', 'statusOptions', 'jobs'));
    }

    public function show(Application $application)
    {
        $application->loadMissing('job');
        abort_if($application->job->company_id !== auth()->user()->company_id, 403);

        $application->load([
            'job.company',
            'pelamar.pelamarProfile',
            'pelamar.portofolios',
            'histories.updater',
            'portofolios',
            'internalNotes.creator'
        ]);

        return view('hrd.applications.show', compact('application'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        $application->loadMissing('job', 'pelamar');
        abort_if($application->job->company_id !== auth()->user()->company_id, 403);

        $validated = $request->validate([
            'status' => ['required', 'string', 'max:50'],
            'catatan_hrd' => ['nullable', 'string', 'max:2000'],
        ]);

        $application->update([
            'status' => $validated['status'],
        ]);

        ApplicationStatusHistory::create([
            'application_id' => $application->id,
            'status' => $validated['status'],
            'catatan_hrd' => $validated['catatan_hrd'] ?? null,
            'updated_by' => auth()->id(),
        ]);

        $application->pelamar->notify(
            new \App\Notifications\ApplicationStatusUpdated(
                $application->job->judul,
                $validated['status'],
                $validated['catatan_hrd'] ?? null
            )
        );

        return back()->with('success', 'Status lamaran diperbarui!');
    }

    public function downloadCv(Application $application)
    {
        $application->loadMissing('job', 'pelamar.pelamarProfile');
        abort_if($application->job->company_id !== auth()->user()->company_id, 403);

        $path = $application->cv_snapshot_path ?: ($application->pelamar->pelamarProfile->cv_path ?? null);
        abort_if(!$path || !Storage::exists($path), 404);

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $name = 'CV - ' . $application->pelamar->name . ($ext ? '.' . $ext : '');

        return Storage::download($path, $name);
    }

    public function downloadSurat(Application $application)
    {
        $application->loadMissing('job', 'pelamar.pelamarProfile');
        abort_if($application->job->company_id !== auth()->user()->company_id, 403);

        $path = $application->surat_lamaran_snapshot_path ?: ($application->pelamar->pelamarProfile->surat_lamaran_path ?? null);
        abort_if(!$path || !Storage::exists($path), 404);

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $name = 'Surat Lamaran - ' . $application->pelamar->name . ($ext ? '.' . $ext : '');

        return Storage::download($path, $name);
    }

    private function escapeLike(string $value): string
    {
        return addcslashes($value, "\\%_");
    }
}
