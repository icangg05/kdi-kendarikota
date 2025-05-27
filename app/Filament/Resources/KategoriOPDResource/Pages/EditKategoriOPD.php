<?php

namespace App\Filament\Resources\KategoriOPDResource\Pages;

use App\Filament\Resources\KategoriOPDResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKategoriOPD extends EditRecord
{
    protected static string $resource = KategoriOPDResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
