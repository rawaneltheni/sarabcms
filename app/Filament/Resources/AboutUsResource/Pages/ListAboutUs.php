<?php

namespace App\Filament\Resources\AboutUsResource\Pages;

use App\Filament\Resources\AboutUsResource;
use App\Models\SiteSetting;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ListRecords;

class ListAboutUs extends ListRecords
{
    protected static string $resource = AboutUsResource::class;

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
