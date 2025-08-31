<?php

namespace App\Filament\AdminPPID\Resources\InformasiSetiapSaatResource\Pages;

use App\Filament\AdminPPID\Resources\InformasiSetiapSaatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInformasiSetiapSaat extends EditRecord
{
  protected static string $resource = InformasiSetiapSaatResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make(),
    ];
  }

  protected function mutateFormDataBeforeSave(array $data): array
  {
    // $recordId = $this->getRecord()?->id;
    $data['slug'] = str()->slug($data['judul']);

    return $data;
  }
}
