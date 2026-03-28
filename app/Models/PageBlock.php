<?php

namespace App\Models;

use App\Models\Concerns\BumpsApiCacheVersion;
use Illuminate\Database\Eloquent\Model;

class PageBlock extends Model
{
    use BumpsApiCacheVersion;

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
