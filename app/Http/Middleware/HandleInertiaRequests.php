<?php

namespace App\Http\Middleware;

use App\Models\Aplikasi;
use App\Models\Direktori;
use App\Models\Pengaturan;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Middleware;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

class HandleInertiaRequests extends Middleware
{
  /**
   * The root template that is loaded on the first page visit.
   *
   * @var string
   */
  protected $rootView = 'app';

  /**
   * Determine the current asset version.
   */
  public function version(Request $request): ?string
  {
    return parent::version($request);
  }

  /**
   * Define the props that are shared by default.
   *
   * @return array<string, mixed>
   */
  public function share(Request $request): array
  {
    $period = Period::create(Carbon::create(2025, 1, 1), now());
    $data   = Analytics::fetchVisitorsAndPageViews($period);

    $analytics = [
      'totalVisitors' => $data->sum('activeUsers'),
      'totalViews'    => $data->sum('screenPageViews'),
      'onlineUsers'   => rand(20, 100),
    ];

    return [
      ...parent::share($request),
      'auth' => [
        'user' => $request->user(),
      ],
      'flash' => [
        'success' => fn() => $request->session()->get('success'),
        'error'   => fn() => $request->session()->get('error'),
      ],

      'aplikasi'        => Aplikasi::limit(12)->get(),
      'globalDirektori' => Direktori::all(),
      'heroPageImage'   => Slider::where('jenis_gambar', 'hero halaman')->first(),
      'analytics'       => $analytics,
      'admin'           => User::where('role', 'admin-kendarikota')->first(),
      'pengaturan'      => Pengaturan::all()->toArray(),
    ];
  }
}
