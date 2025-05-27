<?php

namespace App\Filament\Resources\DirektoriResource\Pages;

use App\Filament\Resources\DirektoriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDirektoris extends ListRecords
{
    protected static string $resource = DirektoriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
