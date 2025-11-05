<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DokumenIPKD extends Model
{
  protected $table = 'dokumen_ipkd';
  protected $guarded = [''];

  public $timestamps = false;

  protected static function booted(): void
  {
    // Hapus file lama ketika field lampiran di-update
    static::updating(function (DokumenIPKD $data) {
      if ($data->isDirty('lampiran') && $oldFile = $data->getOriginal('lampiran')) {
        Storage::disk('public')->delete($oldFile);
      }
    });

    // Hapus file ketika record dihapus
    static::deleting(function (DokumenIPKD $data) {
      if ($data->lampiran) {
        Storage::disk('public')->delete($data->lampiran);
      }
    });
  }
}
