<?php

namespace App\Http\Controllers;

use App\Models\Padukuhan;
use App\Models\Umkm;
use App\Models\Destination;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $padukuhans = Padukuhan::all();
        $umkms = Umkm::where('is_published', true)->get();
        $destinations = Destination::where('is_published', true)->get();

        return view('map.index', compact('padukuhans', 'umkms', 'destinations'));
    }

    public function geojson()
    {
        return response()->json([
            'type' => 'FeatureCollection',
            'features' => []
        ]);
    }
}
