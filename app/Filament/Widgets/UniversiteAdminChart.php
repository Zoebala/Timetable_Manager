<?php

namespace App\Filament\Widgets;

use App\Models\Universite;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class UniversiteAdminChart extends ChartWidget
{
    protected static ?string $heading = 'Universités/Institutions';
    // protected static ?int $sort=1;

    protected function getData(): array
    {
        $data = Trend::model(Universite::class)
        ->between(
            start: now()->startOfMonth(),
            end: now()->endOfMonth(),
        )
        ->perDay()
        ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Universités/Institutions',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];

    }

    protected function getType(): string
    {
        return 'line';
    }
}
