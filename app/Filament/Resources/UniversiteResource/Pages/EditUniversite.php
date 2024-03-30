<?php

namespace App\Filament\Resources\UniversiteResource\Pages;

use App\Filament\Resources\UniversiteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUniversite extends EditRecord
{
    protected static string $resource = UniversiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
