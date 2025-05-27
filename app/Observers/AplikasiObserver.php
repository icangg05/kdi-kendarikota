<?php

namespace App\Observers;

use App\Models\Aplikasi;
use Illuminate\Support\Facades\Storage;

class AplikasiObserver
{
  /**
   * Handle the Aplikasi "created" event.
   */
  public function created(Aplikasi $aplikasi): void
  {
    //
  }

  /**
   * Handle the Aplikasi "updated" event.
   */
  public function updated(Aplikasi $aplikasi): void
  {
    if ($aplikasi->isDirty('icon') && $oldIcon = $aplikasi->getOriginal('icon')) {
      Storage::disk('public')->delete($oldIcon);
    }
  }

  /**
   * Handle the Aplikasi "deleted" event.
   */
  public function deleted(Aplikasi $aplikasi): void
  {
    if (! is_null($aplikasi->icon)) {
      Storage::disk('public')->delete($aplikasi->icon);
    }
  }

  /**
   * Handle the Aplikasi "restored" event.
   */
  public function restored(Aplikasi $aplikasi): void
  {
    //
  }

  /**
   * Handle the Aplikasi "force deleted" event.
   */
  public function forceDeleted(Aplikasi $aplikasi): void
  {
    //
  }
}
