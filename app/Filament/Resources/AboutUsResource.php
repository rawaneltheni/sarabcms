<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutUsResource\Pages\EditAboutUs;
use App\Filament\Resources\AboutUsResource\Pages\ListAboutUs;
use App\Models\SiteSetting;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AboutUsResource extends Resource
{
    protected static ?string $model = SiteSetting::class;
    protected static ?string $navigationLabel = 'About Us';
    protected static ?string $modelLabel = 'About us';
    protected static ?string $pluralModelLabel = 'About Us';

    protected static string|\UnitEnum|null $navigationGroup = 'Website CMS';
    protected static ?int $navigationSort = 6;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-information-circle';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('About Us')
                ->schema([
                    TextInput::make('header_about_label')->label('Navigation label'),
                    TextInput::make('about_section_label')->label('Section label'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('site_name')->label('Website'),
            TextColumn::make('updated_at')->dateTime()->sortable(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAboutUs::route('/'),
            'edit' => EditAboutUs::route('/{record}/edit'),
        ];
    }
}
