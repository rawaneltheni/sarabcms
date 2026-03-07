<?php

namespace App\Filament\Resources\ChatSessions\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ChatSessionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                RepeatableEntry::make('logs')
                    ->label('Chat Conversation')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Time')
                            ->dateTime(),
                        TextEntry::make('user_message')
                            ->label('You')
                            ->columnSpanFull(),
                        TextEntry::make('bot_reply')
                            ->label('Assistant')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}
