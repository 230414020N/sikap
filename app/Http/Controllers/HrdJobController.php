<?php

namespace App\Http\Controllers;

use App\Models\EducationLevel;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobLocation;
use Illuminate\Http\Request;

class HrdJobController extends Controller
{
    public function index(Request $request)
    {
        $companyId = auth()->user()->company_id;

        $jobsQuery = Job::query()
            ->where('company_id', $companyId)
            ->with(['category', 'location', 'educationLevel'])
            ->withCount('applications');

        $q = trim((string) $request->get('q', ''));
        if ($q !== '') {
            $jobsQuery->where(function ($w) use ($q) {
                $w->where('judul', 'like', "%{$q}%")
                    ->orWhere('tipe', 'like', "%{$q}%")
                    ->orWhere('level', 'like', "%{$q}%");
            });
        }

        $status = (string) $request->get('status', '');
        if ($status === 'active') {
            $jobsQuery->where('is_active', true);
        } elseif ($status === 'inactive') {
            $jobsQuery->where('is_active', false);
        }

        $jobCategoryId = (string) $request->get('job_category_id', '');
        if ($jobCategoryId !== '') {
            $jobsQuery->where('job_category_id', $jobCategoryId);
        }

        $jobLocationId = (string) $request->get('job_location_id', '');
        if ($jobLocationId !== '') {
            $jobsQuery->where('job_location_id', $jobLocationId);
        }

        $sort = (string) ($request->get('sort') ?? 'latest');
        if ($sort === 'oldest') {
            $jobsQuery->oldest();
        } else {
            $jobsQuery->latest();
        }

        $jobs = $jobsQuery->paginate(10)->withQueryString();

        $categories = JobCategory::query()->orderBy('nama')->get();
        $locations = JobLocation::query()->orderBy('nama')->get();

        return view('hrd.jobs.index', compact('jobs', 'categories', 'locations'));
    }

    public function create()
    {
        $categories = JobCategory::query()->orderBy('nama')->get();
        $locations = JobLocation::query()->orderBy('nama')->get();
        $educationLevels = EducationLevel::query()->orderBy('nama')->get();

        return view('hrd.jobs.create', compact('categories', 'locations', 'educationLevels'));
    }

    public function store(Request $request)
    {
        $companyId = auth()->user()->company_id;

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'job_category_id' => ['nullable', 'exists:job_categories,id'],
            'job_location_id' => ['nullable', 'exists:job_locations,id'],
            'education_level_id' => ['nullable', 'exists:education_levels,id'],
            'tipe' => ['nullable', 'string', 'max:100'],
            'level' => ['nullable', 'string', 'max:100'],
            'gaji_min' => ['nullable', 'integer', 'min:0'],
            'gaji_max' => ['nullable', 'integer', 'min:0'],
            'deadline' => ['nullable', 'date'],
            'deskripsi' => ['nullable', 'string'],
            'kualifikasi' => ['nullable', 'string'],
            'is_active' => ['nullable', 'in:0,1'],
        ]);

        $validated['company_id'] = $companyId;
        $validated['is_active'] = (bool) $request->boolean('is_active');

        Job::create($validated);

        return redirect()
            ->route('hrd.jobs.index')
            ->with('success', 'Lowongan berhasil dibuat.');
    }

    public function edit(int $id)
    {
        $job = $this->findJobForCompany($id);

        $categories = JobCategory::query()->orderBy('nama')->get();
        $locations = JobLocation::query()->orderBy('nama')->get();
        $educationLevels = EducationLevel::query()->orderBy('nama')->get();

        return view('hrd.jobs.edit', compact('job', 'categories', 'locations', 'educationLevels'));
    }

    public function update(Request $request, int $id)
    {
        $job = $this->findJobForCompany($id);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'job_category_id' => ['nullable', 'exists:job_categories,id'],
            'job_location_id' => ['nullable', 'exists:job_locations,id'],
            'education_level_id' => ['nullable', 'exists:education_levels,id'],
            'tipe' => ['nullable', 'string', 'max:100'],
            'level' => ['nullable', 'string', 'max:100'],
            'gaji_min' => ['nullable', 'integer', 'min:0'],
            'gaji_max' => ['nullable', 'integer', 'min:0'],
            'deadline' => ['nullable', 'date'],
            'deskripsi' => ['nullable', 'string'],
            'kualifikasi' => ['nullable', 'string'],
            'is_active' => ['nullable', 'in:0,1'],
        ]);

        $validated['is_active'] = (bool) $request->boolean('is_active');

        $job->update($validated);

        return redirect()
            ->route('hrd.jobs.edit', $job->id)
            ->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $job = $this->findJobForCompany($id);
        $job->delete();

        return redirect()
            ->route('hrd.jobs.index')
            ->with('success', 'Lowongan berhasil dihapus.');
    }

    private function findJobForCompany(int $id): Job
    {
        $companyId = auth()->user()->company_id;

        return Job::query()
            ->where('company_id', $companyId)
            ->where('id', $id)
            ->firstOrFail();
    }
}
