<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pejabat extends Model
{
  protected $table = 'pejabat';
  protected $guarded = [''];

  public $timestamps = false;

  public function jabatan(): BelongsTo
  {
    return $this->belongsTo(Jabatan::class);
  }

  public function opd(): BelongsTo
  {
    return $this->belongsTo(OPD::class);
  }
}
