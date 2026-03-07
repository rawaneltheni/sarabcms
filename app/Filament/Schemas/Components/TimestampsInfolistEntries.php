<?php

namespace App\Filament\Schemas\Components;

use Filament\Infolists\Components\TextEntry;

class TimestampsInfolistEntries
{
    public static function make(): array
    {
        return [
            TextEntry::make('created_at')
                ->dateTime()
                ->placeholder('-'),
            TextEntry::make('updated_at')
                ->dateTime()
                ->placeholder('-'),
        ];
    }
}
