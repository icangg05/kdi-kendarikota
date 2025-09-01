<?php

namespace App\Filament\AdminPPID\Resources\InformasiBerkalaResource\Pages;

use App\Filament\AdminPPID\Resources\InformasiBerkalaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\DokumenPPID;
use Illuminate\Support\Str;

class EditInformasiBerkala extends EditRecord
{
  protected static string $resource = InformasiBerkalaResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make(),
    ];
  }

  protected function mutateFormDataBeforeSave(array $data): array
  {
    // hanya generate slug baru jika judul berubah
    if ($data['judul'] !== $this->record->judul) {
      $data['slug'] = $this->generateUniqueSlug($data['judul'], $this->record->id);
    } else {
      $data['slug'] = $this->record->slug;
    }

    return $data;
  }

  private function generateUniqueSlug(string $judul, ?int $ignoreId = null): string
  {
    $slug     = Str::slug($judul);
    $original = $slug;
    $counter  = 1;

    while (
      DokumenPPID::where('slug', $slug)
      ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
      ->exists()
    ) {
      $slug = $original . '-' . $counter++;
    }

    return $slug;
  }
}
