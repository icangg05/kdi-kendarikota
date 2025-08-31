<?php

namespace App\Filament\AdminPPID\Resources\PermohonanInformasiResource\Pages;

use App\Filament\AdminPPID\Resources\PermohonanInformasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPermohonanInformasi extends EditRecord
{
    protected static string $resource = PermohonanInformasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
