<?php

namespace App\Filament\AdminPPID\Resources\InformasiSertaMertaResource\Pages;

use App\Filament\AdminPPID\Resources\InformasiSertaMertaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInformasiSertaMerta extends EditRecord
{
  protected static string $resource = InformasiSertaMertaResource::class;

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
