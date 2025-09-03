<?php

namespace App\Filament\Resources\RuangLingkupResource\Pages;

use App\Filament\Resources\RuangLingkupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRuangLingkup extends EditRecord
{
    protected static string $resource = RuangLingkupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
