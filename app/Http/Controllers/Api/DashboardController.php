<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DashboardStatsService;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardStatsService $dashboardStatsService
    ) {}

    /**
     * Get dashboard statistics
     * 
     * @return JsonResponse
     */
    public function stats(): JsonResponse
    {
        $stats = $this->dashboardStatsService->getAllStats();

        return response()->json([
            'success' => true,
            'message' => 'Dashboard statistics retrieved successfully',
            'data' => $stats,
        ]);
    }
}
