<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

       
        if (!$user) {
            return redirect()->route('login');
        }

        if (in_array($user->role, $roles, true)) {
            return $next($request);
        }

      
        $expected = implode(', ', $roles);
        $current = $user->role ?? 'unknown';

        return redirect($this->dashboardForRole($current))
            ->with('warning', "Kamu login sebagai {$current}. Halaman ini untuk {$expected}.");
    }

    private function dashboardForRole(string $role): string
    {
        
        return match ($role) {
            'admin' => '/admin/dashboard',
            'perusahaan' => '/perusahaan/dashboard',
            'hrd' => '/hrd/dashboard',
            default => '/dashboard', // pelamar / fallback
        };
    }
}
