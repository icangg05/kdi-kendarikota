<?php

namespace App\Filament\Widgets;

use App\Models\DokumenIPKD;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class IPKDStats extends BaseWidget
{
  protected function getStats(): array
  {
    $stats = [];

    // Ambil semua tahun dari tgl_publish (distinct) urut desc
    $years = DokumenIPKD::selectRaw('YEAR(tgl_publish) AS tahun')
      ->distinct()
      ->orderByDesc('tahun')
      ->pluck('tahun');

    foreach ($years as $tahun) {
      $jumlah = DokumenIPKD::whereYear('tgl_publish', $tahun)->count();

      $stats[] = Stat::make("IPKD Tahun $tahun", $jumlah)
        ->description("Jumlah dokumen IPKD tahun $tahun")
        ->icon('heroicon-o-calendar-days')
        ->color('primary');
    }

    return $stats;
  }
}
