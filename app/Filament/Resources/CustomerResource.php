<?php


namespace App\Filament\Resources;
use \UnitEnum;

use BackedEnum;
use App\Filament\Schemas\Components\SharedFileUpload;
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
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            SharedFileUpload::make('logo_path', 'Logo', 'customers'),
            Forms\Components\TextInput::make('website_url')
                ->label('Website URL')
                ->url()
                ->maxLength(255)
                ->helperText('Optional link for this customer logo or name.'),
            Forms\Components\TextInput::make('order')
                ->numeric()
                ->default(0)
                ->required()
                ->helperText('Lower numbers appear first on the homepage.'),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('order')->sortable(),
            Tables\Columns\ImageColumn::make('logo_path')->label('Logo')->disk('public'),
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('website_url')->label('Website')->limit(40)->toggleable(),
        ])->defaultSort('order');
    }

    public static function getRelations(): array
    {
        return [
        ];
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
