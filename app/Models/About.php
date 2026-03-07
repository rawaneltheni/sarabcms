<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
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
