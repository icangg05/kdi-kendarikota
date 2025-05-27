<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Arsip extends Model
{
  protected $table = 'arsip';
  protected $guarded = [''];

  public $timestamps = false;

  protected static function booted(): void
  {
    static::deleted(function (Arsip $arsip) {
      if ($arsip->link != null && Storage::disk('public')->exists($arsip->link)) {
        Storage::disk('public')->delete($arsip->link);
      }
    });

    static::updating(function (Arsip $arsip) {
      if ($arsip->isDirty('link') && $oldFile = $arsip->getOriginal('link')) {
        Storage::disk('public')->delete($oldFile);
      }
    });
  }
}
