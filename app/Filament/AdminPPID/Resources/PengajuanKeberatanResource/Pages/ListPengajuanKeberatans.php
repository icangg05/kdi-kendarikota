<?php

namespace App\Filament\AdminPPID\Resources\PengajuanKeberatanResource\Pages;

use App\Filament\AdminPPID\Resources\PengajuanKeberatanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPengajuanKeberatans extends ListRecords
{
    protected static string $resource = PengajuanKeberatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
