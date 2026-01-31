<?php

namespace App\Filament\Widgets;

use App\Services\DashboardStatsService;
use Filament\Widgets\ChartWidget;

class BarChartWidget extends ChartWidget
{
    protected ?string $heading = 'Daily User Logins';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $dashboardService = app(DashboardStatsService::class);
        $chartData = $dashboardService->getBarChartData();

        return [
            'datasets' => [
                [
                    'label' => $chartData['datasets'][0]['label'] ?? 'Daily Logins',
                    'data' => $chartData['datasets'][0]['data'] ?? [],
                    'backgroundColor' => [
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(249, 115, 22, 0.8)',
                        'rgba(234, 179, 8, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(236, 72, 153, 0.8)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $chartData['labels'] ?? [],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
