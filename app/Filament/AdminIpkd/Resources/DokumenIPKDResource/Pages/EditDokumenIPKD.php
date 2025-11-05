<?php

namespace App\Filament\AdminIpkd\Resources\DokumenIPKDResource\Pages;

use App\Filament\AdminIpkd\Resources\DokumenIPKDResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDokumenIPKD extends EditRecord
{
    protected static string $resource = DokumenIPKDResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
