<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'company_id',
        'is_active',
        'invitation_token',
        'invitation_token_hash',
        'invited_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'invitation_token',
        'invitation_token_hash',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'invited_at' => 'datetime',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class);
    }

    public function pelamarProfile()
    {
        return $this->hasOne(\App\Models\PelamarProfile::class);
    }

    public function portofolios()
    {
        return $this->hasMany(\App\Models\Portofolio::class);
    }
    
}
