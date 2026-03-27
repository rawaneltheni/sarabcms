<?php

namespace App\Filament\Resources\SocialLinksResource\Pages;

use App\Filament\Resources\SocialLinksResource;
use App\Models\SiteSetting;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ListRecords;

class ListSocialLinks extends ListRecords
{
    protected static string $resource = SocialLinksResource::class;

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
