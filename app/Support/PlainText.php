<?php

namespace App\Support;

class PlainText
{
    public static function clean(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return trim(html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }
}
