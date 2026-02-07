<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    protected $fillable = [
        'user_id',
        'judul',
        'kategori',
        'tools',
        'deskripsi',
        'link_demo',
        'link_github',
        'thumbnail_path',
        'is_showcase',
        'moderation_status',
        'moderation_reason',
        'moderated_by',
        'moderated_at',
    ];

    protected $casts = [
        'is_showcase' => 'boolean',
        'moderated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }

    public function scopeShowcase($query)
    {
        return $query->where('is_showcase', true);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_showcase', true)->where('moderation_status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('is_showcase', true)->where('moderation_status', 'pending');
    }
}
