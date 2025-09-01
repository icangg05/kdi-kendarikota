<?php

namespace App\Filament\AdminPPID\Resources\InformasiSertaMertaResource\Pages;

use App\Filament\AdminPPID\Resources\InformasiSertaMertaResource;
use App\Models\DokumenPPID;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateInformasiSertaMerta extends CreateRecord
{
  protected static string $resource = InformasiSertaMertaResource::class;

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
