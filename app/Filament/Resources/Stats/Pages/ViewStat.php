<?php

namespace App\Filament\Resources\Stats\Pages;

use App\Filament\Resources\Stats\StatResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStat extends ViewRecord
{
    protected static string $resource = StatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back')
                ->url(StatResource::getUrl('index'))
                ->icon('heroicon-o-arrow-left'),
            Actions\EditAction::make(),
        ];
    }
}
