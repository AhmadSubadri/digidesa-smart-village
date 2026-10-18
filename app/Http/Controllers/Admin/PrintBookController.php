<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandRecord;
use App\Models\LetterRegister;
use App\Models\VillageAsset;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrintBookController extends Controller
{
    /**
     * Cetak Buku Agenda Surat Masuk / Keluar (Format Lampiran Permendagri No. 47/2016).
     */
    public function bukuAgendaSurat(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $type = $request->get('type', 'outgoing'); // outgoing | incoming

        $query = LetterRegister::query();

        if ($type !== 'all') {
            $query->where('register_type', $type);
        }

        if ($year) {
            $query->whereYear('letter_date', $year);
        }

        $records = $query->orderBy('letter_date', 'asc')->orderBy('id', 'asc')->get();

        $title = $type === 'incoming' 
            ? 'BUKU AGENDA SURAT MASUK' 
            : ($type === 'outgoing' ? 'BUKU AGENDA SURAT KELUAR' : 'BUKU AGENDA SURAT MASUK & KELUAR');

        return view('admin.print.buku-agenda-surat', compact('records', 'year', 'type', 'title'));
    }

    /**
     * Cetak Buku Tanah Desa & Letter C (Format Lampiran Permendagri No. 47/2016).
     */
    public function bukuLetterC(Request $request)
    {
        $padukuhanId = $request->get('padukuhan_id');
        $query = LandRecord::with(['owner', 'padukuhan', 'mutations']);

        if ($padukuhanId) {
            $query->where('padukuhan_id', $padukuhanId);
        }

        $records = $query->orderBy('kohir_number', 'asc')->get();

        return view('admin.print.buku-letter-c', compact('records'));
    }

    /**
     * Cetak Buku Inventaris dan Kekayaan Desa (Format Lampiran Permendagri No. 1/2016).
     */
    public function bukuInventarisAset(Request $request)
    {
        $category = $request->get('category');
        $query = VillageAsset::query();

        if ($category) {
            $query->where('category', $category);
        }

        $records = $query->orderBy('asset_code', 'asc')->get();
        $totalValue = $records->sum('acquisition_value');

        return view('admin.print.buku-inventaris-aset', compact('records', 'totalValue'));
    }
}
