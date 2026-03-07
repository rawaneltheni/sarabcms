<?php

namespace App\Filament\Resources\Abouts\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AboutInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('heading1'),
                TextEntry::make('heading2'),
                TextEntry::make('description')->columnSpanFull(),
                TextEntry::make('features')
                    ->formatStateUsing(fn ($state): string => is_array($state) ? implode(', ', $state) : '')
                    ->label('Features')
                    ->columnSpanFull(),
                ImageEntry::make('image1')->label('Image 1'),
                ImageEntry::make('image2')->label('Image 2'),
                ImageEntry::make('image3')->label('Image 3'),
                TextEntry::make('updated_at')->dateTime(),
            ]);
    }
}
