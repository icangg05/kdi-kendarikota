<?php

namespace App\Observers;

use App\Models\OPD;
use Illuminate\Support\Facades\Storage;

class OPDObserver
{
  public function updated(OPD $opd): void
  {
    if ($opd->isDirty('struktur_new') && $oldfoto = $opd->getOriginal('struktur_new')) {
      Storage::disk('public')->delete($oldfoto);
    }
  }

  /**
   * Handle the Pejabat "deleted" event.
   */
  public function deleted(OPD $opd): void
  {
    if (! is_null($opd->struktur_new)) {
      Storage::disk('public')->delete($opd->struktur_new);
    }
  }
}
