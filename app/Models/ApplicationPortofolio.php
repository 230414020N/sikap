<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationPortofolio extends Model
{
    protected $fillable = [
        'application_id',
        'judul',
        'kategori',
        'tools',
        'deskripsi',
        'link_demo',
        'link_github',
        'thumbnail_path',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
