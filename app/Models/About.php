<?php

namespace App\Models;

use App\Models\Concerns\BumpsApiCacheVersion;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use BumpsApiCacheVersion;

    protected $fillable = [
        'heading1',
        'heading2',
        'description',
        'image1',
        'image2',
        'image3',
        'features',
    ];

    protected $casts = [
        'features' => 'array',
    ];
}
