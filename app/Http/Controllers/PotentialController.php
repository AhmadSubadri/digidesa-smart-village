<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Destination;
use Illuminate\Http\Request;

class PotentialController extends Controller
{
    public function umkm()
    {
        $umkms = Umkm::where('is_published', true)->paginate(12);
        return view('potential.umkm', compact('umkms'));
    }

    public function umkmDetail(string $slug)
    {
        $umkm = Umkm::where('slug', $slug)->firstOrFail();
        return view('potential.umkm_detail', compact('umkm'));
    }

    public function wisata()
    {
        $destinations = Destination::where('is_published', true)->paginate(12);
        return view('potential.wisata', compact('destinations'));
    }

    public function wisataDetail(string $slug)
    {
        $destination = Destination::where('slug', $slug)->firstOrFail();
        return view('potential.wisata_detail', compact('destination'));
    }
}
