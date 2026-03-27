<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Image')
                    ->disk('public') 
                    ->visibility('public') 
                    ->width(50) 
                    ->height(50) 
                    ->circular(), 
                TextColumn::make('title')
                    ->label('Title')
                    ->sortable()->searchable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->sortable()->searchable(),
                TextColumn::make('category')
                    ->label('Category')
                    ->sortable()->searchable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->sortable(),
                IconColumn::make('show_on_homepage')
                    ->label('Homepage')
                    ->boolean(),
                TextColumn::make('homepage_order')
                    ->label('Homepage order')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
