<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobBrowseController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'q'        => ['nullable', 'string', 'max:100'],
            'lokasi'   => ['nullable', 'string', 'max:100'],
            'tipe'     => ['nullable', 'in:Full-time,Part-time,Internship'],
            'level'    => ['nullable', 'in:Junior,Mid,Senior'],
            'kategori' => ['nullable', 'in:Web,Mobile,UI/UX,Data,Design'],
            'gaji_min' => ['nullable', 'integer', 'min:0'],
            'gaji_max' => ['nullable', 'integer', 'min:0'],
            'sort'     => ['nullable', 'in:latest,deadline'],
        ]);

        // Base query
        $query = Job::query()
            ->select([
                'id',
                'company_id',
                'judul',
                'lokasi',
                'tipe',
                'level',
                'kategori',
                'gaji_min',
                'gaji_max',
                'deadline',
                'deskripsi',
                'is_active',
                'created_at',
            ])
            ->with(['company:id,nama'])
            ->where('is_active', true);

        /**
         * Keyword search:
         * - judul lowongan
         * - deskripsi lowongan (opsional tapi bagus untuk UX)
         * - nama perusahaan
         */
        if (!empty($validated['q'])) {
            $terms = preg_split('/\s+/', trim($validated['q'])) ?: [];

            $query->where(function ($outer) use ($terms) {
                foreach ($terms as $term) {
                    if ($term === '') {
                        continue;
                    }

                    $like = '%' . $this->escapeLike($term) . '%';

                    $outer->where(function ($sub) use ($like) {
                        $sub->where('judul', 'like', $like)
                            ->orWhere('deskripsi', 'like', $like)
                            ->orWhereHas('company', function ($company) use ($like) {
                                $company->where('nama', 'like', $like);
                            });
                    });
                }
            });
        }

        // Filters
        if (!empty($validated['lokasi'])) {
            $query->where('lokasi', 'like', '%' . $this->escapeLike($validated['lokasi']) . '%');
        }

        if (!empty($validated['tipe'])) {
            $query->where('tipe', $validated['tipe']);
        }

        if (!empty($validated['level'])) {
            $query->where('level', $validated['level']);
        }

        if (!empty($validated['kategori'])) {
            $query->where('kategori', $validated['kategori']);
        }

        // Salary range (rapi + tahan input kebalik)
        $min = $validated['gaji_min'] ?? null;
        $max = $validated['gaji_max'] ?? null;

        if ($min !== null && $max !== null && $min > $max) {
            [$min, $max] = [$max, $min];
        }

        if ($min !== null) {
            $query->where('gaji_min', '>=', $min);
        }

        if ($max !== null) {
            $query->where('gaji_max', '<=', $max);
        }

        // Sorting (fix: sebelumnya ketimpa latest() lagi)
        $sort = $validated['sort'] ?? 'latest';
        if ($sort === 'deadline') {
            $query->orderByRaw("CASE WHEN deadline IS NULL THEN 1 ELSE 0 END, deadline ASC");
        } else {
            $query->orderByDesc('created_at');
        }

        $jobs = $query->paginate(8)->withQueryString();

        return view('pelamar.jobs.index', compact('jobs'));
    }

    public function show(Job $job)
    {
        $job->load('company');

        $alreadyApplied = auth()->check()
            ? $job->applications()->where('user_id', auth()->id())->exists()
            : false;

        return view('pelamar.jobs.show', compact('job', 'alreadyApplied'));
    }

    /**
     * Escapes special characters for SQL LIKE queries.
     * Prevents '%' and '_' from behaving as wildcards when user types them.
     */
    private function escapeLike(string $value): string
    {
        return addcslashes($value, "\\%_");
    }
}
