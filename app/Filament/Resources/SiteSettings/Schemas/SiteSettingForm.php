<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use App\Support\PlainText;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    protected static function plainTextArea(string $name): Textarea
    {
        return Textarea::make($name)
            ->formatStateUsing(fn (?string $state): ?string => PlainText::clean($state))
            ->dehydrateStateUsing(fn (?string $state): ?string => PlainText::clean($state));
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Company')
                ->description('Basic company details used across the site.')
                ->schema([
                    TextInput::make('site_name')->label('Company name')->required(),
                    TextInput::make('address')->label('Office address'),
                    TextInput::make('contact_email')->label('Contact email')->email(),
                    TextInput::make('contact_phone')->label('Contact phone'),
                ])->columns(2),
            Section::make('Navigation Links')
                ->description('Top menu labels only.')
                ->schema([
                    TextInput::make('header_home_label')->label('Home'),
                    TextInput::make('header_about_label')->label('About'),
                    TextInput::make('header_services_label')->label('Services'),
                    TextInput::make('header_portfolio_label')->label('Portfolio'),
                    TextInput::make('header_blog_label')->label('Blog'),
                ])->columns(2),
            Section::make('Buttons And Labels')
                ->description('Small reusable labels used in the UI. Main homepage text is edited in Homepage Content.')
                ->schema([
                    TextInput::make('portfolio_view_details_label')->label('Portfolio button label'),
                ])->columns(2),
            Section::make('About Us')
                ->description('Labels used for the homepage about section.')
                ->schema([
                    TextInput::make('about_section_label')->label('Section label'),
                ])->columns(2),
            Section::make('Contact Us')
                ->description('Contact page text, form labels, and map.')
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
                    TextInput::make('map_embed_url')->label('Map embed URL')->columnSpanFull(),
                ])->columns(2),
            Section::make('Footer')
                ->description('Footer text and footer section labels.')
                ->schema([
                    static::plainTextArea('footer_description')->label('Footer description')->columnSpanFull(),
                    TextInput::make('footer_links_heading')->label('Social links heading'),
                ])->columns(2),
            Section::make('Social links')
                ->description('External profile links such as WhatsApp alternatives, LinkedIn, Instagram, and more.')
                ->schema([
                    TextInput::make('facebook_url')->label('Facebook URL')->url(),
                    TextInput::make('twitter_url')->label('X / Twitter URL'),
                    TextInput::make('instagram_url')->label('Instagram URL'),
                    TextInput::make('linkedin_url')->label('LinkedIn URL'),
                ])->columns(2),
        ]);
    }
}
