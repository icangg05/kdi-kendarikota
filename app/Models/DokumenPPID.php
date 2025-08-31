<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DokumenPPID extends Model
{
  protected $table = 'dokumen_ppid';
  protected $guarded = [''];

  public $timestamps = false;

  protected static function booted(): void
  {
    static::deleted(function (DokumenPPID $data) {
      if ($data->lampiran != null && Storage::disk('public')->exists($data->lampiran)) {
        Storage::disk('public')->delete($data->lampiran);
      }
    });

    static::updating(function (DokumenPPID $data) {
      if ($data->isDirty('lampiran') && $oldFile = $data->getOriginal('lampiran')) {
        Storage::disk('public')->delete($oldFile);
      }
    });
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'users_id');
  }
}
