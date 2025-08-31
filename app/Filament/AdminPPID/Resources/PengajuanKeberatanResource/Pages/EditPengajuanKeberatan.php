<?php

namespace App\Filament\AdminPPID\Resources\PengajuanKeberatanResource\Pages;

use App\Filament\AdminPPID\Resources\PengajuanKeberatanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPengajuanKeberatan extends EditRecord
{
    protected static string $resource = PengajuanKeberatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
