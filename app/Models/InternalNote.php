<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalNote extends Model
{
    protected $fillable = [
        'application_id',
        'created_by',
        'title',
        'rating',
        'recommendation',
        'summary',
        'strengths',
        'concerns',
        'questions',
        'next_steps',
        'stage',
        'follow_up_at',
    ];

    protected $casts = [
        'strengths' => 'array',
        'concerns' => 'array',
        'questions' => 'array',
        'next_steps' => 'array',
        'follow_up_at' => 'datetime',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
