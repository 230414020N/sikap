<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;

class HrdDashboardController extends Controller
{
    public function index(Request $request)
    {
        $companyId = $request->user()->company_id;

        $jobCount = Job::query()
            ->where('company_id', $companyId)
            ->count();

        $applicationCount = Application::query()
            ->whereHas('job', fn ($q) => $q->where('company_id', $companyId))
            ->count();

        $latestApplications = Application::query()
            ->whereHas('job', fn ($q) => $q->where('company_id', $companyId))
            ->with(['job', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('hrd.dashboard', compact('jobCount', 'applicationCount', 'latestApplications'));
    }
}
