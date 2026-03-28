<?php

namespace App\Models\Concerns;

use App\Support\ApiCache;

trait BumpsApiCacheVersion
{
    protected static function bootBumpsApiCacheVersion(): void
    {
        static::saved(static function (): void {
            ApiCache::bump();
        });

        static::deleted(static function (): void {
            ApiCache::bump();
        });
    }
}
