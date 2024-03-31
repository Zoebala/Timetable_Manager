<?php

namespace App\Filament\Resources\EnseignantResource\Pages;

use Filament\Actions;
use Livewire\Attributes\On;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\EnseignantResource;
use App\Filament\Resources\EnseignantResource\Widgets\CreateEnseignantWidget;

class ListEnseignants extends ListRecords
{
    protected static string $resource = EnseignantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CreateEnseignantWidget::class,
        ];
    }

    #[On('enseignant-created')]
    public function refresh() {}
}
