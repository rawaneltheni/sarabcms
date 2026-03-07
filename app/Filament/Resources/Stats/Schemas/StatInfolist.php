<?php

namespace App\Filament\Resources\Stats\Schemas;

use App\Filament\Schemas\Components\TimestampsInfolistEntries;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class StatInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('icon'),
                TextEntry::make('number'),
                TextEntry::make('label'),
                TextEntry::make('order'),
                ...TimestampsInfolistEntries::make(),
            ]);
    }
}
