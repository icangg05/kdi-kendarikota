<?php

namespace App\Filament\Resources\DirektoriResource\Pages;

use App\Filament\Resources\DirektoriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDirektori extends EditRecord
{
    protected static string $resource = DirektoriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
