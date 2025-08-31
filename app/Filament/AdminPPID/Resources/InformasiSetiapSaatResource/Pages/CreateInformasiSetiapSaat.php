<?php

namespace App\Filament\AdminPPID\Resources\InformasiSetiapSaatResource\Pages;

use App\Filament\AdminPPID\Resources\InformasiSetiapSaatResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateInformasiSetiapSaat extends CreateRecord
{
  protected static string $resource = InformasiSetiapSaatResource::class;

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['slug'] = str()->slug($data['judul']);
    return $data;
  }
}
