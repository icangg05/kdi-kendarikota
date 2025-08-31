<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PermohonanInformasi extends Model
{
  protected $table      = 'permohonan_informasi';
  protected $guarded    = [''];
  public    $timestamps = false;

  protected static function booted(): void
  {
    static::updating(function (PermohonanInformasi $data) {
      // cek apakah field lampiran berubah
      if ($data->isDirty('lampiran')) {
        $oldFile = $data->getOriginal('lampiran');

        if ($oldFile && Storage::disk('public')->exists($oldFile)) {
          Storage::disk('public')->delete($oldFile);
        }
      }
    });


    static::deleting(function (PermohonanInformasi $data) {
      // Hapus file foto_ktp jika ada
      if ($data->foto_ktp && Storage::disk('public')->exists($data->foto_ktp)) {
        Storage::disk('public')->delete($data->foto_ktp);
      }

      // Hapus juga data terkait di pengajuan_keberatan
      PengajuanKeberatan::where('nomor_registrasi', $data->nomor_registrasi)->delete();
    });
  }
}
