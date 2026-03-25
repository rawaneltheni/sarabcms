<?php

namespace App\Filament\Resources\Homes\Schemas;

use App\Filament\Schemas\Components\SharedFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class HomeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                SharedFileUpload::make('image', 'Image', 'home'),
                TextInput::make('h1')
                    ->label('Title 1'),
                TextInput::make('h2')
                    ->label('Title 2'),
                Textarea::make('body')
                    ->label('Description')
                    ->columnSpanFull(),
                TextInput::make('btn_text')
                    ->label('Button Text')
                    ->default('Get in touch'),
                TextInput::make('btn_link')
                    ->label('Button Link')
                    ->default('/contact'),
                TextInput::make('order')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }
}
