<?php

namespace App\Http\Controllers;

use App\Models\PengajuanKeberatan;
use App\Models\PermohonanInformasi;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PPIDController extends Controller
{
  /**
   * CEK PERMOHONAN INFORMASI PUBLIK
   */
  public function cekPermohonan(Request $request)
  {
    sleep(1);

    $nik = $request->nik;

    // ambil semua data permohonan sesuai NIK
    $permohonan = PermohonanInformasi::where('nomor_ktp', $nik)->orderBy('tanggal_diajukan', 'desc')->get();

    // kalau tidak ada data
    if ($permohonan->isEmpty()) {
      return response()->json([
        'result' => [[
          'status'  => 'notfound',
          'catatan' => 'Data permohonan tidak ditemukan.'
        ]]
      ]);
    }

    return response()->json(['result' => $permohonan]);
  }


  /**
   * SUBMIT FORM PERMOHONAN
   */
  public function ppidPostPermohonan(Request $request)
  {
    $validated = $request->validate([
      'nama_pemohon'              => 'required|string|max:255',
      'nomor_ktp'                 => 'required|string|min:16|max:16',
      'foto_ktp'                  => 'required|image|mimes:jpg,jpeg,png|max:' . config('app.max_img_size'),
      'nomor_pengesahan'          => 'nullable|string|max:100',
      'alamat'                    => 'required|string',
      'pekerjaan'                 => 'required|string|max:100',
      'no_hp'                     => 'required|string|max:20',
      'email'                     => 'required|email|max:100',
      'rincian_informasi'         => 'required|string',
      'tujuan_permohonan'         => 'required|string',
      'cara_memperoleh_informasi' => 'required|string',
      'mendapatkan_salinan'       => 'required|string',
      'cara_mendapatkan_salinan'  => 'required|string',
    ]);

    // Upload file KTP
    if ($request->hasFile('foto_ktp')) {
      $validated['foto_ktp'] = $request->file('foto_ktp')->store('foto-ktp', 'public');
    }

    // Cari nomor terakhir di tahun ini
    $year = now()->format('Y'); // contoh: 2025
    $last = PermohonanInformasi::whereYear('tanggal_diajukan', $year)
      ->orderByDesc('id')
      ->first();

    if ($last && preg_match('/PPID-' . $year . '(\d+)/', $last->nomor_registrasi, $matches)) {
      $lastNumber = (int) $matches[1];
      $nextNumber = $lastNumber + 1;
    } else {
      $nextNumber = 1;
    }

    // Format jadi PPID-2025001
    $nomorRegistrasi = "PPID-{$year}" . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

    $validated['nomor_registrasi'] = $nomorRegistrasi;
    $validated['tanggal_diajukan'] = now();

    // Simpan ke database
    PermohonanInformasi::create($validated);

    return redirect()->back()->with('success', 'Permohonan berhasil dikirim ✅');
  }


  /**
   * FORM KEBERATAN
   */
  public function formKeberatan()
  {
    return Inertia::render('PPIDFormPengajuan/PPIDFormPengajuan', [
      'title' => 'Permohonan Keberatan',
    ]);
  }

  /**
   * GET PERMOHONAN
   */
  public function getPermohonan(Request $request)
  {
    sleep(1);

    $nomor_registrasi = $request->nomor_registrasi;

    // Cek dulu di tabel pengajuan_keberatan
    $keberatan = PengajuanKeberatan::where('nomor_registrasi', $nomor_registrasi)->first();

    if ($keberatan && $keberatan->status === 'Selesai') {
      return response()->json([
        'result' => [
          'status'  => 'Selesai',
          'catatan' => 'Pengajuan keberatan telah diproses. Silakan periksa di menu "Cek Status Pengajuan Keberatan".',
        ]
      ]);
    }

    // Cek ke tabel permohonan_informasi
    $permohonan = PermohonanInformasi::where('nomor_registrasi', $nomor_registrasi)->first();

    if (!$permohonan) {
      return response()->json([
        'result' => [
          'status'  => 'notfound',
          'catatan' => 'Data permohonan tidak ditemukan.',
        ]
      ]);
    }

    return response()->json([
      'result' => [
        'data'    => $permohonan,
        'status'  => true,
        'catatan' => 'Data permohonan ditemukan.',
      ]
    ]);
  }



  /**
   * SUBMIT FORM KEBERATAN
   */
  public function postFormKeberatan(Request $request)
  {
    $request->validate([
      'nomor_registrasi'     => 'required',
      'tujuan_penggunaan'    => 'required|string',
      'nama_pemohon'         => 'required|string|max:255',
      'alamat_pemohon'       => 'required|string',
      'pekerjaan'            => 'required|string|max:150',
      'no_hp_pemohon'        => 'required|string|max:20',
      'kasus_posisi'         => 'required|string',
      'nama_kuasa_pemohon'   => 'nullable|string|max:255',
      'alamat_kuasa_pemohon' => 'nullable|string',
      'no_hp_kuasa_pemohon'  => 'nullable|string|max:20',
      'alasan'               => 'required',
    ]);


    $dataPermohonan = PermohonanInformasi::where('nomor_registrasi', $request->nomor_registrasi)->first();

    // Simpan data ke database
    PengajuanKeberatan::updateOrCreate(
      // kondisi pencarian
      ['nomor_registrasi' => $request->nomor_registrasi],

      // data yang diupdate / disimpan
      [
        'nomor_ktp'            => $dataPermohonan->nomor_ktp,
        'tujuan_penggunaan'    => $request->tujuan_penggunaan,
        'nama_pemohon'         => $request->nama_pemohon,
        'alamat_pemohon'       => $request->alamat_pemohon,
        'pekerjaan'            => $request->pekerjaan,
        'no_hp_pemohon'        => $request->no_hp_pemohon,
        'kasus_posisi'         => $request->kasus_posisi,
        'nama_kuasa_pemohon'   => $request->nama_kuasa_pemohon,
        'alamat_kuasa_pemohon' => $request->alamat_kuasa_pemohon,
        'no_hp_kuasa_pemohon'  => $request->no_hp_kuasa_pemohon,
        'alasan'               => $request->alasan,
        'tanggal_diajukan'     => now(),
      ]
    );

    return redirect()->back()->with('success', 'Pengajuan keberatan berhasil dikirim ✅');
  }


  /**
   * CEK PENGAJUAN KEBERATAN
   */
  public function cekPengajuanKeberatan(Request $request)
  {
    sleep(1);

    $nik = $request->nik;

    // ambil semua data permohonan sesuai NIK
    $permohonan = PengajuanKeberatan::where('nomor_ktp', $nik)->orderBy('tanggal_diajukan', 'desc')->get();

    // kalau tidak ada data
    if ($permohonan->isEmpty()) {
      return response()->json([
        'result' => [[
          'status'  => 'notfound',
          'catatan' => 'Data pengajuan keberatan tidak ditemukan.'
        ]]
      ]);
    }

    return response()->json(['result' => $permohonan]);
  }
}
