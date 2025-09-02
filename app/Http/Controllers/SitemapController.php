<?php

namespace App\Http\Controllers;

use App\Models\PPID;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
  public function index()
  {
    if (file_exists(public_path('sitemap.xml'))) {
      unlink(public_path('sitemap.xml'));
    }

    $sitemap = Sitemap::create();

    // Tambahkan URL ke sitemap
    $sitemap->add(Url::create('/')
      ->setLastModificationDate(now())
      ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
      ->setPriority(1.0));

    $sitemap->add(Url::create('/kendari-kita/sejarah-kota-kendari')
      ->setLastModificationDate(now())
      ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
      ->setPriority(0.8));

    $sitemap->add(Url::create('/kendari-kita/visi-misi')
      ->setLastModificationDate(now())
      ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
      ->setPriority(0.8));

    $sitemap->add(Url::create('/kendari-kita/walikota')
      ->setLastModificationDate(now())
      ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
      ->setPriority(0.8));

    $sitemap->add(Url::create('/kendari-kita/walikota')
      ->setLastModificationDate(now())
      ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
      ->setPriority(0.8));

    $sitemap->add(Url::create('/kendari-kita/wakil-walikota')
      ->setLastModificationDate(now())
      ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
      ->setPriority(0.8));


    // Simpan sitemap ke file
    $sitemap->writeToFile(public_path('sitemap.xml'));

    return response()->file(public_path('sitemap.xml'));
  }

  public function clearUnusedFile()
  {
    // 1. Ambil semua file gambar di folder richeditor/
    $files = Storage::files('richeditor');

    // 2. Ambil semua isi konten dari berbagai tabel/kolom
    $ppidKonten = PPID::pluck('konten')->toArray();

    // 3. Gabungkan seluruh isi konten jadi satu string besar
    $allContent = implode(' ', array_merge($ppidKonten));
    dd($allContent);

    $deleted = 0;
    foreach ($files as $file) {
      $filename = basename($file); // misalnya: gambar.jpg

      // Cek apakah nama file dipakai dalam konten HTML
      if (!str_contains($allContent, $filename)) {
        Storage::delete($file);
        $deleted++;
      }
    }

    $message = "Cleanup complete. Deleted $deleted unused images.";

    dd($message);
  }
}
