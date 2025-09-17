<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Aplikasi;
use App\Models\Arsip;
use App\Models\Direktori;
use App\Models\DokumenPPID;
use App\Models\Download;
use App\Models\Halaman;
use App\Models\Infografis;
use App\Models\KategoriOPD;
use App\Models\Lokasi;
use App\Models\Pejabat;
use App\Models\Pengumuman;
use App\Models\Perda;
use App\Models\PermohonanInformasi;
use App\Models\PPID;
use App\Models\RuangLingkup;
use App\Models\Slider;
use App\Models\Twibbon;
use App\Models\Youtube;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
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
      'data'  => Halaman::first()
    ]);
  }

  public function visiMisi()
  {
    return Inertia::render('SejarahVisiMisi', [
      'title' => 'Visi & Misi',
      'data'  => Halaman::findOrFail(2)
    ]);
  }

  public function ruangLingkup()
  {
    $data = RuangLingkup::first();

    return Inertia::render('SejarahVisiMisi', [
      'title'          => 'Ruang Lingkup',
      'data'           => $data,
      'isRuangLingkup' => request()->is('*ruang-lingkup*'),
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

  /** MENU STATISTIK */
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

  /** MENU PPID */
  public function menuPPID()
  {
    $title                     = 'PPID';
    $menu_ppid                 = PPID::get()->toArray();
    $jumlahDokumen             = DokumenPPID::count();
    $jumlahPermohonanInformasi = PermohonanInformasi::count();
    $jumlahPermohonanDiterima  = PermohonanInformasi::where('status', 'Disetujui')->count();
    $jumlahPermohonanDitolak   = PermohonanInformasi::where('status', 'Ditolak')->count();
    $jumlahUnduhan             = DokumenPPID::sum('total_unduh');
    $jumlahLihat               = DokumenPPID::sum('total_lihat');
    $jumlahBerkala             = DokumenPPID::where('kategori', 'informasi-berkala')->count();
    $jumlahSertaMerta          = DokumenPPID::where('kategori', 'informasi-serta-merta')->count();
    $jumlahSetiapSaat          = DokumenPPID::where('kategori', 'informasi-setiap-saat')->count();

    // dd($jumlahPermohonanDitolak);
    return Inertia::render('PPID/PPID', compact(
      'title',
      'menu_ppid',
      'jumlahDokumen',
      'jumlahPermohonanInformasi',
      'jumlahPermohonanDiterima',
      'jumlahPermohonanDitolak',
      'jumlahUnduhan',
      'jumlahLihat',
      'jumlahBerkala',
      'jumlahSertaMerta',
      'jumlahSetiapSaat',
    ));
  }

  /** MENU PPID - JENIS INFORMASI */
  public function menuPPIDJenisInformasi(Request $request, $jenisInformasi)
  {
    $search = $request->input('search');

    $query = DokumenPPID::with('user')
      ->where('kategori', $jenisInformasi)->orderBy('tanggal_publish', 'desc');

    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('judul', 'like', "%{$search}%")
          ->orWhereHas('user', function ($u) use ($search) {
            $u->where('name', 'like', "%{$search}%");
          });
      });
    }

    return Inertia::render('PPIDJenisInformasi', [
      'title'          => str_replace('-', ' ', $jenisInformasi),
      'jenisInformasi' => $jenisInformasi,
      'data'           => $query->paginate(10)->appends(['search' => $search]),
      'filters'        => ['search' => $search],
    ]);
  }


  /** MENU PPID - JENIS INFORMASI DETAIL */
  public function menuPPIDJenisInformasiDetail($jenisInformasi, $slug)
  {
    $data = DokumenPPID::with('user')->where('slug', $slug)->first();
    abort_if(!$data, 404);
    $data->increment('total_lihat');

    return Inertia::render('PPIDJenisInformasiDetail', [
      'title'          => str()->title(str_replace('-', ' ', $jenisInformasi)),
      'jenisInformasi' => $jenisInformasi,
      'data'           => $data
    ]);
  }

  /** MENU PPID - FORM PERMOHONAN */
  public function menuPPIDFormPermohonan()
  {
    return Inertia::render('PPIDFormPermohonan/PPIDFormPermohonan', [
      'title' => 'Permohonan Informasi',
    ]);
  }


  /** DOWNLOAD DOKUMEN PPID */
  public function downloadDokumenPPID($id)
  {
    $data = DokumenPPID::with('user')->findOrFail($id);
    $data->increment('total_unduh');

    if ($data->lampiran) {
      $extension = pathinfo($data->lampiran, PATHINFO_EXTENSION);

      // kalau ada user, sertakan nama user; kalau tidak, cukup judul saja
      $fileName = $data->judul;
      if ($data->user?->name) {
        $fileName .= '_' . $data->user->name;
      }
      $fileName .= '.' . $extension;

      return Storage::disk('public')->download(
        $data->lampiran, // path file relatif dari storage/app/public
        $fileName        // nama file hasil download
      );
    }

    abort(404, 'Dokumen tidak ditemukan');
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
