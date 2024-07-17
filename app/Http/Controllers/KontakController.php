<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KontakController extends BaseController
{
    public function index() {
        return view('pages.kontak.index');
    }

    public function table() {
        $data = Kontak::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($query) {
                $edit = '<button type="button" class="btn btn-warning" id="edit" data-id="'. $query->id .'"><span class="mdi mdi-lead-pencil"></span></button>';
                // $hapus = '<button type="button" class="btn btn-danger" id="delete" data-id="'. $query->id .'"><span class="mdi mdi-delete"></span></button>';

                $action = $edit;
                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function storeOrUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' =>'required',
            'telepon' =>'required|digits_between:10,13',
            'alamat' =>'required'
        ], [
            'email.required' => 'Email wajib diisi',
            'telepon.required' => 'Telepon wajib diisi',
            'telepon.digits_between' => 'Telepon minimal 10 digit dan maksimal 13 digit',
            'alamat.required' => 'Alamat wajib diisi'
        ]);

        if($validator->fails()) {
            return $this->sendResponse([], $validator->messages(), 'error', 422);            
        };

        $storeOrUpdate = Kontak::findOrNew($request->id);
        $storeOrUpdate->email = $request->email;
        $storeOrUpdate->phone = $request->telepon;
        $storeOrUpdate->alamat = $request->alamat;
        $storeOrUpdate->save();

        $message = $request->id ? 'diubah' : 'ditambahkan';

        return $this->sendResponse([], 'Data ' . $message, 'success', 200);
    }

    public function edit($id) {
        try {
            $data = Kontak::find($id);
            return $this->sendResponse($data, 'Data ditemukan', 'success', 200);
        } catch (\Exception $e) {
            return $this->sendResponse($e->getMessage(), 'Data tidak ditemukan atau tidak valid!', 'error', 404);
        }
    }
}
