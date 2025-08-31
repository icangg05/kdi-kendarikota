<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
  protected $table = 'download';
  protected $guarded = [''];

  public $timestamps = false;
}
