<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    public function view(User $user, Company $company): bool
    {
        return (int)$user->company_id === (int)$company->id && $user->role === 'perusahaan';
    }

    public function update(User $user, Company $company): bool
    {
        return (int)$user->company_id === (int)$company->id && $user->role === 'perusahaan';
    }
}
