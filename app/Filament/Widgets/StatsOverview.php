<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Pejabat;
use App\Models\Aplikasi;
use App\Models\OPD;

class StatsOverview extends BaseWidget
{
  protected function getStats(): array
  {
    return [
      // Widget untuk Pejabat Pemerintah
      Stat::make('Pejabat Pemerintah', Pejabat::whereNotIn('jabatan_id', [1, 2])->count())
        ->description('Jumlah pejabat pemerintah Kota Kendari')
        ->icon('heroicon-o-users'),

      // Widget untuk Aplikasi Kendarikota
      Stat::make('Aplikasi Kendarikota', Aplikasi::count())
        ->description('Jumlah aplikasi Kota Kendari')
        ->icon('heroicon-o-computer-desktop'),

      // Widget untuk OPD
      Stat::make('Organisasi Perangkat Daerah', OPD::count())
        ->description('Jumlah OPD Kota Kendari')
        ->icon('heroicon-o-building-office'),
    ];
  }
}
