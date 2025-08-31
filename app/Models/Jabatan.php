<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jabatan extends Model
{
  protected $table = 'jabatan';
  protected $guarded = [''];

  public $timestamps = false;

  public function pejabat(): HasMany
  {
    return $this->hasMany(Pejabat::class);
  }
}
