<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\CampStatsOverview;
use App\Filament\Widgets\LatestRegistrationsWidget;
use App\Filament\Widgets\UpcomingEventsWidget;
use App\Filament\Widgets\WelcomeBannerWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login()
            ->favicon(asset('images/camp-des-iles-logo.webp'))
            ->brandName('Camp Des Îles')
            ->colors([
                'primary' => [
                    50 => '#e2f4f7',
                    100 => '#c6eaef',
                    200 => '#9bd5df',
                    300 => '#6bb9c6',
                    400 => '#3999a9',
                    500 => '#1f7d8c',
                    600 => '#15616d',
                    700 => '#124d57',
                    800 => '#103e46',
                    900 => '#0d3238',
                    950 => '#071b1f',
                ],
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                WelcomeBannerWidget::class,
                CampStatsOverview::class,
                LatestRegistrationsWidget::class,
                UpcomingEventsWidget::class,
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
