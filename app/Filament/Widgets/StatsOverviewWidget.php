<?php

namespace App\Filament\Widgets;

use App\Services\DashboardStatsService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $dashboardService = app(DashboardStatsService::class);
        $stats = $dashboardService->getAllStats();

        return [
            Stat::make('Total Users', $stats['summary']['total_users'] ?? 0)
                ->description('All registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
            Stat::make('Active Today', $stats['summary']['active_today'] ?? 0)
                ->description('Users logged in today')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('New This Month', $stats['summary']['new_this_month'] ?? 0)
                ->description('Registered this month')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('info'),
        ];
    }
}
