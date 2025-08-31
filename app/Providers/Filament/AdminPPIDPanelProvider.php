<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\PPIDStats;
use App\Http\Middleware\EnsureAdminPPID;
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

class AdminPPIDPanelProvider extends PanelProvider
{
  public function panel(Panel $panel): Panel
  {
    return $panel
      ->brandName('PPID Kota Kendari')
      // ->favicon(asset('img/kdi-logo.png'))
      // ->brandLogo(asset('img/logo-hitam.svg'))
      // ->darkModeBrandLogo(asset('/img/logo.svg'))

      ->id('adminPPID')
      ->path('admin-ppid')
      ->colors([
        'primary' => Color::Blue,
      ])

      ->navigationGroups([
        'PPID Kota Kendari',
        'Informasi Publik',
        'Pengajuan & Keberatan Informasi Publik',
        'OPD'
      ])

      ->discoverResources(in: app_path('Filament/AdminPPID/Resources'), for: 'App\\Filament\\AdminPPID\\Resources')
      ->discoverPages(in: app_path('Filament/AdminPPID/Pages'), for: 'App\\Filament\\AdminPPID\\Pages')
      ->pages([
        Pages\Dashboard::class,
      ])
      ->discoverWidgets(in: app_path('Filament/AdminPPID/Widgets'), for: 'App\\Filament\\AdminPPID\\Widgets')
      ->widgets([
        // Widgets\AccountWidget::class,
        // Widgets\FilamentInfoWidget::class,
        PPIDStats::class
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
        EnsureAdminPPID::class,
      ])
      ->login()
      ->homeUrl('/admin-ppid');
  }
}
