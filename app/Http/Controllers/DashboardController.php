<?php

namespace App\Http\Controllers;

use App\Models\MasterAkun;
use App\Models\RekapDataAkun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        return view('pages.dashboard.index');
    }

    public function dataAssets() {
        $totalNominalAssets = MasterAkun::where('user_id', Auth::user()->id)->where(function($q) {
            $q->where('jenis_akun_id', 'JK-PFA-2024-001')
                ->orWhere('jenis_akun_id', 'JK-PFA-2024-002')
                ->orWhere('jenis_akun_id', 'JK-PFA-2024-003')
                ->orWhere('jenis_akun_id', 'JK-PFA-2024-004')
                ->orWhere('jenis_akun_id', 'JK-PFA-2024-005');
        })->sum('nominal');

        $dataAkun = MasterAkun::where('user_id', Auth::user()->id)->where(function($q) {
            $q->where('jenis_akun_id', 'JK-PFA-2024-001')
                ->orWhere('jenis_akun_id', 'JK-PFA-2024-002')
                ->orWhere('jenis_akun_id', 'JK-PFA-2024-003')
                ->orWhere('jenis_akun_id', 'JK-PFA-2024-004')
                ->orWhere('jenis_akun_id', 'JK-PFA-2024-005');
        })->get();

        $periode = $dataAkun[0]->periode_bulan . ' ' . $dataAkun[0]->periode_tahun;

        $dataAssets = [];
        $labelAssets = [];
        foreach ($dataAkun as $akun) {
            $dataAssets[] = (float)number_format($akun->nominal * 100 / $totalNominalAssets, 2);
            $labelAssets[] = $akun->nama;
        }
        return response()->json(['labelAssets' => $labelAssets, 'dataAssets' => $dataAssets, 'periode' => $periode]);
    }

    public function dataLiability() {
        $totalNominalLiability = MasterAkun::where('user_id', Auth::user()->id)->where(function($q) {
            $q->where('jenis_akun_id', 'JK-PFA-2024-008')
                ->orWhere('jenis_akun_id', 'JK-PFA-2024-009')
                ->orWhere('jenis_akun_id', 'JK-PFA-2024-010');
        })->sum('nominal');

        $dataAkun = MasterAkun::where('user_id', Auth::user()->id)->where(function($q) {
            $q->where('jenis_akun_id', 'JK-PFA-2024-008')
                ->orWhere('jenis_akun_id', 'JK-PFA-2024-009')
                ->orWhere('jenis_akun_id', 'JK-PFA-2024-010');
        })->get();

        $periode = $dataAkun[0]->periode_bulan . ' ' . $dataAkun[0]->periode_tahun;

        $dataLiability = [];
        $labelLiability = [];
        foreach ($dataAkun as $akun) {
            $dataLiability[] = (float)number_format($akun->nominal * 100 / $totalNominalLiability, 2);
            $labelLiability[] = $akun->nama;
        }
        return response()->json(['labelLiability' => $labelLiability, 'dataLiability' => $dataLiability, 'periode' => $periode]);
    }
}
