<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialLinksResource\Pages\EditSocialLinks;
use App\Filament\Resources\SocialLinksResource\Pages\ListSocialLinks;
use App\Models\SiteSetting;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SocialLinksResource extends Resource
{
    protected static ?string $model = SiteSetting::class;
    protected static ?string $navigationLabel = 'Social Links';
    protected static ?string $modelLabel = 'Social link';
    protected static ?string $pluralModelLabel = 'Social Links';

    protected static string|\UnitEnum|null $navigationGroup = 'Website CMS';
    protected static ?int $navigationSort = 9;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-share';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Social Links')
                ->schema([
                    TextInput::make('footer_links_heading')->label('Section heading'),
                    TextInput::make('facebook_url')->label('Facebook URL')->url(),
                    TextInput::make('twitter_url')->label('X / Twitter URL'),
                    TextInput::make('instagram_url')->label('Instagram URL'),
                    TextInput::make('linkedin_url')->label('LinkedIn URL'),
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
            'index' => ListSocialLinks::route('/'),
            'edit' => EditSocialLinks::route('/{record}/edit'),
        ];
    }
}
