<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        'title',
        'image',
        'excerpt',
        'slug',
        'date',
        'content',
    ];

    public function getImageUrlAttribute(): ?string
    {
        $path = trim((string) ($this->image ?? ''));

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
