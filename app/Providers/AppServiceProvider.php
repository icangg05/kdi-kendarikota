<?php

namespace App\Providers;

use App\Models\Aplikasi;
use App\Models\Infografis;
use App\Models\Pejabat;
use App\Models\Slider;
use App\Models\Twibbon;
use App\Observers\AplikasiObserver;
use App\Observers\InfografisObserver;
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

    // Sapu sisa upload PHP tiap ada aktivitas Livewire (buka form, klik, upload).
    // ponytail: nebeng request, bukan cron — kita tidak punya akses ke server.
    // Pindahkan ke Schedule kalau nanti cron di server sudah benar-benar jalan.
    if (request()->is('livewire/*')) {
      self::sweepStaleUploadTemps(sys_get_temp_dir());
    }

    Pejabat::observe(PejabatObserver::class);
    Aplikasi::observe(AplikasiObserver::class);
    Infografis::observe(InfografisObserver::class);
    Twibbon::observe(TwibbonObserver::class);
    Slider::observe(SliderObserver::class);
    // OPD::observe(OPDObserver::class);
  }

  /**
   * Hapus sisa upload PHP yang nyangkut (mis. /tmp/phpA7f3K2).
   *
   * PHP menaruh tiap file yang diupload di upload_tmp_dir (default /tmp) dan
   * baru menghapusnya kalau request selesai normal. Upload yang putus di
   * tengah jalan — timeout, koneksi drop, user menekan "coba lagi" — tidak
   * pernah dibersihkan siapa pun, menumpuk sampai /tmp penuh dan semua upload
   * berikutnya ikut gagal.
   *
   * Berjalan sebagai www-data, jadi hanya menyentuh file milik PHP sendiri.
   * Kalau php-fpm memakai PrivateTmp, sys_get_temp_dir() sudah menunjuk ke
   * /tmp privat itu — justru satu-satunya cara mudah membersihkannya.
   *
   * @param  int  $minAge  Umur minimum (detik) sebelum file dianggap sampah.
   *                       Default 1 jam supaya tidak membunuh upload yang
   *                       masih berjalan di request lain.
   * @return int  Jumlah file yang terhapus.
   */
  public static function sweepStaleUploadTemps(string $dir, int $minAge = 3600): int
  {
    $batas = time() - $minAge;
    $terhapus = 0;

    // Pola 'php' + 6 karakter acak, persis format tempnam() milik PHP, supaya
    // tidak menyenggol php-fpm.sock atau file lain yang kebetulan berawalan php.
    foreach (glob(rtrim($dir, '/') . '/php??????') ?: [] as $sisa) {
      $diubah = @filemtime($sisa);

      // filemtime() bisa false kalau request lain sudah menghapusnya duluan.
      if ($diubah !== false && $diubah < $batas && is_file($sisa) && @unlink($sisa)) {
        $terhapus++;
      }
    }

    return $terhapus;
  }
}
