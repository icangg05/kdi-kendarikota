<?php

namespace App\Filament\AdminPPID\Resources\InformasiSertaMertaResource\Pages;

use App\Filament\AdminPPID\Resources\InformasiSertaMertaResource;
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
    $data['slug'] = Str::slug($data['judul']);
    return $data;
  }
}
