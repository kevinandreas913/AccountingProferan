<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class BeritaController extends BaseController
{
    public function index()
    {
        return view('pages.berita.index');
    }

    public function table()
    {
        $data = Berita::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('gambar', function ($data) {
                return '<img src="' . asset('assets/images/berita/' . $data->gambar) . '" width="100px" height="100px">';
            })
            ->editColumn('tanggal', function ($data) {
                return Carbon::parse($data->tanggal)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('d F Y');
            })
            ->editColumn('status', function ($data) {
                if ($data->status == 'aktif') {
                    return '<span class="badge badge-success">Aktif</span>';
                } else {
                    return '<span class="badge badge-danger">Non-aktif</span>';
                }
            })
            ->addColumn('action', function ($data) {
                $edit = '<button type="button" class="btn btn-warning" id="edit" data-id="' . $data->id . '"><span class="mdi mdi-lead-pencil"></span></button>';
                $hapus = '<button type="button" class="btn btn-danger" id="hapus" data-id="' . $data->id . '" data-nama="' . $data->judul . '"><span class="mdi mdi-delete"></span></button>';
                if ($data->status == 'aktif') {
                    $status = '<button type="button" class="btn btn-secondary" id="status_aktif" data-id="' . $data->id . '" data-nama="' . $data->judul . '" data-status="non-aktifkan"><span class="mdi mdi-close"></span></button>';
                } else {
                    $status = '<button type="button" class="btn btn-success" id="status_aktif" data-id="' . $data->id . '" data-nama="' . $data->judul . '" data-status="aktifkan"><span class="mdi mdi-check"></span></button>';
                }

                $action = $edit . ' ' . $hapus . ' ' . $status;
                return $action;
            })
            ->editColumn('link', function ($data) {
                return '<a href="' . $data->link . '" target="_blank" class="btn btn-primary">Lihat detail</a>';
            })
            ->rawColumns(['action', 'gambar', 'status', 'link'])
            ->make(true);
    }

    public function storeOrUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg',
            'link' => 'required'
        ], [
            'judul.required' => 'Judul wajib diisi',
            'deskripsi.required' => 'Deskripsi wajib diisi',
            'tanggal.required' => 'Tanggal wajib diisi',
            'gambar.required' => 'Gambar wajib diisi',
            'gambar.image' => 'Format harus benar',
            'gambar.mimes' => 'Format gambar harus jpg, png, atau jpeg',
            'link.required' => 'Link wajib diisi'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse([], $validator->messages(), 'error', 422);
        };

        $storeOrUpdate = Berita::findOrNew($request->id);
        $storeOrUpdate->judul = $request->judul;
        $storeOrUpdate->deskripsi = $request->deskripsi;
        $storeOrUpdate->tanggal = $request->tanggal;

        if ($request->hasFile('gambar')) {
            if (File::exists('assets/images/berita/' . $storeOrUpdate->gambar)) {
                File::delete('assets/images/berita/' . $storeOrUpdate->gambar);
            }
            $file = $request->file('gambar');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '-' . Str::slug($request->judul, '-') . '.'. $extension;
            $file->move('assets/images/berita/', $filename);

            $storeOrUpdate->gambar = $filename;
        }
        $storeOrUpdate->status = 'aktif';
        $storeOrUpdate->link = $request->link;
        $storeOrUpdate->save();

        $message = $request->id ? 'diubah' : 'ditambahkan';

        return $this->sendResponse([], 'Data ' . $message, 'success', 200);
    }

    public function hapus(Request $request)
    {
        $data = Berita::where('id', $request->id)->first();
        if (File::exists('assets/images/berita/' . $data->gambar)) {
            File::delete('assets/images/berita/' . $data->gambar);
        }
        $data->delete();

        return $this->sendResponse([], 'Data berhasil dihapus', 'success', 200);
    }

    public function edit($id)
    {
        try {
            $data = Berita::find($id);
            return $this->sendResponse($data, 'Data ditemukan', 'success', 200);
        } catch (\Exception $e) {
            return $this->sendResponse($e->getMessage(), 'Data tidak ditemukan atau tidak valid!', 'error', 404);
        }
    }

    public function ubah_status(Request $request)
    {
        $data = Berita::where('id', $request->id)->first();
        if ($request->status == 'aktifkan') {
            $data->status = 'aktif';
        } else {
            $data->status = 'tidak';
        }
        $data->save();

        return $this->sendResponse([], 'Status berhasil diubah!', 'success', 200);
    }
}
