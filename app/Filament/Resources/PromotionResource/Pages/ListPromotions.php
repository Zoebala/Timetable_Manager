<?php

namespace App\Filament\Resources\PromotionResource\Pages;

use Filament\Actions;
use Livewire\Attributes\On;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PromotionResource;
use App\Filament\Resources\PromotionResource\Widgets\CreatePromotionWidget;

class ListPromotions extends ListRecords
{
    protected static string $resource = PromotionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CreatePromotionWidget::class,
        ];
    }
    #[On('promotion-created')]
    public function refresh() {}
}
