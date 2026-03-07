<?php

namespace App\Providers\Filament;

use App\Filament\Resources\Homes\HomeResource;
use App\Filament\Resources\Stats\StatResource;
use App\Filament\Resources\Abouts\AboutResource;
use App\Filament\Resources\BlogPosts\BlogPostResource;
use App\Filament\Resources\ChatSessions\ChatSessionResource;
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
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')

            ->navigation(function (NavigationBuilder $builder) {
                return $builder->groups([
                    NavigationGroup::make('Sarab')
                        ->items([

                            \Filament\Navigation\NavigationItem::make('Home')
                                ->url(HomeResource::getUrl('index'))
                                ->icon('heroicon-o-photo'),
                                \Filament\Navigation\NavigationItem::make('Projects')
                                ->url(route('filament.sarab.resources.projects.index'))
                                ->icon('heroicon-o-folder'),
                            \Filament\Navigation\NavigationItem::make('Services')
                                ->url(route('filament.sarab.resources.services.index'))
                                ->icon('heroicon-o-wrench-screwdriver'),
                            \Filament\Navigation\NavigationItem::make('Stats')
                                ->url(StatResource::getUrl('index'))
                                ->icon('heroicon-o-chart-bar'),
                            \Filament\Navigation\NavigationItem::make('About')
                                ->url(AboutResource::getUrl('index'))
                                ->icon('heroicon-o-information-circle'),
                            \Filament\Navigation\NavigationItem::make('Blog Posts')
                                ->url(BlogPostResource::getUrl('index'))
                                ->icon('heroicon-o-newspaper'),
                            \Filament\Navigation\NavigationItem::make('Chat Sessions')
                                ->url(ChatSessionResource::getUrl('index'))
                                ->icon('heroicon-o-chat-bubble-left-right'),
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
