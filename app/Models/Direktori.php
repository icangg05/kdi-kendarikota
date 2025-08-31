<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Direktori extends Model
{
  protected $table = 'direktori';
  protected $guarded = [''];

  public $timestamps = false;

  public function lokasi(): HasMany
  {
    return $this->hasMany(Lokasi::class);
  }
}
