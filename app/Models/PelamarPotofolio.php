<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelamarPortofolio extends Model
{
    protected $fillable = [
        'pelamar_id',
        'title',
        'url',
        'file_path',
        'description',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
