<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactUsResource\Pages\EditContactUs;
use App\Filament\Resources\ContactUsResource\Pages\ListContactUs;
use App\Models\SiteSetting;
use App\Support\PlainText;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactUsResource extends Resource
{
    protected static ?string $model = SiteSetting::class;
    protected static ?string $navigationLabel = 'Contact Us';
    protected static ?string $modelLabel = 'Contact us';
    protected static ?string $pluralModelLabel = 'Contact Us';

    protected static string|\UnitEnum|null $navigationGroup = 'Website CMS';
    protected static ?int $navigationSort = 7;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-envelope';

    protected static function plainTextArea(string $name): Textarea
    {
        return Textarea::make($name)
            ->formatStateUsing(fn (?string $state): ?string => PlainText::clean($state))
            ->dehydrateStateUsing(fn (?string $state): ?string => PlainText::clean($state));
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Contact Us')
                ->schema([
                    TextInput::make('contact_heading')->label('Page heading'),
                    static::plainTextArea('contact_description')->label('Page description')->columnSpanFull(),
                    TextInput::make('contact_information_heading')->label('Info section heading'),
                    TextInput::make('contact_form_heading')->label('Form section heading'),
                    TextInput::make('contact_form_submit_label')->label('Submit button label'),
                    TextInput::make('contact_address_label')->label('Address label'),
                    TextInput::make('contact_email_label')->label('Email label'),
                    TextInput::make('contact_phone_label')->label('Phone label'),
                    TextInput::make('contact_back_label')->label('Back link label'),
                    TextInput::make('contact_first_name_label')->label('First name label'),
                    TextInput::make('contact_last_name_label')->label('Last name label'),
                    TextInput::make('contact_email_input_label')->label('Email field label'),
                    TextInput::make('contact_subject_label')->label('Subject label'),
                    TextInput::make('contact_message_label')->label('Message label'),
                    TextInput::make('contact_first_name_placeholder')->label('First name placeholder'),
                    TextInput::make('contact_last_name_placeholder')->label('Last name placeholder'),
                    TextInput::make('contact_email_placeholder')->label('Email placeholder'),
                    TextInput::make('contact_subject_placeholder')->label('Subject placeholder'),
                    TextInput::make('contact_message_placeholder')->label('Message placeholder'),
                    TextInput::make('contact_email')->label('Contact email')->email(),
                    TextInput::make('contact_phone')->label('Contact phone'),
                    TextInput::make('address')->label('Office address'),
                    TextInput::make('map_embed_url')->label('Map embed URL')->columnSpanFull(),
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
            'index' => ListContactUs::route('/'),
            'edit' => EditContactUs::route('/{record}/edit'),
        ];
    }
}
