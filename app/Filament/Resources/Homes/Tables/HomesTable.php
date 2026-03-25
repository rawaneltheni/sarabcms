<?php

namespace App\Filament\Resources\Homes\Tables;

use App\Filament\Schemas\Components\TimestampsTableColumns;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HomesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order')
                    ->sortable(),
                ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->visibility('public')
                    ->width(50)
                    ->circular(),
                TextColumn::make('h1')
                    ->label('Title 1')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('h2')
                    ->label('Title 2')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('body')
                    ->label('Description')
                    ->limit(50)
                    ->sortable(),
                TextColumn::make('btn_text')
                    ->label('Button Text')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('btn_link')
                    ->label('Button Link')
                    ->sortable()
                    ->searchable(),
                ...TimestampsTableColumns::make(),
            ])
            ->filters([

            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
