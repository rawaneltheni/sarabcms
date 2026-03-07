<?php

namespace App\Filament\Resources\Stats\Pages;

use App\Filament\Resources\Stats\StatResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateStat extends CreateRecord
{
    protected static string $resource = StatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back')
                ->url(StatResource::getUrl('index')),
        ];
    }
}
