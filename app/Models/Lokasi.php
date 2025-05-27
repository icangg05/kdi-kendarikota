<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lokasi extends Model
{
  protected $table = 'lokasi';
  protected $guarded = [''];

  public $timestamps = false;

  public function direktori(): BelongsTo
  {
    return $this->belongsTo(Direktori::class);
  }
}
