<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Filament\Schemas\Components\SharedFileUpload;
use App\Support\PlainText;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Service Card')
                    ->description('This controls one pricing/service card and its click target.')
                    ->schema([
                        SharedFileUpload::make('image', 'Image', 'services'),
                        TextInput::make('icon')
                            ->label('Icon'),
                        TextInput::make('title')
                            ->label('Title')
                            ->required(),
                        TextInput::make('url')
                            ->label('View project link')
                            ->helperText('Use a live URL like `https://example.com` or an internal path like `/contact`.'),
                        TextInput::make('order')
                            ->label('Display order')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Textarea::make('description')
                            ->label('Description')
                            ->formatStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                            ->dehydrateStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
