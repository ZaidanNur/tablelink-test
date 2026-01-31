<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FlightService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function __construct(
        protected FlightService $flightService
    ) {}

    /**
     * Get flight information
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $criteria = [
            'origin' => $request->input('origin', 'CGK'),
            'destination' => $request->input('destination', 'DPS'),
            'max_departure_time' => $request->input('max_departure_time', '17:00'),
            'class' => $request->input('class', 'Economy'),
        ];

        $flights = $this->flightService->getAllFlights();

        return response()->json([
            'success' => true,
            'message' => 'Flights retrieved successfully',
            'data' => [
                'criteria' => $criteria,
                'count' => count($flights),
                'flights' => $flights,
            ],
        ]);
    }
}
