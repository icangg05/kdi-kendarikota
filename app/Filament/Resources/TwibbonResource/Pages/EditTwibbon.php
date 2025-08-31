<?php

namespace App\Filament\Resources\TwibbonResource\Pages;

use App\Filament\Resources\TwibbonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTwibbon extends EditRecord
{
    protected static string $resource = TwibbonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
