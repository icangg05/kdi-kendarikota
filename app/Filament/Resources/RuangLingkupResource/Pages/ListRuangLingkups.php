<?php

namespace App\Filament\Resources\RuangLingkupResource\Pages;

use App\Filament\Resources\RuangLingkupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRuangLingkups extends ListRecords
{
    protected static string $resource = RuangLingkupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
