<?php

namespace App\Filament\Resources\ProgrammeResource\Pages;

use Filament\Actions;
use Livewire\Attributes\On;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ProgrammeResource;
use App\Filament\Resources\ProgrammeResource\Widgets\CreateProgrammeWidget;

class ListProgrammes extends ListRecords
{
    protected static string $resource = ProgrammeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CreateProgrammeWidget::class,
        ];
    }

    #[On('programme-created')]
    public function refresh() {}
}
