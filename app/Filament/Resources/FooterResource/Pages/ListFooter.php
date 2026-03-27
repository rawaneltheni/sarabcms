<?php

namespace App\Filament\Resources\FooterResource\Pages;

use App\Filament\Resources\FooterResource;
use App\Models\SiteSetting;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ListRecords;

class ListFooter extends ListRecords
{
    protected static string $resource = FooterResource::class;

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
