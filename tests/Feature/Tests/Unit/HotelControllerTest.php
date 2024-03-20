<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class HotelControllerTest extends TestCase
{
    /**
     * Test fetching hotels without any filters.
     *
     * @return void
     */
    public function testFetchHotelsWithoutFilters()
    {
        $response = $this->get('/api/hotels');

        $response->assertStatus(200)
            ->assertJsonCount(6); // Assuming there are 6 hotels in the response
    }

    /**
     * Test filtering hotels by hotel name.
     *
     * @return void
     */
    public function testFilterHotelsByName()
    {
        $response = $this->get('/api/hotels?hotel_name=Media');

        $response->assertStatus(200)
            ->assertJsonCount(1); // Assuming there is 1 hotel with the name 'Media' in the response
    }

    /**
     * Test filtering hotels by city.
     *
     * @return void
     */
    public function testFilterHotelsByCity()
    {
        $response = $this->get('/api/hotels?city=Dubai');

        $response->assertStatus(200)
            ->assertJsonCount(1); // Assuming there is 1 hotel located in Dubai in the response
    }

    /**
     * Test filtering hotels by price range.
     *
     * @return void
     */
    public function testFilterHotelsByPriceRange()
    {
        $response = $this->get('/api/hotels?price_range=80:100');

        $response->assertStatus(200)
            ->assertJsonCount(2); // Assuming there are 2 hotels with prices between 80 and 100 in the response
    }

    /**
     * Test filtering hotels by date range.
     *
     * @return void
     */
    public function testFilterHotelsByDateRange()
    {
        $response = $this->get('/api/hotels?date_range=2023-10-10:2023-10-15');

        $response->assertStatus(200)
            ->assertJsonCount(2); // Assuming there are 2 hotels available between the specified date range
    }

    /**
     * Test sorting hotels by name in ascending order.
     *
     * @return void
     */
    public function testSortHotelsByNameAscending()
    {
        $response = $this->get('/api/hotels?sort_by=name&sort_order=asc');

        $response->assertStatus(200);

        $originalHotels = collect($response->json());

        $sortedHotels = $originalHotels->sortBy('name')->values();

        $this->assertEquals($originalHotels->toJson(), $sortedHotels->toJson());
    }

    public function testSortHotelsByPriceDescending()
    {
        $response = $this->get('/api/hotels?sort_by=price&sort_order=desc');

        $response->assertStatus(200);

        $originalHotels = collect($response->json());

        $sortedHotels = $originalHotels->sortByDesc('price')->values();

        $this->assertEquals($originalHotels->toJson(), $sortedHotels->toJson());
    }

}
