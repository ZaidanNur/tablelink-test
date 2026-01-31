<?php

namespace App\Filament\Widgets;

use App\Services\DashboardStatsService;
use Filament\Widgets\ChartWidget;

class LineChartWidget extends ChartWidget
{
    protected ?string $heading = 'Monthly User Registrations';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $dashboardService = app(DashboardStatsService::class);
        $chartData = $dashboardService->getLineChartData();

        return [
            'datasets' => [
                [
                    'label' => $chartData['datasets'][0]['label'] ?? 'User Registrations',
                    'data' => $chartData['datasets'][0]['data'] ?? [],
                    'borderColor' => '#14b8a6',
                    'backgroundColor' => 'rgba(20, 184, 166, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $chartData['labels'] ?? [],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
