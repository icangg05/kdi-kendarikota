<?php

namespace App\Filament\AdminPPID\Resources\InformasiBerkalaResource\Pages;

use App\Filament\AdminPPID\Resources\InformasiBerkalaResource;
use Filament\Actions;
use App\Models\DokumenPPID;
use Illuminate\Support\Str;
use Filament\Resources\Pages\CreateRecord;

class CreateInformasiBerkala extends CreateRecord
{
  protected static string $resource = InformasiBerkalaResource::class;

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['slug'] = $this->generateUniqueSlug($data['judul']);
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
