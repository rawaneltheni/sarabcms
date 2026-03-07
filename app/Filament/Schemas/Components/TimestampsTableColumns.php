<?php

namespace App\Filament\Schemas\Components;

use Filament\Tables\Columns\TextColumn;

class TimestampsTableColumns
{
    public static function make(): array
    {
        return [
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
