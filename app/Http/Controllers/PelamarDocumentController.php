<?php

namespace App\Http\Controllers;

use App\Models\PelamarProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PelamarDocumentController extends Controller
{
    public function downloadCv(Request $request)
    {
        $profile = PelamarProfile::firstOrCreate(['user_id' => auth()->id()], []);
        $this->authorize('view', $profile);

        if (!$profile->cv_path || !Storage::disk('private')->exists($profile->cv_path)) {
            abort(404);
        }

        return Storage::disk('private')->download($profile->cv_path);
    }

    public function downloadSurat(Request $request)
    {
        $profile = PelamarProfile::firstOrCreate(['user_id' => auth()->id()], []);
        $this->authorize('view', $profile);

        if (!$profile->surat_lamaran_path || !Storage::disk('private')->exists($profile->surat_lamaran_path)) {
            abort(404);
        }

        return Storage::disk('private')->download($profile->surat_lamaran_path);
    }
}
