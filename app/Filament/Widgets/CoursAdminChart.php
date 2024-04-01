<?php

namespace App\Filament\Widgets;

use App\Models\Cours;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class CoursAdminChart extends ChartWidget
{
    protected static ?string $heading = 'Cours';
    protected static ?int $sort=3;

    protected function getData(): array
    {
        $data = Trend::model(Cours::class)
        ->between(
            start: now()->startOfMonth(),
            end: now()->endOfMonth(),
        )
        ->perDay()
        ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Cours',
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
