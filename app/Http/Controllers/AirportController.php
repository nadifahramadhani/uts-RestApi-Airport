<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\AirportService;
use Illuminate\Http\JsonResponse;

class AirportController extends Controller
{
    protected $airportService;

    public function __construct(AirportService $airportService)
    {
        $this->airportService = $airportService;
    }

    public function json()
    {
        return response()->json($this->airportService->fetchAirports());
    }

    public function index(Request $request)
    {
        $airports = $this->airportService->fetchAirports();
        $rows = $airports['rows'] ?? [];
    
        // Filter berdasarkan negara
        if ($request->has('country') && $request->country != '') {
            $rows = array_filter($rows, function ($airport) use ($request) {
                return $airport['country'] == $request->country;
            });
        }
    
        // Pencarian berdasarkan nama, IATA, atau kota
        if ($request->has('search') && $request->search != '') {
            $searchTerm = strtolower($request->search);
            $rows = array_filter($rows, function ($airport) use ($searchTerm) {
                return strpos(strtolower($airport['name']), $searchTerm) !== false ||
                       strpos(strtolower($airport['iata']), $searchTerm) !== false ||
                       strpos(strtolower($airport['city']), $searchTerm) !== false;
            });
        }

    
        return view('airports', ['airports' => ['rows' => $rows]]);
    }

}
