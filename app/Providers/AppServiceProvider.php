<?php

namespace App\Providers;

use App\Models\Aplikasi;
use App\Models\Infografis;
use App\Models\OPD;
use App\Models\Pejabat;
use App\Models\Slider;
use App\Models\Twibbon;
use App\Observers\AplikasiObserver;
use App\Observers\InfografisObserver;
use App\Observers\OPDObserver;
use App\Observers\PejabatObserver;
use App\Observers\SliderObserver;
use App\Observers\TwibbonObserver;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    Vite::prefetch(concurrency: 3);

    Pejabat::observe(PejabatObserver::class);
    Aplikasi::observe(AplikasiObserver::class);
    Infografis::observe(InfografisObserver::class);
    Twibbon::observe(TwibbonObserver::class);
    Slider::observe(SliderObserver::class);
    // OPD::observe(OPDObserver::class);
  }
}
