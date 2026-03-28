<?php

namespace App\Models;

use App\Models\Concerns\BumpsApiCacheVersion;
use Illuminate\Database\Eloquent\Model;

class LegalPage extends Model
{
    use BumpsApiCacheVersion;

    protected $fillable = [
        'slug',
        'title',
        'content',
    ];
}
