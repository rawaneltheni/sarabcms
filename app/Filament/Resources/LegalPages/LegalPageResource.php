<?php

namespace App\Filament\Resources\LegalPages;

use App\Filament\Resources\LegalPages\Pages\CreateLegalPage;
use App\Filament\Resources\LegalPages\Pages\EditLegalPage;
use App\Filament\Resources\LegalPages\Pages\ListLegalPages;
use App\Models\LegalPage;
use App\Support\PlainText;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LegalPageResource extends Resource
{
    protected static ?string $model = LegalPage::class;
    protected static ?string $navigationLabel = 'Legal Pages';
    protected static ?string $modelLabel = 'Legal page';
    protected static ?string $pluralModelLabel = 'Legal Pages';

    protected static string|\UnitEnum|null $navigationGroup = 'Website CMS';
    protected static ?int $navigationSort = 2;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('slug')->required()->unique(ignoreRecord: true),
            TextInput::make('title')->required(),
            Textarea::make('content')
                ->formatStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                ->dehydrateStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                ->rows(30)
                ->helperText('Plain text only. HTML and inline CSS are not rendered on the website.')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('slug')->searchable(),
            TextColumn::make('title')->searchable(),
            TextColumn::make('updated_at')->dateTime()->sortable(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLegalPages::route('/'),
            'create' => CreateLegalPage::route('/create'),
            'edit' => EditLegalPage::route('/{record}/edit'),
        ];
    }
}
