<?php

namespace App\Models;

use App\Models\Concerns\BumpsApiCacheVersion;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use BumpsApiCacheVersion;

    protected $fillable = [
        'icon',
        'number',
        'label',
        'order',
    ];
}
