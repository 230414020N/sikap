<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationInternalNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'created_by',
        'title',
        'rating',
        'recommendation',
        'note',
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
