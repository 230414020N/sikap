<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'website',
        'alamat',
        'logo_path',
        'deskripsi',
        'industri',
        'ukuran',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
