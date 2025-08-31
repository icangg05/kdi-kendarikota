<?php

namespace App\Filament\AdminPPID\Resources\PermohonanInformasiResource\Pages;

use App\Filament\AdminPPID\Resources\PermohonanInformasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPermohonanInformasis extends ListRecords
{
    protected static string $resource = PermohonanInformasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
