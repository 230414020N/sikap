<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $guarded = [];

    public function employmentStatus()
    {
        return $this->belongsTo(\App\Models\EmploymentStatus::class, 'employment_status_id');
    }
}
