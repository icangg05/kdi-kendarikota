<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\IPKDStats;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminIpkdPanelProvider extends PanelProvider
{
  public function panel(Panel $panel): Panel
  {
    return $panel
      ->id('admin-ipkd')
      ->brandName('Admin IPKD')
      ->path('admin-ipkd')
      ->colors([
        'primary' => Color::Blue,
      ])
      ->discoverResources(in: app_path('Filament/AdminIpkd/Resources'), for: 'App\\Filament\\AdminIpkd\\Resources')
      ->discoverPages(in: app_path('Filament/AdminIpkd/Pages'), for: 'App\\Filament\\AdminIpkd\\Pages')
      ->pages([
        Pages\Dashboard::class,
      ])
      ->discoverWidgets(in: app_path('Filament/AdminIpkd/Widgets'), for: 'App\\Filament\\AdminIpkd\\Widgets')
      ->widgets([
        IPKDStats::class,
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
      ])
      ->login()
      ->homeUrl('/admin-ipkd');;
  }
}
