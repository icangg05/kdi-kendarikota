<?php

namespace App\Filament\Resources\YoutubeResource\Pages;

use App\Filament\Resources\YoutubeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditYoutube extends EditRecord
{
    protected static string $resource = YoutubeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
