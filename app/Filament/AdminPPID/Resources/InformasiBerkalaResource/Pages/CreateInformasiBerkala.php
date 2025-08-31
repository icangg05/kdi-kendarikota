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
    $data['slug'] = Str::slug($data['judul']);
    return $data;
  }

  // private function generateUniqueSlug(string $judul): string
  // {
  //   $slug     = Str::slug($judul);
  //   $original = $slug;
  //   $counter  = 1;

  //   while (DokumenPPID::where('slug', $slug)->exists()) {
  //     $slug = $original . '-' . $counter++;
  //   }

  //   return $slug;
  // }
}
