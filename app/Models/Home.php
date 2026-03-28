<?php

namespace App\Models;

use App\Models\Concerns\BumpsApiCacheVersion;
use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    use BumpsApiCacheVersion;

    protected $table = 'home_sliders';

    protected $fillable = [
        'image',
        'h1',
        'h2',
        'body',
        'btn_text',
        'btn_link',
        'order',
    ];

    public function getImageUrlAttribute(): ?string
    {
        $path = trim((string) ($this->image ?? ''));

        if ($path === '') {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    }
}
