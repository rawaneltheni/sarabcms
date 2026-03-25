<?php


namespace App\Filament\Resources;
use \UnitEnum;

use BackedEnum;
use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-user-group';
    protected static UnitEnum|string|null $navigationGroup = 'CMS';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\FileUpload::make('logo_path')->label('Logo')->directory('customers')->image(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\ImageColumn::make('logo_path')->label('Logo'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
