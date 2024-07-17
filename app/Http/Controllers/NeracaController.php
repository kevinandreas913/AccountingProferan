<?php

namespace App\Http\Controllers;

use App\Models\MasterAkun;
use App\Models\RekapDataAkun;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NeracaController extends Controller
{
    private $_MONTH = '';
    private $_YEAR = '';

    public function __construct() {
        $this->_MONTH = Carbon::now()->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F');
        $this->_YEAR = date('Y');
    }
    public function index()
    {
        $joinMonth = Carbon::parse(Auth::user()->created_at)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('m');
        $joinYear = Carbon::parse(Auth::user()->created_at)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('Y');

        return view('pages.laporan.neraca', [
            'tahun' => $joinYear,
            'bulan' => $joinMonth,
        ]);
    }

    public function print(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun' =>'required',
            'bulan' =>'required',
        ]);
        if($validator->fails()) {
            abort(422);
        }

        $tahun = Carbon::createFromFormat('Y', $request->tahun)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('Y');
        $bulan = Carbon::createFromFormat('m', $request->bulan)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F');

        $dataUsaha = [
            'nama' => Auth::user()->fullname,
            'tahun' => $tahun,
            'bulan' => $bulan
        ];

        if ($tahun == $this->_YEAR && $bulan == $this->_MONTH) {
            $data = MasterAkun::where('user_id', Auth::user()->id)->where('periode_bulan', $this->_MONTH)->where('periode_tahun', $this->_YEAR)->get()->groupBy('jenis_akun_id')
            ->map(function($data) {
                return $data->groupBy('nama')->map(function($data) {
                    return $data->first();
                });
            });
        }
        else {
            $data = RekapDataAkun::where('user_id', Auth::user()->id)->where('periode_bulan', $bulan)->where('periode_tahun', $tahun)->get()->groupBy('jenis_akun_id')
            ->map(function($data) {
                return $data->groupBy('nama')->map(function($data) {
                    return $data->first();
                });
            });
        }

        $pdf = Pdf::setOptions(['dpi' => 180, 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->setPaper('A4')->loadView('pdf.pdf-neraca', compact('dataUsaha', 'data'));
    	return $pdf->stream('Laporan Neraca.pdf');
    }
}
