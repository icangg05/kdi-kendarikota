<?php

namespace App\Filament\Resources\JabatanResource\Pages;

use App\Filament\Resources\JabatanResource;
use App\Models\Jabatan;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJabatans extends ListRecords
{
  protected static string $resource = JabatanResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make()
        ->mutateFormDataUsing(function (array $data): array {
          $maxSort = Jabatan::max('sort');
          $data['sort'] = $maxSort ? $maxSort + 1 : 1;
          return $data;
        }),
    ];
  }
}
