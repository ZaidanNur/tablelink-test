<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use PhpParser\Node\Expr\Array_;

class FlightService
{
    /**
     * Search flights based on criteria
     * Simulates/mocks flight data from Tiket.com
     *
     * @param array $criteria
     * @return array
     */
    public function searchFlights(array $criteria = []): array
    {
        $origin = $criteria['origin'] ?? 'CGK';
        $destination = $criteria['destination'] ?? 'DPS';
        $maxDepartureTime = $criteria['max_departure_time'] ?? '17:00';
        $flightClass = $criteria['class'] ?? 'Economy';

        $allFlights = $this->getMockFlightData();

        return $allFlights;
    }

    /**
     * Get all flights without filtering
     *
     * @return array
     */
    public function getAllFlights(): array
    {
        return $this->getMockFlightData();
    }

    /**
     * Get mock flight data simulating Tiket.com response
     *
     * @return array
     */
    private function getMockFlightData()
    {
        $today = Carbon::today()->format('Y-m-d');
        
        return [
            [
                'id' => 1,
                'airline_name' => 'Garuda Indonesia',
                'flight_number' => 'GA-410',
                'departure_time' => $today . ' 06:00:00',
                'arrival_time' => $today . ' 07:45:00',
                'price' => 1250000,
                'price_formatted' => 'Rp 1.250.000',
                'origin' => 'CGK',
                'origin_city' => 'Jakarta',
                'destination' => 'DPS',
                'destination_city' => 'Bali',
                'class' => 'Economy',
                'type' => 'One-way',
                'duration' => '1h 45m',
            ],
            [
                'id' => 2,
                'airline_name' => 'Lion Air',
                'flight_number' => 'JT-18',
                'departure_time' => $today . ' 07:30:00',
                'arrival_time' => $today . ' 09:15:00',
                'price' => 850000,
                'price_formatted' => 'Rp 850.000',
                'origin' => 'CGK',
                'origin_city' => 'Jakarta',
                'destination' => 'DPS',
                'destination_city' => 'Bali',
                'class' => 'Economy',
                'type' => 'One-way',
                'duration' => '1h 45m',
            ],
            [
                'id' => 3,
                'airline_name' => 'Citilink',
                'flight_number' => 'QG-642',
                'departure_time' => $today . ' 09:00:00',
                'arrival_time' => $today . ' 10:50:00',
                'price' => 720000,
                'price_formatted' => 'Rp 720.000',
                'origin' => 'CGK',
                'origin_city' => 'Jakarta',
                'destination' => 'DPS',
                'destination_city' => 'Bali',
                'class' => 'Economy',
                'type' => 'Round-trip',
                'duration' => '1h 50m',
            ],
            [
                'id' => 4,
                'airline_name' => 'Batik Air',
                'flight_number' => 'ID-6502',
                'departure_time' => $today . ' 11:15:00',
                'arrival_time' => $today . ' 13:00:00',
                'price' => 980000,
                'price_formatted' => 'Rp 980.000',
                'origin' => 'CGK',
                'origin_city' => 'Jakarta',
                'destination' => 'DPS',
                'destination_city' => 'Bali',
                'class' => 'Economy',
                'type' => 'One-way',
                'duration' => '1h 45m',
            ],
            [
                'id' => 5,
                'airline_name' => 'AirAsia',
                'flight_number' => 'QZ-7516',
                'departure_time' => $today . ' 14:30:00',
                'arrival_time' => $today . ' 16:20:00',
                'price' => 650000,
                'price_formatted' => 'Rp 650.000',
                'origin' => 'CGK',
                'origin_city' => 'Jakarta',
                'destination' => 'DPS',
                'destination_city' => 'Bali',
                'class' => 'Economy',
                'type' => 'Round-trip',
                'duration' => '1h 50m',
            ],
            [
                'id' => 6,
                'airline_name' => 'Garuda Indonesia',
                'flight_number' => 'GA-414',
                'departure_time' => $today . ' 16:45:00',
                'arrival_time' => $today . ' 18:30:00',
                'price' => 1350000,
                'price_formatted' => 'Rp 1.350.000',
                'origin' => 'CGK',
                'origin_city' => 'Jakarta',
                'destination' => 'DPS',
                'destination_city' => 'Bali',
                'class' => 'Economy',
                'type' => 'One-way',
                'duration' => '1h 45m',
            ],
            [
                'id' => 7,
                'airline_name' => 'Lion Air',
                'flight_number' => 'JT-24',
                'departure_time' => $today . ' 18:00:00',
                'arrival_time' => $today . ' 19:45:00',
                'price' => 920000,
                'price_formatted' => 'Rp 920.000',
                'origin' => 'CGK',
                'origin_city' => 'Jakarta',
                'destination' => 'SUB',
                'destination_city' => 'Surabaya',
                'class' => 'Economy',
                'type' => 'One-way',
                'duration' => '1h 45m',
            ],
            [
                'id' => 8,
                'airline_name' => 'Sriwijaya Air',
                'flight_number' => 'SJ-270',
                'departure_time' => $today . ' 08:45:00',
                'arrival_time' => $today . ' 10:35:00',
                'price' => 780000,
                'price_formatted' => 'Rp 780.000',
                'origin' => 'CGK',
                'origin_city' => 'Jakarta',
                'destination' => 'DPS',
                'destination_city' => 'Bali',
                'class' => 'Economy',
                'type' => 'One-way',
                'duration' => '1h 50m',
            ],
            [
                'id' => 9,
                'airline_name' => 'Garuda Indonesia',
                'flight_number' => 'GA-412',
                'departure_time' => $today . ' 10:00:00',
                'arrival_time' => $today . ' 11:45:00',
                'price' => 3500000,
                'price_formatted' => 'Rp 3.500.000',
                'origin' => 'CGK',
                'origin_city' => 'Jakarta',
                'destination' => 'DPS',
                'destination_city' => 'Bali',
                'class' => 'Business',
                'type' => 'Round-trip',
                'duration' => '1h 45m',
            ],
        ];
    }
}
