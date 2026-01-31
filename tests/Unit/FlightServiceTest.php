<?php

namespace Tests\Unit;

use App\Services\FlightService;
use Tests\TestCase;

class FlightServiceTest extends TestCase
{
    protected FlightService $flightService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->flightService = new FlightService();
    }

    /** @test */
    public function it_can_get_all_flights()
    {
        $flights = $this->flightService->getAllFlights();

        $this->assertIsArray($flights);
        $this->assertNotEmpty($flights);
        
        // Use count($flights) as it returns array now
        $this->assertCount(9, $flights); 
        
        $firstFlight = $flights[0];
        $this->assertArrayHasKey('airline_name', $firstFlight);
        $this->assertArrayHasKey('flight_number', $firstFlight);
        $this->assertArrayHasKey('price', $firstFlight);
    }

    /** @test */
    public function it_can_search_flights_returns_all_by_default()
    {
        // Based on current implementation which returns all flights for search
        $results = $this->flightService->searchFlights([]);

        $this->assertIsArray($results);
        $this->assertCount(9, $results);
    }
}
