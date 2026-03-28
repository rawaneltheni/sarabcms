<?php

namespace App\Models;

use App\Models\Concerns\BumpsApiCacheVersion;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use BumpsApiCacheVersion;

    protected $fillable = [
        'icon',
        'title',
        'description',
        'image',
        'url',
        'order',
    ];
}
