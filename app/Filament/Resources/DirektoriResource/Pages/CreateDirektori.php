<?php

namespace App\Filament\Resources\DirektoriResource\Pages;

use App\Filament\Resources\DirektoriResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDirektori extends CreateRecord
{
  protected static string $resource = DirektoriResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['slug'] = str()->slug($data['nama']);

    return $data;
  }
}
