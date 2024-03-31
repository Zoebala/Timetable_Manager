<?php

namespace App\Filament\Resources\CoursResource\Pages;

use Filament\Actions;
use Livewire\Attributes\On;
use App\Filament\Resources\CoursResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CoursResource\Widgets\CreateCoursWidget;

class ListCours extends ListRecords
{
    protected static string $resource = CoursResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
           CreateCoursWidget::class,
        ];
    }


    #[On('cours-created')]
    public function refresh() {}

}
