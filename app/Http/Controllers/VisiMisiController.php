<?php

namespace App\Http\Controllers;

use App\Models\VisiMisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Response;

class VisiMisiController extends BaseController
{
    public function index() {
        return view('pages.visi_misi.index');
    }

    public function table() {
        $data = VisiMisi::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('visi', function($query) {
                return $query->visi;
            })
            ->editColumn('misi', function($query) {
                return $query->misi;
            })
            ->addColumn('action', function ($data) {
                $edit = '<button type="button" class="btn btn-warning" id="edit" data-id="'. $data->id .'"><span class="mdi mdi-lead-pencil"></span></button>';
                $hapus = '<button type="button" class="btn btn-danger" id="delete" data-id="'. $data->id .'"><span class="mdi mdi-delete"></span></button>';

                $action = $edit .' '. $hapus;
                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function storeOrUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'visi' =>'required',
            'misi' =>'required'
        ], [
            'visi.required' => 'Visi wajib diisi',
            'misi.required' => 'Misi wajib diisi'
        ]);

        if($validator->fails()) {
            return $this->sendResponse([], $validator->messages(), 'error', 422);            
        };

        $storeOrUpdate = VisiMisi::findOrNew($request->id);
        $storeOrUpdate->visi = $request->visi;
        $storeOrUpdate->misi = $request->misi;
        $storeOrUpdate->save();

        $message = $request->id ? 'diubah' : 'ditambahkan';

        return $this->sendResponse([], 'Data ' . $message, 'success', 200);
    }

    public function hapus(Request $request) {
        $data = VisiMisi::where('id', $request->id)->delete();
        return $this->sendResponse([], 'Data berhasil dihapus', 'success', 200);
    }

    public function edit($id) {
        try {
            $data = VisiMisi::find($id);
            return $this->sendResponse($data, 'Data ditemukan', 'success', 200);
        } catch (\Exception $e) {
            return $this->sendResponse($e->getMessage(), 'Data tidak ditemukan atau tidak valid!', 'error', 404);
        }
    }
}
