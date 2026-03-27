<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FooterResource\Pages\EditFooter;
use App\Filament\Resources\FooterResource\Pages\ListFooter;
use App\Models\SiteSetting;
use App\Support\PlainText;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FooterResource extends Resource
{
    protected static ?string $model = SiteSetting::class;
    protected static ?string $navigationLabel = 'Footer';
    protected static ?string $modelLabel = 'Footer';
    protected static ?string $pluralModelLabel = 'Footer';

    protected static string|\UnitEnum|null $navigationGroup = 'Website CMS';
    protected static ?int $navigationSort = 8;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-group';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Footer')
                ->schema([
                    Textarea::make('footer_description')
                        ->label('Footer description')
                        ->formatStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                        ->dehydrateStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                        ->columnSpanFull(),
                ]),
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
            'index' => ListFooter::route('/'),
            'edit' => EditFooter::route('/{record}/edit'),
        ];
    }
}
