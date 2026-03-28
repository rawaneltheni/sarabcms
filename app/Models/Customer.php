<?php

namespace App\Models;

use App\Models\Concerns\BumpsApiCacheVersion;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use BumpsApiCacheVersion;

    protected $fillable = [
        'name',
        'logo_path',
        'website_url',
        'order',
    ];

    public function getLogoUrlAttribute(): ?string
    {
        $path = trim((string) ($this->logo_path ?? ''));

        if ($path === '') {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    }
}
