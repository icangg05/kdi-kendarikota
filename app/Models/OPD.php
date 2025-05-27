<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class OPD extends Model
{
  protected $table = 'opd';
  protected $guarded = [''];
  public $timestamps = false;

  protected $casts = [
    'files' => 'json'
  ];

  protected static function booted(): void
  {
    static::deleted(function (OPD $opd) {
      foreach ($opd->files as $file) {
        if (Storage::disk('public')->exists($file)) {
          Storage::disk('public')->delete($file);
        }
      }
    });

    static::updating(function (OPD $opd) {
      if ($opd->files != null) {
        $filesToDelete = array_diff($opd->getOriginal('files'), $opd->files);

        foreach ($filesToDelete as $file) {
          if (Storage::disk('public')->exists($file)) {
            Storage::disk('public')->delete($file);
          }
        }
      }
    });
  }

  public function pejabat(): HasMany
  {
    return $this->hasMany(Pejabat::class);
  }

  public function kategori(): BelongsTo
  {
    return $this->belongsTo(KategoriOPD::class, 'kategori_opd_id');
  }
}
