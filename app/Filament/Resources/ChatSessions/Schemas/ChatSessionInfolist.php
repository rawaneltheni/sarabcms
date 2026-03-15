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
                TextEntry::make('human_takeover_active')
                    ->label('Current Mode')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Human takeover active' : 'AI assistant active'),
                TextEntry::make('humanTakeoverBy.name')
                    ->label('Joined By')
                    ->placeholder('—'),
                TextEntry::make('human_takeover_started_at')
                    ->label('Joined At')
                    ->dateTime()
                    ->placeholder('—'),
                RepeatableEntry::make('logs')
                    ->label('Chat Conversation')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Time')
                            ->dateTime(),
                        TextEntry::make('meta.source')
                            ->label('Source')
                            ->formatStateUsing(function (?string $state): string {
                                return match ($state) {
                                    'human-agent' => 'Human agent',
                                    'system' => 'System',
                                    default => 'Assistant / Widget',
                                };
                            }),
                        TextEntry::make('user_message')
                            ->label('You')
                            ->columnSpanFull(),
                        TextEntry::make('bot_reply')
                            ->label('Reply')
                            ->columnSpanFull(),
                        TextEntry::make('meta.agent_name')
                            ->label('Agent')
                            ->placeholder('—')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}
