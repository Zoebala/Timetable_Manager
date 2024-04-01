<?php

namespace App\Filament\Resources\SalleResource\Pages;

use Filament\Actions;
use Livewire\Attributes\On;
use App\Filament\Resources\SalleResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\SalleResource\Widgets\CreateSalleWidget;

class ListSalles extends ListRecords
{
    protected static string $resource = SalleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CreateSalleWidget::class,
        ];
    }

    #[On('salle-created')]
    public function refresh() {}
}
