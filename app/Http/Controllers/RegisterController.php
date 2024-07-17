<?php

namespace App\Http\Controllers;

use App\Models\MasterAkun;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function index() 
    {
        return view('auth.register');
    }

    public function register(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $user = new User();
            $user->fullname = $request->fullname;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->save();
            
            $dataAkun = [
                [
                    'user_id' => $user->id,
                    'nama' => 'Kas',
                    'nomor_akun' => 111,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-001',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Piutang Usaha',
                    'nomor_akun' => 112,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-002',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Perlengkapan',
                    'nomor_akun' => 113,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-004',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Persediaan Barang Dagang',
                    'nomor_akun' => 114,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-004',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Tanah',
                    'nomor_akun' => 121,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-005',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Bangunan',
                    'nomor_akun' => 122,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-005',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Akumulasi Penyusutan Bangunan',
                    'nomor_akun' => 123,
                    'saldo_normal' => 'kredit',
                    'jenis_akun_id' => 'JK-PFA-2024-006',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Peralatan',
                    'nomor_akun' => 124,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-005',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Akumulasi Penyusutan Peralatan',
                    'nomor_akun' => 125,
                    'saldo_normal' => 'kredit',
                    'jenis_akun_id' => 'JK-PFA-2024-006',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Utang Usaha',
                    'nomor_akun' => 211,
                    'saldo_normal' => 'kredit',
                    'jenis_akun_id' => 'JK-PFA-2024-008',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Utang Beban',
                    'nomor_akun' => 212,
                    'saldo_normal' => 'kredit',
                    'jenis_akun_id' => 'JK-PFA-2024-009',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Utang Jangka Panjang Lainnya',
                    'nomor_akun' => 221,
                    'saldo_normal' => 'kredit',
                    'jenis_akun_id' => 'JK-PFA-2024-010',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Modal Usaha',
                    'nomor_akun' => 311,
                    'saldo_normal' => 'kredit',
                    'jenis_akun_id' => 'JK-PFA-2024-011',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Prive',
                    'nomor_akun' => 312,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-011',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Penjualan',
                    'nomor_akun' => 411,
                    'saldo_normal' => 'kredit',
                    'jenis_akun_id' => 'JK-PFA-2024-012',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Potongan Penjualan',
                    'nomor_akun' => 412,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-012',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Retur Penjualan',
                    'nomor_akun' => 413,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-012',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Pendapatan Bunga',
                    'nomor_akun' => 421,
                    'saldo_normal' => 'kredit',
                    'jenis_akun_id' => 'JK-PFA-2024-016',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Pendapatan Usaha Lain',
                    'nomor_akun' => 422,
                    'saldo_normal' => 'kredit',
                    'jenis_akun_id' => 'JK-PFA-2024-016',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Pendapatan Lain-lain',
                    'nomor_akun' => 423,
                    'saldo_normal' => 'kredit',
                    'jenis_akun_id' => 'JK-PFA-2024-016',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Harga Pokok Penjualan',
                    'nomor_akun' => 500,
                    'saldo_normal' => 'kredit',
                    'jenis_akun_id' => 'JK-PFA-2024-013',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Pembelian Barang Dagang',
                    'nomor_akun' => 511,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-013',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Beban Angkut Pembelian',
                    'nomor_akun' => 512,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-013',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Retur Pembelian',
                    'nomor_akun' => 513,
                    'saldo_normal' => 'kredit',
                    'jenis_akun_id' => 'JK-PFA-2024-013',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Potongan Pembelian',
                    'nomor_akun' => 514,
                    'saldo_normal' => 'kredit',
                    'jenis_akun_id' => 'JK-PFA-2024-013',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Beban Telepon dan Listrik',
                    'nomor_akun' => 522,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-014',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Beban Air',
                    'nomor_akun' => 523,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-014',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Beban Perlengkapan Toko',
                    'nomor_akun' => 524,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-014',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Beban Peralatan Toko',
                    'nomor_akun' => 525,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-014',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Beban Penyusutan Bangunan',
                    'nomor_akun' => 526,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-014',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Beban Penyusutan Peralatan',
                    'nomor_akun' => 527,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-014',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Beban Gaji Karyawan',
                    'nomor_akun' => 528,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-014',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Beban Iklan',
                    'nomor_akun' => 529,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-014',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Beban Administrasi Bank',
                    'nomor_akun' => 530,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-014',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Beban Operasi Lainnya',
                    'nomor_akun' => 531,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-014',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Beban Angkut Penjualan',
                    'nomor_akun' => 532,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-014',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
                [
                    'user_id' => $user->id,
                    'nama' => 'Beban Lain-lain',
                    'nomor_akun' => 533,
                    'saldo_normal' => 'debit',
                    'jenis_akun_id' => 'JK-PFA-2024-015',
                    'nominal' => 0,
                    'periode_bulan' => Carbon::parse(date('F'))->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F'),
                    'periode_tahun' => date('Y'),
                ],
            ];
            
            foreach($dataAkun as $akun) {
                MasterAkun::create($akun);
            }

            DB::commit();

            return redirect('/auth/login')->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
