<?php

namespace App\Filament\Resources\Customers\Schemas;

use App\Filament\Schemas\Components\TimestampsInfolistEntries;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Slider Logo')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Name'),
                        ImageEntry::make('logo_path')
                            ->label('Logo')
                            ->disk('public')
                            ->visibility('public'),
                        TextEntry::make('website_url')
                            ->label('Website URL')
                            ->placeholder('-'),
                        TextEntry::make('order')
                            ->label('Display order'),
                        ...TimestampsInfolistEntries::make(),
                    ])
                    ->columns(2),
            ]);
    }
}
