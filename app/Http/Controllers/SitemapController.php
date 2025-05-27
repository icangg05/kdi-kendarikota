<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
