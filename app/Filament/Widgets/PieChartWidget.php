<?php

namespace App\Filament\Widgets;

use App\Services\DashboardStatsService;
use Filament\Widgets\ChartWidget;

class PieChartWidget extends ChartWidget
{
    protected ?string $heading = 'User Role Distribution';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $dashboardService = app(DashboardStatsService::class);
        $chartData = $dashboardService->getPieChartData();

        return [
            'datasets' => [
                [
                    'label' => $chartData['datasets'][0]['label'] ?? 'Role Distribution',
                    'data' => $chartData['datasets'][0]['data'] ?? [],
                    'backgroundColor' => [
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                    ],
                    'hoverOffset' => 4,
                ],
            ],
            'labels' => $chartData['labels'] ?? [],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
