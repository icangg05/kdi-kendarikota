<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Aplikasi;
use App\Models\Arsip;
use App\Models\Direktori;
use App\Models\Download;
use App\Models\Halaman;
use App\Models\Infografis;
use App\Models\KategoriOPD;
use App\Models\Lokasi;
use App\Models\Pejabat;
use App\Models\Pengumuman;
use App\Models\Perda;
use App\Models\Slider;
use App\Models\Twibbon;
use App\Models\Youtube;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class HomeController extends Controller
{
  public function index()
  {
    return Inertia::render('Welcome', [
      'youtube'    => Youtube::limit(3)->orderBy('id', 'desc')->get(),
      'pejabat'    => Pejabat::with(['jabatan'])
        // ->whereNotIn('jabatan_id', [1, 2])
        ->join('jabatan', 'pejabat.jabatan_id', '=', 'jabatan.id')
        ->orderBy('jabatan.sort')
        ->select('pejabat.*')
        ->get(),
      'infografis' => Infografis::limit(4)->orderBy('release', 'desc')->get(),
      'twibbon'    => Twibbon::orderBy('id', 'desc')->first(),
      'slider'     => Slider::where('jenis_gambar', 'slider')->get(),
      'banner'     => Slider::where('jenis_gambar', 'banner')->first(),
    ]);
  }

  public function sejarah()
  {
    return Inertia::render('SejarahVisiMisi', [
      'title' => 'Sejarah Kota Kendari',
      'data' => Halaman::first()
    ]);
  }

  public function visiMisi()
  {
    return Inertia::render('SejarahVisiMisi', [
      'title' => 'Visi & Misi',
      'data' => Halaman::findOrFail(2)
    ]);
  }

  public function menuEvent($menu)
  {
    if ($menu == 'pengumuman') {
      $data = Pengumuman::orderBy('tanggal', 'desc')->get()->map(function ($item) {
        $item->tanggal = Carbon::parse($item->tanggal)->translatedFormat('d F Y');
        return $item;
      });

      return Inertia::render('TablePage', [
        'title' => ucfirst($menu),
        'data'  => $data
      ]);
    } elseif ($menu == 'agenda') {
      return Inertia::render('Agenda', [
        'title' => ucfirst($menu),
        'data'  => Agenda::paginate(10)
      ]);
    }
    return abort(404);
  }

  public function menuArsip()
  {
    $data = Arsip::orderBy('release', 'desc')->get()->map(function ($item) {
      $item->release = Carbon::parse($item->release)->translatedFormat('d F Y');
      return $item;
    });

    return Inertia::render('TablePage', [
      'title' => 'Arsip',
      'data'  => $data
    ]);
  }

  public function menuPerda()
  {
    $data = Perda::orderBy('tanggal', 'desc')->select('no_perda', 'tentang', 'tanggal', 'link')->get()->map(function ($item) {
      $item->tanggal = Carbon::parse($item->tanggal)->translatedFormat('d F Y');
      return $item;
    });

    return Inertia::render('TablePage', [
      'title' => 'Peraturan Daerah',
      'data'  => $data
    ]);
  }

  public function menuStatistik()
  {
    $data = Download::orderBy('tanggal', 'desc')->get()->map(function ($item) {
      $item->tanggal = Carbon::parse($item->tanggal)->translatedFormat('d F Y');
      return $item;
    });

    return Inertia::render('TablePage', [
      'title' => 'Statistik',
      'data'  => $data
    ]);
  }

  public function menuDirektori($direktori)
  {
    $data = Direktori::where('slug', $direktori)
      ->first();
    $lokasi = Lokasi::where('direktori_id', $data->id)
      ->paginate(10);

    return Inertia::render('Direktori', [
      'title' => $data->nama,
      'data' => $lokasi,
    ]);
  }

  public function viewLokasi($direktori, $lokasiId)
  {
    $data = Lokasi::with('direktori')->findOrFail($lokasiId);

    return Inertia::render('DetailLokasi', [
      'title' => $data->direktori->nama,
      'data' => $data,
    ]);
  }

  public function walikota()
  {
    $data = Pejabat::with('jabatan')->where('jabatan_id', 1)->first();
    return Inertia::render('ProfilWalikota', [
      'title' => 'Profil Walikota',
      'data' => $data
    ]);
  }

  public function wakilWalikota()
  {
    $data = Pejabat::with('jabatan')->where('jabatan_id', 2)->first();
    return Inertia::render('ProfilWalikota', [
      'title' => 'Profil Wakil Walikota',
      'data' => $data
    ]);
  }

  public function pejabat()
  {
    $pejabat = Pejabat::with(['jabatan', 'opd'])
      ->whereNotIn('jabatan_id', [1, 2])
      ->join('jabatan', 'pejabat.jabatan_id', '=', 'jabatan.id')
      ->orderBy('jabatan.sort')
      ->select('pejabat.*')
      ->paginate(12);

    return Inertia::render('Pejabat', [
      'title' => 'Pejabat Pemerintah',
      'pejabat' => $pejabat,
    ]);
  }

  public function perangkatDaerah()
  {
    $kategoriOpd = KategoriOPD::with('opd')->get();

    return Inertia::render('PerangkatDaerah', [
      'title' => 'Perangkat Daerah',
      'data'   => $kategoriOpd
    ]);
  }

  public function allSubDomain()
  {
    return Inertia::render('AllSubDomain', [
      'title' => 'Akses Cepat',
      'data' => Aplikasi::paginate(18)
    ]);
  }

  public function allTwibbon()
  {
    return Inertia::render('Twibbon', [
      'title' => 'Twibbon',
      'data' => Twibbon::orderBy('id', 'desc')->paginate(9)
    ]);
  }
}
