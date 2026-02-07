<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;

class PerusahaanDashboardController extends Controller
{
    public function index()
    {
        $companyId = auth()->user()->company_id;

        $company = Company::findOrFail($companyId);

        
        $totalHrd = User::query()
            ->where('company_id', $companyId)
            ->where('role', 'hrd')
            ->count();

      

        $totalJobs = null;        // placeholder
        $totalApplicants = null;  // placeholder

        return view('perusahaan.dashboard', compact('company', 'totalHrd', 'totalJobs', 'totalApplicants'));
    }
}
