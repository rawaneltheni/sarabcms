<?php

namespace App\Filament\Resources\Homes\Pages;

use App\Filament\Resources\Homes\HomeResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateHome extends CreateRecord
{
    protected static string $resource = HomeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back')
                ->url(HomeResource::getUrl('index')),
        ];
    }
}
