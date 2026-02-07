<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'portofolio_id',
        'user_id',
    ];
}
