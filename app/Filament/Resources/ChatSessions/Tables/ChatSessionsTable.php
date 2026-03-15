<?php

namespace App\Filament\Resources\ChatSessions\Tables;

use App\Filament\Resources\ChatSessions\ChatSessionResource;
use App\Models\ChatSession;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ChatSessionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('last_message_at', 'desc')
            ->columns([
                TextColumn::make('session_id')
                    ->label('Session ID')
                    ->searchable()
                    ->copyable()
                    ->limit(28),
                BadgeColumn::make('language')
                    ->label('Language')
                    ->formatStateUsing(fn (?string $state): string => strtoupper($state ?: 'n/a'))
                    ->colors([
                        'success' => fn (?string $state): bool => $state === 'en',
                        'info' => fn (?string $state): bool => $state === 'ar',
                        'gray' => fn (?string $state): bool => blank($state),
                    ]),
                BadgeColumn::make('human_takeover_active')
                    ->label('Mode')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Human' : 'AI')
                    ->colors([
                        'success' => fn (bool $state): bool => $state,
                        'gray' => fn (bool $state): bool => ! $state,
                    ]),
                BadgeColumn::make('ended_at')
                    ->label('Status')
                    ->formatStateUsing(fn ($state, ChatSession $record): string => $record->endedStatusLabel())
                    ->colors([
                        'danger' => fn ($state, ChatSession $record): bool => $record->hasEnded(),
                        'success' => fn ($state, ChatSession $record): bool => ! $record->hasEnded(),
                    ]),
                TextColumn::make('humanTakeoverBy.name')
                    ->label('Joined By')
                    ->placeholder('—')
                    ->toggleable(),
                TextColumn::make('messages_count')
                    ->label('Messages')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('last_message_at')
                    ->label('Last Activity')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                Action::make('joinChat')
                    ->label(fn (ChatSession $record): string => $record->human_takeover_active ? 'Open Chat' : 'Join Chat')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->disabled(fn (ChatSession $record): bool => $record->hasEnded())
                    ->tooltip(fn (ChatSession $record): ?string => $record->hasEnded() ? 'This chat has already ended.' : null)
                    ->url(fn (ChatSession $record): string => ChatSessionResource::getUrl('live', ['record' => $record])),
                Action::make('returnToAi')
                    ->label('Return to AI')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('warning')
                    ->hidden(fn (ChatSession $record): bool => ! $record->human_takeover_active)
                    ->disabled(fn (ChatSession $record): bool => $record->hasEnded())
                    ->tooltip(fn (ChatSession $record): ?string => $record->hasEnded() ? 'This chat has ended.' : null)
                    ->requiresConfirmation()
                    ->successNotificationTitle('AI assistant re-enabled for this chat.')
                    ->action(fn (ChatSession $record) => $record->releaseHumanTakeover()),
                ViewAction::make()
                    ->label('Transcript'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
