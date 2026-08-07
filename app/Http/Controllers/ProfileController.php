<?php

namespace App\Http\Controllers;

use App\Models\Padukuhan;
use App\Models\Setting;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function visiMisi()
    {
        return view('profile.visi-misi');
    }

    public function sejarah()
    {
        return view('profile.sejarah');
    }

    public function geografis()
    {
        $padukuhans = Padukuhan::orderBy('sort_order')->get();
        return view('profile.geografis', compact('padukuhans'));
    }

    public function demografi()
    {
        $stats = [
            'total_penduduk' => Setting::getValue('village_population', 28394),
            'total_kk'       => Setting::getValue('village_families', 9800),
            'laki'           => 14120,
            'perempuan'      => 14274,
            'usia_produktif' => 19500,
        ];
        return view('profile.demografi', compact('stats'));
    }
}
