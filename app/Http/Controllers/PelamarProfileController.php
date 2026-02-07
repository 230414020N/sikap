<?php

namespace App\Http\Controllers;

use App\Models\PelamarProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PelamarProfileController extends Controller
{
    public function show()
    {
        $profile = PelamarProfile::firstOrCreate(['user_id' => auth()->id()], []);

        if ((int) $profile->user_id !== (int) auth()->id()) {
            abort(403);
        }

        return view('pelamar.profile.show', compact('profile'));
    }
    public function edit($id)
    {
        $profile = PelamarProfile::firstOrCreate(['user_id' => $id], []);

        if ((int) $profile->user_id !== (int) auth()->id()) {
            abort(403);
        }

        return view('pelamar.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = PelamarProfile::firstOrCreate(['user_id' => auth()->id()], []);

        if ((int) $profile->user_id !== (int) auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'foto' => ['nullable', 'image', 'max:2048'],
            'headline' => ['nullable', 'string', 'max:255'],
            'nama_lengkap' => ['nullable', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:50'],
            'bio' => ['nullable', 'string'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['nullable', 'in:pria,wanita,lainnya'],
            'domisili' => ['nullable', 'string', 'max:255'],
            'kode_pos' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],

            'pendidikan_terakhir' => ['nullable', 'string', 'max:255'],
            'jurusan' => ['nullable', 'string', 'max:255'],
            'institusi' => ['nullable', 'string', 'max:255'],
            'tahun_lulus' => ['nullable', 'integer', 'min:1900', 'max:2100'],

            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'portfolio_url' => ['nullable', 'url', 'max:255'],

            'keterampilan' => ['nullable', 'array'],
            'keterampilan.*' => ['string', 'max:50'],
            'bahasa' => ['nullable', 'array'],
            'bahasa.*' => ['string', 'max:50'],

            'posisi_diinginkan' => ['nullable', 'string', 'max:255'],
            'gaji_harapan' => ['nullable', 'integer', 'min:0'],
            'ketersediaan_mulai' => ['nullable', 'date'],

            'kontak_darurat_nama' => ['nullable', 'string', 'max:255'],
            'kontak_darurat_hp' => ['nullable', 'string', 'max:50'],

            'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:4096'],
            'surat_lamaran' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:4096'],
        ]);

        if ($request->hasFile('foto')) {
            if ($profile->foto_path) {
                Storage::disk('public')->delete($profile->foto_path);
            }
            $validated['foto_path'] = $request->file('foto')->store('pelamar/foto', 'public');
        }

        if ($request->hasFile('cv')) {
            if ($profile->cv_path) {
                Storage::disk('public')->delete($profile->cv_path);
            }
            $validated['cv_path'] = $request->file('cv')->store('pelamar/cv', 'public');
        }

        if ($request->hasFile('surat_lamaran')) {
            if ($profile->surat_lamaran_path) {
                Storage::disk('public')->delete($profile->surat_lamaran_path);
            }
            $validated['surat_lamaran_path'] = $request->file('surat_lamaran')->store('pelamar/surat-lamaran', 'public');
        }

        unset($validated['foto'], $validated['cv'], $validated['surat_lamaran']);

        $profile->update($validated);

        return redirect()
            ->route('pelamar.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
