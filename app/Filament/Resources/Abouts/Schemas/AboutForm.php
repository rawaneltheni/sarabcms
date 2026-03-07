<?php

namespace App\Filament\Resources\Abouts\Schemas;

use App\Filament\Schemas\Components\SharedFileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AboutForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('heading1')
                    ->label('Heading 1')
                    ->required(),
                TextInput::make('heading2')
                    ->label('Heading 2'),
                Textarea::make('description')
                    ->label('Description')
                    ->required()
                    ->columnSpanFull(),
                TagsInput::make('features')
                    ->label('Features')
                    ->placeholder('Type feature and press enter')
                    ->columnSpanFull(),
                SharedFileUpload::make('image1', 'Image 1', 'about'),
                SharedFileUpload::make('image2', 'Image 2', 'about'),
                SharedFileUpload::make('image3', 'Image 3', 'about'),
            ]);
    }
}
