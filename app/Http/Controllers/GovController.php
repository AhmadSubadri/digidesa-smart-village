<?php

namespace App\Http\Controllers;

use App\Models\Official;
use App\Models\Institution;
use Illuminate\Http\Request;

class GovController extends Controller
{
    public function struktur()
    {
        $lurah = Official::where('position', 'like', '%Lurah%')->first();
        $sekretaris = Official::where('position', 'like', '%Carik%')->orWhere('position', 'like', '%Sekretaris%')->first();
        $officials = Official::where('is_active', true)->orderBy('sort_order')->get();

        return view('government.struktur', compact('lurah', 'sekretaris', 'officials'));
    }

    public function perangkat()
    {
        $officials = Official::where('is_active', true)->orderBy('sort_order')->get();
        return view('government.perangkat', compact('officials'));
    }

    public function lembaga()
    {
        $institutions = Institution::where('is_active', true)->orderBy('sort_order')->get();
        return view('government.lembaga', compact('institutions'));
    }
}
