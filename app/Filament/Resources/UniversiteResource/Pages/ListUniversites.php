<?php

namespace App\Filament\Resources\UniversiteResource\Pages;

use App\Filament\Resources\UniversiteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUniversites extends ListRecords
{
    protected static string $resource = UniversiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
