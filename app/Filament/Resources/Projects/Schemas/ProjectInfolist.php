<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Filament\Schemas\Components\TimestampsInfolistEntries;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProjectInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ...TimestampsInfolistEntries::make(),
            ]);
    }
}
