<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\DokumenPPID;
use Illuminate\Support\Facades\Auth;

class PPIDStats extends BaseWidget
{
  protected function getStats(): array
  {
    if (Auth::user()->role != 'admin-kendarikota') {
      // Helper untuk menghitung jumlah dokumen sesuai kategori & role
      $count = function (string $kategori) {
        $query = DokumenPPID::where('kategori', $kategori);

        if (Auth::user()->role === 'admin-opd') {
          $query->where('users_id', Auth::id());
        }

        return $query->count();
      };

      return [
        Stat::make('Informasi Berkala', $count('informasi-berkala'))
          ->description('Jumlah dokumen informasi berkala')
          ->icon('heroicon-o-calendar-days') // ikon kalender lebih cocok utk "berkala"
          ->color('primary'),

        Stat::make('Informasi Serta Merta', $count('informasi-serta-merta'))
          ->description('Jumlah dokumen informasi serta merta')
          ->icon('heroicon-o-bolt') // ikon petir utk keadaan darurat/serta merta
          ->color('warning'),

        Stat::make('Informasi Setiap Saat', $count('informasi-setiap-saat'))
          ->description('Jumlah dokumen informasi setiap saat')
          ->icon('heroicon-o-clock') // ikon jam utk "setiap saat"
          ->color('success'),
      ];
    }

    return [];
  }
}
