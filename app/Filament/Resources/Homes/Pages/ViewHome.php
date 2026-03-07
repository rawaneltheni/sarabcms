<?php

namespace App\Filament\Resources\Homes\Pages;

use App\Filament\Resources\Homes\HomeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewHome extends ViewRecord
{
    protected static string $resource = HomeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back')
                ->url(HomeResource::getUrl('index'))
                ->icon('heroicon-o-arrow-left'),
            Actions\EditAction::make(),
        ];
    }
}
