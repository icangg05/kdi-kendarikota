<?php

namespace App\Filament\Resources\PerdaResource\Pages;

use App\Filament\Resources\PerdaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPerdas extends ListRecords
{
    protected static string $resource = PerdaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
