<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Filament\Schemas\Components\SharedFileUpload;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                SharedFileUpload::make('image_path', 'Image', 'projects'),

                TextInput::make('title')
                    ->label('Title'),

                TextInput::make('slug')
                    ->label('Slug')
                    ->unique(ignoreRecord: true),

                Select::make('category')
                    ->label('Category')
                    ->options([
                        'App' => 'App',
                        'Web' => 'Web',
                        'Chatbot' => 'Chatbot',
                    ]),

                Textarea::make('description')
                    ->label('Description'),
            ]);
    }
}
