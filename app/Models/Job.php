<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_id');
    }


    public function location()
    {
        return $this->belongsTo(JobLocation::class, 'job_location_id');
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class, 'education_level_id');
    }

    public function employmentStatus()
    {
        return $this->belongsTo(\App\Models\EmploymentStatus::class, 'employment_status_id');
    }

    public function applications()
    {
        return $this->hasMany(\App\Models\Application::class, 'job_id');
    }
}
