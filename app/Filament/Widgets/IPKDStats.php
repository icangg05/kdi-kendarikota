<?php

namespace App\Filament\Widgets;

use App\Models\DokumenIPKD;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class IPKDStats extends BaseWidget
{
  protected function getStats(): array
  {
    if (Auth::user()->role == 'admin-ppid') {
      $stats = [];

      // Ambil tahun_pelaporan yang tersedia
      $years = DokumenIPKD::whereNotNull('tahun_pelaporan')
        ->distinct()
        ->orderByDesc('tahun_pelaporan')
        ->pluck('tahun_pelaporan');

      foreach ($years as $tahun) {
        // Hitung jumlah dokumen berdasarkan tahun_pelaporan
        $jumlah = DokumenIPKD::where('tahun_pelaporan', $tahun)->count();

        $stats[] = Stat::make("Pelaporan IPKD Tahun $tahun", $jumlah)
          ->description("Dokumen pelaporan IPKD tahun $tahun")
          ->icon('heroicon-o-calendar-days')
          ->color('primary');
      }

      return $stats;
    }

    return [];
  }
}
