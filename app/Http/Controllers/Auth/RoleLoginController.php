<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleLoginController extends Controller
{
    public function show(Request $request)
    {
        $as = (string) $request->route('as');

        if (!in_array($as, ['pelamar', 'hrd', 'perusahaan'], true)) {
            $as = 'pelamar';
        }

        return view('auth.login', ['as' => $as]);
    }
}
