<?php

namespace App\Filament\AdminPPID\Resources\InformasiSetiapSaatResource\Pages;

use App\Filament\AdminPPID\Resources\InformasiSetiapSaatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInformasiSetiapSaats extends ListRecords
{
    protected static string $resource = InformasiSetiapSaatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
