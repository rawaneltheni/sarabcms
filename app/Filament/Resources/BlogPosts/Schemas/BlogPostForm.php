<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use App\Filament\Schemas\Components\SharedFileUpload;
use App\Support\PlainText;
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
                    ->formatStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                    ->dehydrateStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                    ->columnSpanFull(),
                Textarea::make('content')
                    ->label('Content')
                    ->formatStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                    ->dehydrateStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                    ->columnSpanFull(),
            ]);
    }
}
