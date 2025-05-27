<?php

namespace App\Filament\Resources\YoutubeResource\Pages;

use App\Filament\Resources\YoutubeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListYoutubes extends ListRecords
{
    protected static string $resource = YoutubeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
