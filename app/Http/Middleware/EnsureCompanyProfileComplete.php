<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureCompanyProfileComplete
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        if (($user->role ?? null) !== 'hrd') {
            return $next($request);
        }

        if (!$user->company) {
            return redirect()->route('hrd.company.register');
        }

        $company = $user->company;

        $complete = (bool) ($company->nama && $company->alamat && $company->no_hp);

        if (!$complete && !$request->routeIs('hrd.company.profile.edit', 'hrd.company.profile.update', 'logout')) {
            return redirect()->route('hrd.company.profile.edit');
        }

        return $next($request);
    }
}
