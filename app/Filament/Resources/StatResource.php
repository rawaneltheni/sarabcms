<?php


namespace App\Filament\Resources;
use \UnitEnum;

use BackedEnum;
use App\Filament\Resources\StatResource\Pages;
use App\Models\Stat;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;

class StatResource extends Resource
{
    protected static ?string $model = Stat::class;
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-chart-bar';
    protected static UnitEnum|string|null $navigationGroup = 'CMS';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\TextInput::make('icon')->label('Icon'),
            Forms\Components\TextInput::make('number')->numeric()->required(),
            Forms\Components\TextInput::make('label')->required(),
            Forms\Components\TextInput::make('order')->numeric(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('number'),
            Tables\Columns\TextColumn::make('label'),
            Tables\Columns\TextColumn::make('order'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStats::route('/'),
            'create' => Pages\CreateStat::route('/create'),
            'edit' => Pages\EditStat::route('/{record}/edit'),
        ];
    }
}
