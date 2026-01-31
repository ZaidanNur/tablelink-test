<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardStatsService
{
    /**
     * Get line chart data - Monthly user registrations for the last 12 months
     *
     * @return array
     */
    public function getLineChartData(): array
    {
        $months = collect();
        $data = collect();

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months->push($date->format('M Y'));
            
            $count = User::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            $data->push($count);
        }

        return [
            'labels' => $months->toArray(),
            'datasets' => [
                [
                    'label' => 'User Registrations',
                    'data' => $data->toArray(),
                    'borderColor' => 'rgb(75, 192, 192)',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'tension' => 0.1,
                ]
            ]
        ];
    }

    /**
     * Get vertical bar chart data - Daily logins for the last 7 days
     *
     * @return array
     */
    public function getBarChartData(): array
    {
        $days = collect();
        $data = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days->push($date->format('D, M d'));
            
            $count = User::whereDate('last_login', $date->toDateString())->count();
            $data->push($count);
        }

        return [
            'labels' => $days->toArray(),
            'datasets' => [
                [
                    'label' => 'Daily Logins',
                    'data' => $data->toArray(),
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(255, 205, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(201, 203, 207, 0.8)'
                    ],
                    'borderWidth' => 1,
                ]
            ]
        ];
    }

    /**
     * Get pie chart data - User role distribution
     *
     * @return array
     */
    public function getPieChartData(): array
    {
        $adminCount = User::role('Admin')->count();
        $userCount = User::role('User')->count();

        return [
            'labels' => ['Admin', 'User'],
            'datasets' => [
                [
                    'label' => 'Role Distribution',
                    'data' => [$adminCount, $userCount],
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                    ],
                    'hoverOffset' => 4,
                ]
            ]
        ];
    }

    /**
     * Get all stats combined for API endpoint
     *
     * @return array
     */
    public function getAllStats(): array
    {
        return [
            'line_chart' => $this->getLineChartData(),
            'bar_chart' => $this->getBarChartData(),
            'pie_chart' => $this->getPieChartData(),
            'summary' => [
                'total_users' => User::count(),
                'active_today' => User::whereDate('last_login', Carbon::today())->count(),
                'new_this_month' => User::whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->count(),
            ]
        ];
    }
}
