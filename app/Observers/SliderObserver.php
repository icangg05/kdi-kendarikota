<?php

namespace App\Observers;

use App\Models\Slider;
use Illuminate\Support\Facades\Storage;

class SliderObserver
{
  public function updated(Slider $slider): void
  {
    if ($slider->isDirty('image') && $oldImage = $slider->getOriginal('image')) {
      Storage::disk('public')->delete($oldImage);
    }
  }

  public function deleted(Slider $slider): void
  {
    if (! is_null($slider->image)) {
      Storage::disk('public')->delete($slider->image);
    }
  }
}
