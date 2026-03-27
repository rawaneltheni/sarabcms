<?php

namespace App\Filament\Resources\PageBlocks;

use App\Filament\Resources\PageBlocks\Pages\CreatePageBlock;
use App\Filament\Resources\PageBlocks\Pages\EditPageBlock;
use App\Filament\Resources\PageBlocks\Pages\ListPageBlocks;
use App\Models\PageBlock;
use App\Support\PlainText;
use BackedEnum;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PageBlockResource extends Resource
{
    protected static ?string $model = PageBlock::class;
    protected static ?string $navigationLabel = 'Homepage Content';
    protected static ?string $modelLabel = 'Homepage section';
    protected static ?string $pluralModelLabel = 'Homepage Content';

    protected static string|\UnitEnum|null $navigationGroup = 'Website CMS';
    protected static ?int $navigationSort = 3;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Block')
                ->description('Pick which homepage area you are editing.')
                ->schema([
                    Select::make('page')
                        ->options([
                            'home' => 'Home',
                            'contact' => 'Contact',
                            'blog' => 'Blog',
                        ])
                        ->helperText('For normal website editing, keep this on Home.')
                        ->required(),
                    TextInput::make('key')
                        ->label('Section name')
                        ->required()
                        ->helperText('Use `stats` for "Sarab in numbers", `blog` for the blog section, `portfolio` for projects, and `contact_cta` for the final call to action.'),
                    TextInput::make('order')
                        ->label('Display order')
                        ->numeric()
                        ->default(0)
                        ->required(),
                ])->columns(3),
            Section::make('Content')
                ->description('Edit the text shown on the website for this section.')
                ->schema([
                    TextInput::make('eyebrow')->label('Section label'),
                    TextInput::make('title')->label('Main heading'),
                    TextInput::make('subtitle')->label('Highlighted heading'),
                    Textarea::make('description')
                        ->label('Section description')
                        ->formatStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                        ->dehydrateStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                        ->columnSpanFull(),
                    TextInput::make('cta_label')->label('Primary button label'),
                    TextInput::make('cta_url')->label('Primary button link'),
                    TextInput::make('secondary_cta_label')->label('Secondary button label'),
                    TextInput::make('secondary_cta_url')->label('Secondary button link'),
                    KeyValue::make('meta')
                        ->label('Extra fields')
                        ->columnSpanFull()
                        ->helperText('Usually leave this alone. It is only for special cases like the About section feature list.'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('page')->badge()->sortable(),
            TextColumn::make('key')->searchable(),
            TextColumn::make('title')->limit(40)->searchable(),
            TextColumn::make('order')->sortable(),
            TextColumn::make('updated_at')->dateTime()->sortable(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPageBlocks::route('/'),
            'create' => CreatePageBlock::route('/create'),
            'edit' => EditPageBlock::route('/{record}/edit'),
        ];
    }
}
