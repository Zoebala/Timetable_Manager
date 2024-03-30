<?php

namespace App\Filament\Resources\UniversiteResource\Pages;

use App\Filament\Resources\UniversiteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUniversite extends CreateRecord
{
    protected static string $resource = UniversiteResource::class;

    protected function getCreatedNotificationTitle(): ? string
    {
        return "Enregistrement effectué avec succès!";
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
