<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use App\Support\PlainText;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BlogPostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('slug'),
                TextEntry::make('date')->date(),
                ImageEntry::make('image'),
                TextEntry::make('excerpt')
                    ->formatStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                    ->columnSpanFull(),
                TextEntry::make('content')
                    ->formatStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                    ->columnSpanFull(),
                TextEntry::make('updated_at')->dateTime(),
            ]);
    }
}
