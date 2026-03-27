<?php

namespace App\Filament\Resources\ContactUsResource\Pages;

use App\Filament\Resources\ContactUsResource;
use App\Models\SiteSetting;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ListRecords;

class ListContactUs extends ListRecords
{
    protected static string $resource = ContactUsResource::class;

    protected function getHeaderActions(): array
    {
        $record = SiteSetting::query()->first();

        if (! $record) {
            $record = SiteSetting::query()->create(['site_name' => 'SARAB TECH']);
        }

        return [
            EditAction::make()->record($record),
        ];
    }
}
