<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AirportService
{
    private $apiUrl = 'https://flight-radar1.p.rapidapi.com/airports/list';
    public function fetchAirports()
    {
        $response = Http::withHeaders([
            'x-rapidapi-host' => 'flight-radar1.p.rapidapi.com',
            'x-rapidapi-key' => env('RAPIDAPI_KEY'),
        ])->get($this->apiUrl);

        if ($response->successful()) {
            $data = $response->json();
            return is_array($data) ? $data : [];
        }

        logger("API Error: " . $response->status());
        return [];
    }

    public function getAllData()
    {
        $response = Http::withHeaders([
            'X-RapidAPI-Host' => 'flight-radar1.p.rapidapi.com',
            'X-RapidAPI-Key' => '26e460b776msh45513a9361d7bc8p1569eejsn1ae7bfcfd957'
        ])->get('https://flight-radar1.p.rapidapi.com/airports/list');

        // Ambil hanya bagian 'response' dari hasil JSON
        return $response->json(); // langsung ambil root

    }
    
}
