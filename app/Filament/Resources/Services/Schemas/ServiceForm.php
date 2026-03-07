<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Filament\Schemas\Components\SharedFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                SharedFileUpload::make('image', 'Image', 'services'),
                TextInput::make('icon')
                    ->label('Icon'),
                TextInput::make('title')
                    ->label('Title'),
                Textarea::make('description')
                    ->label('Description')
                    ->columnSpanFull(),
            ]);
    }
}
