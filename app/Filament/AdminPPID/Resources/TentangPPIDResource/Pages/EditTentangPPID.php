<?php

namespace App\Filament\AdminPPID\Resources\TentangPPIDResource\Pages;

use App\Filament\AdminPPID\Resources\TentangPPIDResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTentangPPID extends EditRecord
{
    protected static string $resource = TentangPPIDResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
