<?php

namespace App\Filament\Resources\Customers\Schemas;

use App\Filament\Schemas\Components\SharedFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Slider Logo')
                    ->description('This controls one logo shown in the homepage slider.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(255),
                        SharedFileUpload::make('logo_path', 'Logo', 'customers')
                            ->required(),
                        TextInput::make('website_url')
                            ->label('Website URL')
                            ->url()
                            ->helperText('Optional. Example: `https://example.com`'),
                        TextInput::make('order')
                            ->label('Display order')
                            ->numeric()
                            ->default(0)
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }
}
