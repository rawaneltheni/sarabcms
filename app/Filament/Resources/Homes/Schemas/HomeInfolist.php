<?php

namespace App\Filament\Resources\Homes\Schemas;

use App\Filament\Schemas\Components\TimestampsInfolistEntries;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class HomeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ImageEntry::make('image'),
                TextEntry::make('h1'),
                TextEntry::make('h2'),
                TextEntry::make('body')
                    ->columnSpanFull(),
                TextEntry::make('btn_text'),
                TextEntry::make('btn_link'),
                ...TimestampsInfolistEntries::make(),
            ]);
    }
}
