<?php

namespace App\Http\Controllers;

use App\Models\MasterAkun;
use App\Models\Transaksi;
use App\Services\ModuleService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PengeluaranController extends BaseController
{
    protected $moduleService;

    public function __construct(ModuleService $moduleService)
    {
        $this->moduleService = $moduleService;
    }

    public function index()
    {
        return view('pages.pengeluaran.index');
    }

    public function table(Request $request)
    {
        $data = Transaksi::where('user_id', Auth::user()->id)->where('type', 'pengeluaran')->where(function ($q) use ($request) {
            $q->where('tgl', 'LIKE', "%" . $request->get('query') . "%");
        })->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('tgl', function ($data) {
                return Carbon::parse($data->tgl)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('d F Y');
            })
            ->editColumn('nomor_akun_debit', function ($data) {
                $akun = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $data->nomor_akun_debit)->first();
                return $akun->nama;
            })
            ->editColumn('nomor_akun_kredit', function ($data) {
                $akun = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $data->nomor_akun_kredit)->first();
                return $akun->nama;
            })
            ->editColumn('nominal_debit', function ($data) {
                return "Rp " . number_format($data->nominal_debit);
            })
            ->editColumn('nominal_kredit', function ($data) {
                return "Rp " . number_format($data->nominal_kredit);
            })
            ->editColumn('keterangan', function ($data) {
                return ucfirst($data->keterangan);
            })
            ->addColumn('action', function ($data) {
                if (!str_contains($data->keterangan, 'Potongan: ')) {
                    $button = '<button type="button" id="' . $data->id . '" class="btnEdit btn btn-warning rounded mr-1"><span class="mdi mdi-lead-pencil"></span></button>';
                    $button .= '<button type="button" id="' . $data->id . '" class="btnDel btn btn-danger rounded"><span class="mdi mdi-delete"></span></button>';
                } else {
                    $button = '-';
                }

                return $button;
            })
            ->rawColumns(['action'])->make(true);
    }

    public function createUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'jenis_transaksi' => 'required',
                'tgl' => 'required|date',
                'nominal' => 'required|min:1|numeric',
                'keterangan' => 'required',
                'potongan' => 'numeric|min:1',
            ],
            [
                'jenis_transaksi.required' => 'Jenis transaksi harus dipilih terlebih dahulu.',
                'tgl.required' => 'Tanggal transaksi wajib diisi.',
                'nominal.required' => 'Nominal transaksi wajib diisi.',
                'tgl.date' => 'Format tanggal transaksi tidak sesuai.',
                'nominal.numeric' => 'Nominal transaksi tidak valid.',
                'nominal.min' => 'Nominal transaksi minimal Rp 1.',
                'keterangan.required' => 'Keterangan transaksi wajib diisi.',
                'potongan.numeric' => 'Potongan transaksi tidak valid.',
                'potongan.min' => 'Potongan transaksi minimal Rp 1.',
            ]
        );
        if ($validator->fails()) {
            return $this->sendResponse([], $validator->messages(), 'error', 422);
        }

        if (empty($request->id)) {
            $result = $this->moduleService->processModuleCreate('pengeluaran', $request);
            $response = $result->getData();
        } else {
            $result = $this->moduleService->processModuleUpdate('pengeluaran', $request);
            $response = $result->getData();
        }
        return $this->sendResponse($response, $response->message, $response->status, $response->code);
    }

    public function edit($id)
    {
        try {
            $transaksi = Transaksi::where('id', $id)->where('user_id', Auth::user()->id)->where('type', 'pengeluaran')->firstOrFail();
            $potongan = Transaksi::where('user_id', Auth::user()->id)->where('keterangan', 'LIKE', 'Potongan: ' . $transaksi->keterangan)->where('type', 'pengeluaran')->first();
            $data = $transaksi;
            $data->potongan = $potongan;
            return $this->sendResponse($data, 'Data ditemukan', 'success', 200);
        } catch (\Exception $e) {
            return $this->sendResponse($e->getMessage(), 'Data tidak ditemukan atau tidak valid!', 'error', 404);
        }
    }

    public function destroy(Request $request)
    {
        $result = $this->moduleService->processModuleDestroy('pengeluaran', $request);
        $response = $result->getData();
        return $this->sendResponse([], $response->message, $response->status, $response->code);
    }
}
