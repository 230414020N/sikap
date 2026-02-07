<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePelamarProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'pelamar';
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'institusi' => 'nullable|string|max:255',
            'tahun_lulus' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'bio' => 'nullable|string|max:1000',

            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string|max:20',
            'domisili' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',

            'headline' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'portfolio_url' => 'nullable|url|max:255',

            'keterampilan' => 'nullable|array',
            'keterampilan.*' => 'string|max:50',
            'bahasa' => 'nullable|array',
            'bahasa.*' => 'string|max:50',

            'posisi_diinginkan' => 'nullable|string|max:255',
            'gaji_harapan' => 'nullable|integer|min:0',
            'ketersediaan_mulai' => 'nullable|date',

            'kontak_darurat_nama' => 'nullable|string|max:255',
            'kontak_darurat_hp' => 'nullable|string|max:20',

            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'surat_lamaran' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ];
    }
}
