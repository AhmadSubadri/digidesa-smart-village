<?php

namespace App\Http\Controllers;

use App\Models\IdmScore;
use App\Models\IdmIndicator;
use App\Models\SdgsGoal;
use App\Models\SdgsScore;
use App\Models\Padukuhan;
use App\Models\Setting;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function kependudukan()
    {
        $stats = [
            'total' => Setting::getValue('village_population', 28394),
            'kk'    => Setting::getValue('village_families', 9800),
            'laki'  => 14120,
            'perempuan' => 14274,
        ];

        return view('statistics.kependudukan', compact('stats'));
    }

    public function idm()
    {
        $idmScores = IdmScore::orderByDesc('year')->get();
        $latest = $idmScores->first();
        $indicators = $latest ? IdmIndicator::where('idm_score_id', $latest->id)->get() : collect();

        return view('statistics.idm', compact('idmScores', 'latest', 'indicators'));
    }

    public function sdgs()
    {
        $goals = SdgsGoal::with(['scores' => fn($q) => $q->where('year', 2024)])
            ->orderBy('number')
            ->get();

        return view('statistics.sdgs', compact('goals'));
    }
}
