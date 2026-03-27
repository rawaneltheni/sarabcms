<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Filament\Schemas\Components\TimestampsInfolistEntries;
use App\Support\PlainText;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ServiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ImageEntry::make('image'),
                TextEntry::make('icon'),
                TextEntry::make('title'),
                TextEntry::make('description')
                    ->formatStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                    ->columnSpanFull(),
                ...TimestampsInfolistEntries::make(),
            ]);
    }
}
