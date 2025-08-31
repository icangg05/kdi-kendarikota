<?php

namespace App\Observers;

use App\Models\Twibbon;
use Illuminate\Support\Facades\Storage;

class TwibbonObserver
{
  /**
   * Handle the Twibbon "created" event.
   */
  public function created(Twibbon $twibbon): void
  {
    //
  }

  /**
   * Handle the Twibbon "updated" event.
   */
  public function updated(Twibbon $twibbon): void
  {
    if ($twibbon->isDirty('img') && $oldImg = $twibbon->getOriginal('img')) {
      Storage::disk('public')->delete($oldImg);
    }
  }

  /**
   * Handle the Twibbon "deleted" event.
   */
  public function deleted(Twibbon $twibbon): void
  {
    if (! is_null($twibbon->img)) {
      Storage::disk('public')->delete($twibbon->img);
    }
  }

  /**
   * Handle the Twibbon "restored" event.
   */
  public function restored(Twibbon $twibbon): void
  {
    //
  }

  /**
   * Handle the Twibbon "force deleted" event.
   */
  public function forceDeleted(Twibbon $twibbon): void
  {
    //
  }
}
