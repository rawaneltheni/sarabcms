<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingResource;
use App\Models\SiteSetting;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ListRecords;

class ListSiteSettings extends ListRecords
{
    protected static string $resource = SiteSettingResource::class;

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
