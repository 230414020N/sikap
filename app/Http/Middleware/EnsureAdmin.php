<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        abort_if(!$user || ($user->role ?? null) !== 'admin', 403);

        return $next($request);
    }
}
