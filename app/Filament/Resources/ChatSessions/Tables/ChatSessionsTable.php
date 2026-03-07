<?php

namespace App\Filament\Resources\ChatSessions\Tables;

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
                TextColumn::make('messages_count')
                    ->label('Messages')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('last_page_url')
                    ->label('Last Page')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->last_page_url),
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
                ViewAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
