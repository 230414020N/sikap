<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelamarProfile extends Model
{
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'no_hp',
        'alamat',
        'pendidikan_terakhir',
        'jurusan',
        'institusi',
        'tahun_lulus',
        'bio',
        'foto_path',
        'headline',
        'tanggal_lahir',
        'jenis_kelamin',
        'domisili',
        'kode_pos',
        'linkedin_url',
        'github_url',
        'portfolio_url',
        'keterampilan',
        'bahasa',
        'posisi_diinginkan',
        'gaji_harapan',
        'ketersediaan_mulai',
        'kontak_darurat_nama',
        'kontak_darurat_hp',
        'cv_path',
        'surat_lamaran_path',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'ketersediaan_mulai' => 'date',
        'keterampilan' => 'array',
        'bahasa' => 'array',
    ];
}
