<?php

namespace App\Filament\Pages;

use App\Filament\Schemas\Components\SharedFileUpload;
use App\Models\About;
use App\Models\Home;
use App\Models\PageBlock;
use App\Models\SiteSetting;
use App\Support\PlainText;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HomepageCms extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $title = 'Homepage CMS';
    protected static ?string $navigationLabel = 'Homepage CMS';
    protected static string|\UnitEnum|null $navigationGroup = 'Website CMS';
    protected static ?int $navigationSort = 0;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected string $view = 'filament.pages.homepage-cms';

    public ?array $data = [];

    public function mount(): void
    {
        $home = Home::query()->first();
        $about = About::query()->first();
        $settings = SiteSetting::query()->first();

        $heroBlock = $this->getHomeBlock('hero');
        $servicesBlock = $this->getHomeBlock('services');
        $portfolioBlock = $this->getHomeBlock('portfolio');
        $blogBlock = $this->getHomeBlock('blog');
        $contactCtaBlock = $this->getHomeBlock('contact_cta');

        $this->form->fill([
            'hero_image' => $home?->image,
            'hero_title_1' => $heroBlock?->title ?? $home?->h1,
            'hero_title_2' => $heroBlock?->subtitle ?? $home?->h2,
            'hero_description' => $heroBlock?->description ?? $home?->body,
            'hero_button_label' => $heroBlock?->cta_label ?? $home?->btn_text,
            'hero_button_link' => $heroBlock?->cta_url ?? $home?->btn_link,

            'about_section_label' => $about ? ($settings?->about_section_label) : ($settings?->about_section_label),
            'about_heading_1' => $about?->heading1,
            'about_heading_2' => $about?->heading2,
            'about_description' => $about?->description,
            'about_features' => $about?->features ?? [],
            'about_image_1' => $about?->image1,
            'about_image_2' => $about?->image2,
            'about_image_3' => $about?->image3,

            'services_section_label' => $servicesBlock?->eyebrow ?? $settings?->services_section_label,
            'services_section_title' => $servicesBlock?->title ?? $settings?->services_section_title,
            'services_section_description' => $servicesBlock?->description,

            'stats_section_label' => $settings?->figures_section_label,
            'stats_section_title' => $settings?->figures_section_title,
            'stats_section_description' => $settings?->figures_section_description,

            'portfolio_section_label' => $portfolioBlock?->eyebrow ?? $settings?->portfolio_section_label,
            'portfolio_section_title' => $portfolioBlock?->title ?? $settings?->portfolio_section_title,
            'portfolio_section_description' => $portfolioBlock?->description,
            'portfolio_button_label' => $settings?->portfolio_view_details_label,

            'blog_section_label' => $blogBlock?->eyebrow ?? $settings?->blog_section_label,
            'blog_section_title' => $blogBlock?->title ?? $settings?->blog_section_title,
            'blog_section_description' => $blogBlock?->description ?? $settings?->blog_section_description,
            'blog_button_label' => $blogBlock?->cta_label ?? $settings?->blog_cta_label,
            'blog_button_link' => $blogBlock?->cta_url ?? '/blog',

            'contact_cta_label' => $contactCtaBlock?->eyebrow ?? $settings?->contact_cta_description,
            'contact_cta_title' => $contactCtaBlock?->title ?? $settings?->contact_cta_title,
            'contact_cta_description' => $contactCtaBlock?->description,
            'contact_cta_button_label' => $contactCtaBlock?->cta_label ?? $settings?->contact_cta_button_label,
            'contact_cta_button_link' => $contactCtaBlock?->cta_url ?? '/contact',
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Hero')
                    ->schema([
                        SharedFileUpload::make('hero_image', 'Hero image', 'home'),
                        TextInput::make('hero_title_1')->label('Title line 1'),
                        TextInput::make('hero_title_2')->label('Title line 2'),
                        Textarea::make('hero_description')
                            ->label('Description')
                            ->formatStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                            ->dehydrateStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                            ->columnSpanFull(),
                        TextInput::make('hero_button_label')->label('Button label'),
                        TextInput::make('hero_button_link')->label('Button link'),
                    ])->columns(2),
                Section::make('About')
                    ->schema([
                        TextInput::make('about_section_label')->label('Section label'),
                        TextInput::make('about_heading_1')->label('Heading 1'),
                        TextInput::make('about_heading_2')->label('Heading 2'),
                        Textarea::make('about_description')
                            ->label('Description')
                            ->formatStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                            ->dehydrateStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                            ->columnSpanFull(),
                        TagsInput::make('about_features')
                            ->label('Features')
                            ->placeholder('Type feature and press enter')
                            ->columnSpanFull(),
                        SharedFileUpload::make('about_image_1', 'Image 1', 'about'),
                        SharedFileUpload::make('about_image_2', 'Image 2', 'about'),
                        SharedFileUpload::make('about_image_3', 'Image 3', 'about'),
                    ])->columns(2),
                Section::make('Services Section')
                    ->schema([
                        TextInput::make('services_section_label')->label('Section label'),
                        TextInput::make('services_section_title')->label('Title'),
                        Textarea::make('services_section_description')
                            ->label('Description')
                            ->formatStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                            ->dehydrateStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                            ->columnSpanFull(),
                    ])->columns(2),
                Section::make('Stats Section')
                    ->schema([
                        TextInput::make('stats_section_label')->label('Section label'),
                        TextInput::make('stats_section_title')->label('Title'),
                        Textarea::make('stats_section_description')
                            ->label('Description')
                            ->formatStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                            ->dehydrateStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                            ->columnSpanFull(),
                    ])->columns(2),
                Section::make('Selected Works Section')
                    ->schema([
                        TextInput::make('portfolio_section_label')->label('Section label'),
                        TextInput::make('portfolio_section_title')->label('Title'),
                        Textarea::make('portfolio_section_description')
                            ->label('Description')
                            ->formatStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                            ->dehydrateStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                            ->columnSpanFull(),
                        TextInput::make('portfolio_button_label')->label('View project button label'),
                    ])->columns(2),
                Section::make('Blog Section')
                    ->schema([
                        TextInput::make('blog_section_label')->label('Section label'),
                        TextInput::make('blog_section_title')->label('Title'),
                        Textarea::make('blog_section_description')
                            ->label('Description')
                            ->formatStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                            ->dehydrateStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                            ->columnSpanFull(),
                        TextInput::make('blog_button_label')->label('Button label'),
                        TextInput::make('blog_button_link')->label('Button link'),
                    ])->columns(2),
                Section::make('Final CTA')
                    ->schema([
                        TextInput::make('contact_cta_label')->label('Small label'),
                        TextInput::make('contact_cta_title')->label('Title'),
                        Textarea::make('contact_cta_description')
                            ->label('Description')
                            ->formatStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                            ->dehydrateStateUsing(fn (?string $state): ?string => PlainText::clean($state))
                            ->columnSpanFull(),
                        TextInput::make('contact_cta_button_label')->label('Button label'),
                        TextInput::make('contact_cta_button_link')->label('Button link'),
                    ])->columns(2),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $home = Home::query()->firstOrCreate(['id' => 1], ['order' => 1]);
        $about = About::query()->firstOrCreate(['id' => 1]);
        $settings = SiteSetting::query()->firstOrCreate(['id' => 1], ['site_name' => 'SARAB TECH']);

        $home->update([
            'image' => $data['hero_image'] ?? null,
            'h1' => $data['hero_title_1'] ?? null,
            'h2' => $data['hero_title_2'] ?? null,
            'body' => $data['hero_description'] ?? null,
            'btn_text' => $data['hero_button_label'] ?? null,
            'btn_link' => $data['hero_button_link'] ?? null,
            'order' => $home->order ?: 1,
        ]);

        $about->update([
            'heading1' => $data['about_heading_1'] ?? null,
            'heading2' => $data['about_heading_2'] ?? null,
            'description' => $data['about_description'] ?? null,
            'features' => $data['about_features'] ?? [],
            'image1' => $data['about_image_1'] ?? null,
            'image2' => $data['about_image_2'] ?? null,
            'image3' => $data['about_image_3'] ?? null,
        ]);

        $settings->update([
            'about_section_label' => $data['about_section_label'] ?? null,
            'services_section_label' => $data['services_section_label'] ?? null,
            'services_section_title' => $data['services_section_title'] ?? null,
            'figures_section_label' => $data['stats_section_label'] ?? null,
            'figures_section_title' => $data['stats_section_title'] ?? null,
            'figures_section_description' => $data['stats_section_description'] ?? null,
            'portfolio_section_label' => $data['portfolio_section_label'] ?? null,
            'portfolio_section_title' => $data['portfolio_section_title'] ?? null,
            'portfolio_view_details_label' => $data['portfolio_button_label'] ?? null,
            'blog_section_label' => $data['blog_section_label'] ?? null,
            'blog_section_title' => $data['blog_section_title'] ?? null,
            'blog_section_description' => $data['blog_section_description'] ?? null,
            'blog_cta_label' => $data['blog_button_label'] ?? null,
            'contact_cta_title' => $data['contact_cta_title'] ?? null,
            'contact_cta_description' => $data['contact_cta_label'] ?? null,
            'contact_cta_button_label' => $data['contact_cta_button_label'] ?? null,
        ]);

        $this->upsertHomeBlock('hero', [
            'eyebrow' => null,
            'title' => $data['hero_title_1'] ?? null,
            'subtitle' => $data['hero_title_2'] ?? null,
            'description' => $data['hero_description'] ?? null,
            'cta_label' => $data['hero_button_label'] ?? null,
            'cta_url' => $data['hero_button_link'] ?? null,
            'order' => 1,
        ]);

        $this->upsertHomeBlock('services', [
            'eyebrow' => $data['services_section_label'] ?? null,
            'title' => $data['services_section_title'] ?? null,
            'description' => $data['services_section_description'] ?? null,
            'order' => 3,
        ]);

        $this->upsertHomeBlock('portfolio', [
            'eyebrow' => $data['portfolio_section_label'] ?? null,
            'title' => $data['portfolio_section_title'] ?? null,
            'description' => $data['portfolio_section_description'] ?? null,
            'order' => 5,
        ]);

        $this->upsertHomeBlock('blog', [
            'eyebrow' => $data['blog_section_label'] ?? null,
            'title' => $data['blog_section_title'] ?? null,
            'description' => $data['blog_section_description'] ?? null,
            'cta_label' => $data['blog_button_label'] ?? null,
            'cta_url' => $data['blog_button_link'] ?? null,
            'order' => 6,
        ]);

        $this->upsertHomeBlock('contact_cta', [
            'eyebrow' => $data['contact_cta_label'] ?? null,
            'title' => $data['contact_cta_title'] ?? null,
            'description' => $data['contact_cta_description'] ?? null,
            'cta_label' => $data['contact_cta_button_label'] ?? null,
            'cta_url' => $data['contact_cta_button_link'] ?? null,
            'order' => 7,
        ]);

        Notification::make()
            ->title('Homepage updated')
            ->success()
            ->send();
    }

    protected function getHomeBlock(string $key): ?PageBlock
    {
        return PageBlock::query()
            ->where('page', 'home')
            ->where('key', $key)
            ->first();
    }

    protected function upsertHomeBlock(string $key, array $attributes): void
    {
        PageBlock::query()->updateOrCreate(
            ['page' => 'home', 'key' => $key],
            array_merge([
                'subtitle' => null,
                'cta_label' => null,
                'cta_url' => null,
                'secondary_cta_label' => null,
                'secondary_cta_url' => null,
                'meta' => [],
            ], $attributes),
        );
    }
}
