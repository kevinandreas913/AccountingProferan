<?php

namespace App\Http\Controllers;

use App\Models\MasterAkun;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JurnalUmumController extends Controller
{
    public function index()
    {
        return view('pages.laporan.jurnal-umum');
    }

    public function print(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'startDate' =>'required|date',
            'endDate' =>'required|date',
        ]);
        if($validator->fails()) {
            abort(422);
        } else {
            if($request->startDate > $request->endDate) {
                abort(422);
            }
        }

        $dataUsaha = [
            'nama' => Auth::user()->fullname,
            'startDate' => Carbon::parse($request->startDate)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('d F Y'),
            'endDate' => Carbon::parse($request->endDate)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('d F Y')
        ];

        $data = Transaksi::where(function($q) use($request) {
            $q->whereBetween('tgl', [$request->startDate, $request->endDate]);
        })->where('user_id', Auth::user()->id)->whereNot('keterangan', 'LIKE', 'Potongan: %')->orderBy('tgl', 'ASC')->get()
        ->map(function($data) use($request) {
            $akun_debit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $data->nomor_akun_debit)->first();
            $akun_kredit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $data->nomor_akun_kredit)->first();

            $potongan = Transaksi::where(function($q) use ($request) {
                $q->whereBetween('tgl', [$request->startDate, $request->endDate]);
            })->where('user_id', Auth::user()->id)->where('keterangan', 'LIKE', 'Potongan: ' . $data->keterangan)->get()
            ->map(function($data) {
                $akun_debit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $data->nomor_akun_debit)->first();
                $akun_kredit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $data->nomor_akun_kredit)->first();
                return [
                    'tgl' => Carbon::parse($data->tgl)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('d F Y'),
                    'nama_akun_debit' => $akun_debit->nama,
                    'nama_akun_kredit' => $akun_kredit->nama,
                    'nominal_debit' => "Rp ". number_format($data->nominal_debit),
                    'nominal_kredit' => "Rp ". number_format($data->nominal_kredit),
                    'keterangan' => ucfirst($data->keterangan),
                ];
            })->first();
            
            return [
                'tgl' => Carbon::parse($data->tgl)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('d F Y'),
                'nama_akun_debit' => $akun_debit->nama,
                'nama_akun_kredit' => $akun_kredit->nama,
                'nominal_debit' => "Rp " . number_format($data->nominal_debit),
                'nominal_kredit' => "Rp " . number_format($data->nominal_kredit),
                'keterangan' => ucfirst($data->keterangan),
                'potongan' => $potongan,
            ];
        });

        $pdf = Pdf::setOptions(['dpi' => 150, 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->setPaper('A4')->loadView('pdf.pdf-jurnal-umum', compact('dataUsaha', 'data'));
    	return $pdf->stream('Laporan Jurnal Umum.pdf');
    }
}
