<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        // Fetch data from the provided API endpoint
        $response = Http::get('https://api.npoint.io/dd85ed11b9d8646c5709');
        $hotels = $response->json()['hotels'];

        // Apply search filters
        $filteredHotels = $this->filterHotels($hotels, $request);

        // Apply sorting
        $sortedHotels = $this->sortHotels($filteredHotels, $request);

        return response()->json($sortedHotels);
    }

    private function filterHotels($hotels, $request)
    {
        $filteredHotels = $hotels;

        // Filter by hotel name
        if ($request->has('hotel_name')) {
            $filteredHotels = array_filter($filteredHotels, function ($hotel) use ($request) {
                return stripos($hotel['name'], $request->input('hotel_name')) !== false;
            });
        }

        // Filter by destination (city)
        if ($request->has('city')) {
            $filteredHotels = array_filter($filteredHotels, function ($hotel) use ($request) {
                return strtolower($hotel['city']) === strtolower($request->input('city'));
            });
        }

        // Filter by price range
        if ($request->has('price_range')) {
            $priceRange = explode(':', $request->input('price_range'));
            $filteredHotels = array_filter($filteredHotels, function ($hotel) use ($priceRange) {
                return $hotel['price'] >= $priceRange[0] && $hotel['price'] <= $priceRange[1];
            });
        }

        // Filter by date range
        if ($request->has('date_range')) {
            $dateRange = explode(':', $request->input('date_range'));
            $filteredHotels = array_filter($filteredHotels, function ($hotel) use ($dateRange) {
                foreach ($hotel['availability'] as $availability) {
                    if (strtotime($availability['from']) >= strtotime($dateRange[0]) && strtotime($availability['to']) <= strtotime($dateRange[1])) {
                        return true;
                    }
                }
                return false;
            });
        }

        return $filteredHotels;
    }

    private function sortHotels($hotels, $request)
    {
        // Default sorting criteria
        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');

        // Validate sort order
        $sortOrder = in_array(strtolower($sortOrder), ['asc', 'desc']) ? strtolower($sortOrder) : 'asc';

        // Sort hotels based on the specified criteria
        if ($sortBy === 'price') {
            usort($hotels, function ($a, $b) use ($sortOrder) {
                $comparison = $a['price'] - $b['price'];
                return $sortOrder === 'asc' ? $comparison : -$comparison;
            });
        } else {
            usort($hotels, function ($a, $b) use ($sortOrder) {
                $comparison = strcmp($a['name'], $b['name']);
                return $sortOrder === 'asc' ? $comparison : -$comparison;
            });
        }

        return $hotels;
    }


}
