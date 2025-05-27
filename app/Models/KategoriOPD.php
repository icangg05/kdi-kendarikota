<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriOPD extends Model
{
  protected $table = 'kategori_opd';
  protected $guarded = [];

  public $timestamps = false;

  public function opd(): HasMany
  {
    return $this->hasMany(OPD::class, 'kategori_opd_id');
  }
}
