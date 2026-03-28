<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

class ApiCache
{
    protected const VERSION_KEY = 'api:content-version';

    public static function version(): int
    {
        return (int) Cache::get(self::VERSION_KEY, 1);
    }

    public static function key(string $name): string
    {
        return 'api:' . self::version() . ':' . $name;
    }

    public static function bump(): void
    {
        Cache::forever(self::VERSION_KEY, self::version() + 1);
    }
}
