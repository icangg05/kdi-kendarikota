<?php

namespace App\Http\Controllers;

use App\Models\DokumenIPKD;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class IPKDController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request, $tahun)
  {
    abort_if(!is_numeric($tahun), 404);
    $search = $request->input('search');

    $query = \App\Models\DokumenIPKD::where('tahun_pelaporan', $tahun)
      ->orderBy('tgl_publish', 'desc');

    if ($search) {
      $query->where('judul', 'like', "%{$search}%");
    }

    return Inertia::render('IPKD', [
      'title'          => 'Dokumen Pelaporan IPKD ' . $tahun,
      'data'           => $query->paginate(20)->appends(['search' => $search]),
      'filters'        => ['search' => $search],
      'tahun'          => $tahun,
    ]);
  }


  /**
   * Display the specified data.
   */
  public function show($id)
  {
    $data = DokumenIPKD::findOrFail($id);
    $isArchive = preg_match('/\.(zip|rar)$/i', $data->lampiran);

    return Inertia::render('IPKDDetail', [
      'tahun'     => Carbon::parse($data->tgl_publish)->format('Y'),
      'data'      => $data,
      'isArchive' => $isArchive,
    ]);
  }


  /**
   * Download the specified resource from storage.
   */
  public function download($id)
  {
    $data = DokumenIPKD::findOrFail($id);

    if ($data->lampiran) {
      $extension = pathinfo($data->lampiran, PATHINFO_EXTENSION);

      $fileName = $data->judul . ' - Pelaporan ' . $data->tahun_pelaporan;
      $fileName = preg_replace('/[\/\\\:\*\?\"\<\>\|]+/', ' ', $fileName);

      $fileName = trim($fileName);
      $fileName .= '.' . $extension;

      $filePath = Storage::disk('public')->path($data->lampiran);

      return response()->download(
        $filePath,
        $fileName
      );
    }

    abort(404, 'Dokumen tidak ditemukan');
  }
}
