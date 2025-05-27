<?php

namespace App\Observers;

use App\Models\Pejabat;
use Illuminate\Support\Facades\Storage;

class PejabatObserver
{
  /**
   * Handle the Pejabat "created" event.
   */
  public function created(Pejabat $pejabat): void
  {
    //
  }

  /**
   * Handle the Pejabat "updated" event.
   */
  public function updated(Pejabat $pejabat): void
  {
    if ($pejabat->isDirty('foto') && $oldfoto = $pejabat->getOriginal('icon')) {
      Storage::disk('public')->delete($oldfoto);
    }
  }

  /**
   * Handle the Pejabat "deleted" event.
   */
  public function deleted(Pejabat $pejabat): void
  {
    if (! is_null($pejabat->foto)) {
      Storage::disk('public')->delete($pejabat->foto);
    }
  }

  /**
   * Handle the Pejabat "restored" event.
   */
  public function restored(Pejabat $pejabat): void
  {
    //
  }

  /**
   * Handle the Pejabat "force deleted" event.
   */
  public function forceDeleted(Pejabat $pejabat): void
  {
    //
  }
}
