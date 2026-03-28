<?php

namespace App\Models;

use App\Models\Concerns\BumpsApiCacheVersion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Project extends Model
{
    use BumpsApiCacheVersion;
    use SoftDeletes;

    protected $fillable = [
        'image_path',
        'title',
        'slug',
        'category',
        'description',
        'show_on_homepage',
        'homepage_order',
    ];

    public function getImageUrlAttribute(): ?string
    {
        $path = trim((string) ($this->image_path ?? ''));

        if ($path === '') {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL) || Str::startsWith($path, ['//'])) {
            return $path;
        }

        $trimmed = ltrim($path, '/');

        if (Str::startsWith($trimmed, ['public/'])) {
            return asset(ltrim(substr($trimmed, 7), '/'));
        }

        if (Str::startsWith($trimmed, ['images/', 'storage/'])) {
            return asset($trimmed);
        }

        return asset('storage/' . $trimmed);
    }
}
