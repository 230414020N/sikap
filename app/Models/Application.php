<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'user_id',
        'status',
        'catatan_pelamar',
        'cv_snapshot_path',
        'surat_lamaran_snapshot_path',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function pelamar()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function histories()
    {
        return $this->hasMany(ApplicationStatusHistory::class);
    }

    public function portofolios()
    {
        return $this->belongsToMany(Portofolio::class, 'application_portofolio')
            ->withTimestamps();
    }
    public function internalNotes()
    {
        return $this->hasMany(\App\Models\InternalNote::class);
    }


}
