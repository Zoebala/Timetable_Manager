<?php

namespace App\Filament\Resources\UniversiteResource\Pages;

use Filament\Actions;
use Livewire\Attributes\On;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\UniversiteResource;
use App\Filament\Resources\UniversiteResource\Widgets\CreateUniversiteWidget;

class ListUniversites extends ListRecords
{
    protected static string $resource = UniversiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // CreateUniversiteWidget::class,
        ];
    }

    #[On('universite-created')]
    public function refresh() {}
}
