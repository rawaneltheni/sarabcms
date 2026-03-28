<?php

namespace App\Providers\Filament;

use App\Filament\Resources\BlogPosts\BlogPostResource;
use App\Filament\Resources\ContactUsResource;
use App\Filament\Resources\Customers\CustomerResource;
use App\Filament\Resources\FooterResource;
use App\Filament\Resources\LegalPages\LegalPageResource;
use App\Filament\Pages\HomepageCms;
use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Services\ServiceResource;
use App\Filament\Resources\SocialLinksResource;
use App\Filament\Resources\Stats\StatResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class SarabPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('sarab')
            ->path('sarab')
            ->login()
            ->brandLogo('https://sarab.tech/public/images/media/17135578102.png')
            ->colors([
                'primary' => Color::Blue,
                'secondary' => Color::Gray,
            ])
            ->resources([
                ProjectResource::class,
                StatResource::class,
                BlogPostResource::class,
                ServiceResource::class,
                CustomerResource::class,
                ContactUsResource::class,
                FooterResource::class,
                \App\Filament\Resources\SocialLinksResource::class,
                LegalPageResource::class,
            ])

            ->navigation(function (NavigationBuilder $builder) {
                return $builder->groups([
                    NavigationGroup::make('Website CMS')
                        ->items([
                            \Filament\Navigation\NavigationItem::make('Homepage CMS')
                                ->url(HomepageCms::getUrl())
                                ->icon('heroicon-o-rectangle-stack'),
                            \Filament\Navigation\NavigationItem::make('Stats')
                                ->url(StatResource::getUrl('index'))
                                ->icon('heroicon-o-chart-bar'),
                            \Filament\Navigation\NavigationItem::make('Projects')
                                ->url(ProjectResource::getUrl('index'))
                                ->icon('heroicon-o-folder'),
                            \Filament\Navigation\NavigationItem::make('Service Cards')
                                ->url(ServiceResource::getUrl('index'))
                                ->icon('heroicon-o-wrench-screwdriver'),
                            \Filament\Navigation\NavigationItem::make('Slider Logos')
                                ->url(CustomerResource::getUrl('index'))
                                ->icon('heroicon-o-photo'),
                            \Filament\Navigation\NavigationItem::make('Blogs')
                                ->url(BlogPostResource::getUrl('index'))
                                ->icon('heroicon-o-newspaper'),
                            \Filament\Navigation\NavigationItem::make('Legal Pages')
                                ->url(LegalPageResource::getUrl('index'))
                                ->icon('heroicon-o-document-text'),
                            \Filament\Navigation\NavigationItem::make('Contact Us')
                                ->url(ContactUsResource::getUrl('index'))
                                ->icon('heroicon-o-envelope'),
                            \Filament\Navigation\NavigationItem::make('Footer')
                                ->url(FooterResource::getUrl('index'))
                                ->icon('heroicon-o-rectangle-group'),
                            \Filament\Navigation\NavigationItem::make('Social Links')
                                ->url(\App\Filament\Resources\SocialLinksResource::getUrl('index'))
                                ->icon('heroicon-o-share'),
                        ]),
                ]);
            })

            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([])

            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
