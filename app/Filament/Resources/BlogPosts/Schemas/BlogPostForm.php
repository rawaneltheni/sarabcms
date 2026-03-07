<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use App\Filament\Schemas\Components\SharedFileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Title')
                    ->required(),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                DatePicker::make('date')
                    ->label('Date'),
                SharedFileUpload::make('image', 'Image', 'blog'),
                Textarea::make('excerpt')
                    ->label('Excerpt')
                    ->columnSpanFull(),
                Textarea::make('content')
                    ->label('Content')
                    ->columnSpanFull(),
            ]);
    }
}
