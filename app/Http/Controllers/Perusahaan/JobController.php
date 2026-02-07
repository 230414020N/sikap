<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use App\Models\Job;
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
}
