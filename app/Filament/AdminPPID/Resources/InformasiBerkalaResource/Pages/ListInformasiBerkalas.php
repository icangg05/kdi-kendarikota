<?php

namespace App\Filament\AdminPPID\Resources\InformasiBerkalaResource\Pages;

use App\Filament\AdminPPID\Resources\InformasiBerkalaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInformasiBerkalas extends ListRecords
{
    protected static string $resource = InformasiBerkalaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
