<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageBlock extends Model
{
    protected $fillable = [
        'page',
        'key',
        'eyebrow',
        'title',
        'subtitle',
        'description',
        'cta_label',
        'cta_url',
        'secondary_cta_label',
        'secondary_cta_url',
        'meta',
        'order',
    ];

    protected $casts = [
        'meta' => 'array',
    ];
}
