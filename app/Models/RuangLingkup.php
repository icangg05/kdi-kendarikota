<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class RuangLingkup extends Model
{
  protected $table   = 'ruang_lingkup';
  protected $guarded = [''];

  public $timestamps = false;

  protected static function booted(): void
  {
    // Hapus file saat update kalau berubah
    static::updating(function (RuangLingkup $data) {
      if ($data->isDirty('lampiran')) {
        $oldFile = $data->getOriginal('lampiran');
        if ($oldFile && Storage::disk('public')->exists($oldFile)) {
          Storage::disk('public')->delete($oldFile);
        }
      }

      if ($data->isDirty('sampul')) {
        $oldFile = $data->getOriginal('sampul');
        if ($oldFile && Storage::disk('public')->exists($oldFile)) {
          Storage::disk('public')->delete($oldFile);
        }
      }
    });

    // Hapus file saat delete
    static::deleted(function (RuangLingkup $data) {
      if ($data->lampiran && Storage::disk('public')->exists($data->lampiran)) {
        Storage::disk('public')->delete($data->lampiran);
      }

      if ($data->sampul && Storage::disk('public')->exists($data->sampul)) {
        Storage::disk('public')->delete($data->sampul);
      }
    });
  }
}
