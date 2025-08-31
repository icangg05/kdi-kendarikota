<?php

namespace App\Filament\AdminPPID\Resources\InformasiSertaMertaResource\Pages;

use App\Filament\AdminPPID\Resources\InformasiSertaMertaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInformasiSertaMertas extends ListRecords
{
    protected static string $resource = InformasiSertaMertaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
