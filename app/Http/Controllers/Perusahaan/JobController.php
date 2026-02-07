<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use App\Models\EducationLevel;
use App\Models\EmploymentStatus;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobLocation;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $companyId = auth()->user()->company_id;

        $jobs = Job::query()
            ->where('company_id', $companyId)
            ->with('employmentStatus')
            ->latest()
            ->paginate(10);

        return view('perusahaan.jobs.index', compact('jobs'));
    }

    public function create()
{
    // 2. Fetch all the data required by your dropdowns
    $employmentStatus = EmploymentStatus::all();
    $categories = JobCategory::all();
    $locations = JobLocation::all();
    $educationLevels = EducationLevel::all();

    // 3. Pass all of them using compact()
    return view('perusahaan.jobs.create', compact(
        'employmentStatus', 
        'categories', 
        'locations', 
        'educationLevels'
    ));
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
}
