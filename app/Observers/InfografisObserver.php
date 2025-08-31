<?php

namespace App\Observers;

use App\Models\Infografis;
use Illuminate\Support\Facades\Storage;

class InfografisObserver
{
  /**
   * Handle the Infografis "created" event.
   */
  public function created(Infografis $infografis): void
  {
    //
  }

  /**
   * Handle the Infografis "updated" event.
   */
  public function updated(Infografis $infografis): void
  {
    if ($infografis->isDirty('img') && $oldImg = $infografis->getOriginal('img')) {
      Storage::disk('public')->delete($oldImg);
    }
  }

  /**
   * Handle the Infografis "deleted" event.
   */
  public function deleted(Infografis $infografis): void
  {
    if (! is_null($infografis->img)) {
      Storage::disk('public')->delete($infografis->img);
    }
  }

  /**
   * Handle the Infografis "restored" event.
   */
  public function restored(Infografis $infografis): void
  {
    //
  }

  /**
   * Handle the Infografis "force deleted" event.
   */
  public function forceDeleted(Infografis $infografis): void
  {
    //
  }
}
