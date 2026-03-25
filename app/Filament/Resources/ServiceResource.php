<?php


namespace App\Filament\Resources;
use \UnitEnum;

use BackedEnum;
use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-cog';
    protected static UnitEnum|string|null $navigationGroup = 'CMS';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\TextInput::make('icon')->label('Icon'),
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\Textarea::make('description'),
            Forms\Components\FileUpload::make('image')->label('Image')->directory('services')->image(),
            Forms\Components\TextInput::make('url')->label('URL'),
            Forms\Components\TextInput::make('order')->numeric(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title'),
            Tables\Columns\ImageColumn::make('image')->label('Image'),
            Tables\Columns\TextColumn::make('order'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
