<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PPID extends Model
{
  protected $table = 'ppid';
  protected $guarded = [''];

  public $timestamps = false;

  protected static function booted(): void
  {
    static::updating(function (PPID $data) {
      if ($data->isDirty('lampiran') && $oldFile = $data->getOriginal('lampiran')) {
        Storage::disk('public')->delete($oldFile);
      }
    });
  }
}
