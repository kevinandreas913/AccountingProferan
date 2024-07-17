<?php

namespace App\Services;

use App\Models\LogError;
use App\Models\MasterAkun;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ModuleService
{
    public function processModuleCreate($module, $request)
    {
        if ($module === 'pemasukan') {
            DB::beginTransaction();
            try {
                if ($request->jenis_transaksi == 111 || $request->jenis_transaksi == 121 || $request->jenis_transaksi == 122 || $request->jenis_transaksi == 124 || $request->jenis_transaksi == 511) {
                    $nomor_akun_kredit = 311;
                    $nomor_akun_debit = $request->jenis_transaksi;
                } else {
                    $nomor_akun_debit = 111;
                    $nomor_akun_kredit = $request->jenis_transaksi;
                }
                $transaksi = new Transaksi();
                $transaksi->user_id = Auth::user()->id;
                $transaksi->tgl = $request->tgl;
                $transaksi->nomor_akun_debit = $nomor_akun_debit;
                $transaksi->nominal_debit = $request->nominal;
                $transaksi->nomor_akun_kredit = $nomor_akun_kredit;
                $transaksi->nominal_kredit = $request->nominal;
                $transaksi->keterangan = ucfirst($request->keterangan);
                $transaksi->type = $module;
                $transaksi->save();

                $akunDebit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $nomor_akun_debit)->firstOrFail();
                if($akunDebit->saldo_normal == 'kredit') {
                    $akunDebit->nominal -= $request->nominal;
                    $akunDebit->save();
                }
                else {
                    $akunDebit->nominal += $request->nominal;
                    $akunDebit->save();
                }

                $akunKredit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $nomor_akun_kredit)->firstOrFail();
                if($akunKredit->saldo_normal == 'kredit') {
                    $akunKredit->nominal += $request->nominal;
                    $akunKredit->save();
                }
                else {
                    $akunKredit->nominal -= $request->nominal;
                    $akunKredit->save();
                }

                if($request->has('potongan')) {
                    $transaksiPot = new Transaksi();
                    $transaksiPot->user_id = Auth::user()->id;
                    $transaksiPot->tgl = $request->tgl;
                    $transaksiPot->nomor_akun_debit = 412;
                    $transaksiPot->nominal_debit = $request->potongan;
                    $transaksiPot->nomor_akun_kredit = 111;
                    $transaksiPot->nominal_kredit = $request->potongan;
                    $transaksiPot->keterangan = "Potongan: " . ucfirst($request->keterangan);
                    $transaksiPot->type = $module;
                    $transaksiPot->save();

                    $akunDebitPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 412)->firstOrFail();
                    $akunDebitPot->nominal += $request->potongan;
                    $akunDebitPot->save();
                    $akunKreditPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 111)->firstOrFail();
                    $akunKreditPot->nominal -= $request->potongan;
                    $akunKreditPot->save();
                }

                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menambahkan data pemasukan!',
                    'code' => 200,
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                LogError::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Tambah Pemasukan',
                    'message' => $e,
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal menambahkan data pemasukan!',
                    'code' => 500,
                ], 500);
            }
        }
        else if ($module === 'pengeluaran') {
            DB::beginTransaction();
            try {
                $transaksi = new Transaksi();
                $transaksi->user_id = Auth::user()->id;
                $transaksi->tgl = $request->tgl;
                $transaksi->nomor_akun_debit = $request->jenis_transaksi;
                $transaksi->nominal_debit = $request->nominal;
                $transaksi->nomor_akun_kredit = 111;
                $transaksi->nominal_kredit = $request->nominal;
                $transaksi->keterangan = ucfirst($request->keterangan);
                $transaksi->type = $module;
                $transaksi->save();

                $akunKredit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 111)->firstOrFail();
                $akunKredit->nominal -= $request->nominal;
                $akunKredit->save();

                $akunDebit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $request->jenis_transaksi)->firstOrFail();
                if ($akunDebit->saldo_normal == 'kredit') {
                    $akunDebit->nominal -= $request->nominal;
                    $akunDebit->save();
                } else {
                    $akunDebit->nominal += $request->nominal;
                    $akunDebit->save();
                }

                if ($request->has('potongan')) {
                    $transaksiPot = new Transaksi();
                    $transaksiPot->user_id = Auth::user()->id;
                    $transaksiPot->tgl = $request->tgl;
                    $transaksiPot->nomor_akun_debit = 111;
                    $transaksiPot->nominal_debit = $request->potongan;
                    $transaksiPot->nomor_akun_kredit = 514;
                    $transaksiPot->nominal_kredit = $request->potongan;
                    $transaksiPot->keterangan = "Potongan: " . ucfirst($request->keterangan);
                    $transaksiPot->type = $module;
                    $transaksiPot->save();

                    $akunKreditPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 514)->firstOrFail();
                    $akunKreditPot->nominal += $request->potongan;
                    $akunKreditPot->save();
                    $akunDebitPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 111)->firstOrFail();
                    $akunDebitPot->nominal += $request->potongan;
                    $akunDebitPot->save();
                }

                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menambahkan data pengeluaran!',
                    'code' => 200,
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                LogError::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Tambah Pengeluaran',
                    'message' => $e,
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal menambahkan data pengeluaran!',
                    'code' => 500,
                ], 500);
            }
        }
        else if ($module === 'utang') {
            DB::beginTransaction();
            try {
                if ($request->jenis_transaksi == 511 || $request->jenis_transaksi == 512) {
                    $nomor_akun_kredit = 211;
                } else if ($request->jenis_transaksi == 211) {
                    $nomor_akun_kredit = 513;
                } else {
                    $nomor_akun_kredit = 212;
                }
                $transaksi = new Transaksi();
                $transaksi->user_id = Auth::user()->id;
                $transaksi->tgl = $request->tgl;
                $transaksi->nomor_akun_debit = $request->jenis_transaksi;
                $transaksi->nominal_debit = $request->nominal;
                $transaksi->nomor_akun_kredit = $nomor_akun_kredit;
                $transaksi->nominal_kredit = $request->nominal;
                $transaksi->keterangan = ucfirst($request->keterangan);
                $transaksi->type = $module;
                $transaksi->save();

                $akunKredit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $nomor_akun_kredit)->firstOrFail();
                if ($akunKredit->saldo_normal == 'kredit') {
                    $akunKredit->nominal += $request->nominal;
                } else {
                    $akunKredit->nominal -= $request->nominal;
                }
                $akunKredit->save();

                $akunDebit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $request->jenis_transaksi)->firstOrFail();
                if ($akunDebit->saldo_normal == 'kredit') {
                    $akunDebit->nominal -= $request->nominal;
                } else {
                    $akunDebit->nominal += $request->nominal;
                }
                $akunDebit->save();

                if ($request->has('potongan')) {
                    $transaksiPot = new Transaksi();
                    $transaksiPot->user_id = Auth::user()->id;
                    $transaksiPot->tgl = $request->tgl;
                    $transaksiPot->nomor_akun_debit = 211;
                    $transaksiPot->nominal_debit = $request->potongan;
                    $transaksiPot->nomor_akun_kredit = 514;
                    $transaksiPot->nominal_kredit = $request->potongan;
                    $transaksiPot->keterangan = "Potongan: " . ucfirst($request->keterangan);
                    $transaksiPot->type = $module;
                    $transaksiPot->save();

                    $akunDebitPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 211)->firstOrFail();
                    $akunDebitPot->nominal -= $request->potongan;
                    $akunDebitPot->save();
                    $akunKreditPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 514)->firstOrFail();
                    $akunKreditPot->nominal += $request->potongan;
                    $akunKreditPot->save();
                }

                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menambahkan data utang!',
                    'code' => 200,
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                LogError::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Tambah Utang',
                    'message' => $e,
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal menambahkan data utang!',
                    'code' => 500,
                ], 500);
            }
        }
        else if ($module === 'piutang') {
            DB::beginTransaction();
            try {
                if ($request->jenis_transaksi == 112) {
                    $nomor_akun_debit = 413;
                } else {
                    $nomor_akun_debit = 112;
                }
                $transaksi = new Transaksi();
                $transaksi->user_id = Auth::user()->id;
                $transaksi->tgl = $request->tgl;
                $transaksi->nomor_akun_debit = $nomor_akun_debit;
                $transaksi->nominal_debit = $request->nominal;
                $transaksi->nomor_akun_kredit = $request->jenis_transaksi;
                $transaksi->nominal_kredit = $request->nominal;
                $transaksi->keterangan = ucfirst($request->keterangan);
                $transaksi->type = $module;
                $transaksi->save();

                $akunDebit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $nomor_akun_debit)->firstOrFail();
                if ($akunDebit->saldo_normal == 'kredit') {
                    $akunDebit->nominal -= $request->nominal;
                } else {
                    $akunDebit->nominal += $request->nominal;
                }
                $akunDebit->save();

                $akunKredit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $request->jenis_transaksi)->firstOrFail();
                if ($akunKredit->saldo_normal == 'kredit') {
                    $akunKredit->nominal += $request->nominal;
                } else {
                    $akunKredit->nominal -= $request->nominal;
                }
                $akunKredit->save();

                if ($request->has('potongan')) {
                    $transaksiPot = new Transaksi();
                    $transaksiPot->user_id = Auth::user()->id;
                    $transaksiPot->tgl = $request->tgl;
                    $transaksiPot->nomor_akun_debit = 412;
                    $transaksiPot->nominal_debit = $request->potongan;
                    $transaksiPot->nomor_akun_kredit = 112;
                    $transaksiPot->nominal_kredit = $request->potongan;
                    $transaksiPot->keterangan = "Potongan: " . ucfirst($request->keterangan);
                    $transaksiPot->type = $module;
                    $transaksiPot->save();

                    $akunDebitPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 412)->firstOrFail();
                    $akunDebitPot->nominal += $request->potongan;
                    $akunDebitPot->save();
                    $akunKreditPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 112)->firstOrFail();
                    $akunKreditPot->nominal -= $request->potongan;
                    $akunKreditPot->save();
                }

                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menambahkan data piutang!',
                    'code' => 200,
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                LogError::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Tambah Piutang',
                    'message' => $e,
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal menambahkan data piutang!',
                    'code' => 500,
                ], 500);
            }
        }
        else if ($module === 'penyesuaian') {
            DB::beginTransaction();
            try {
                if ($request->jenis_transaksi == 527) {
                    $nomor_akun_kredit = 125;
                    $keterangan = "Penyusutan Peralatan";
                } 
                else if ($request->jenis_transaksi == 526) {
                    $nomor_akun_kredit = 123;
                    $keterangan = "Penyusutan Bangunan";
                }
                else if ($request->jenis_transaksi == 524) {
                    $nomor_akun_kredit = 113;
                    $keterangan = "Penyesuaian Perlengkapan";
                }
                else if ($request->jenis_transaksi == 114) {
                    $nomor_akun_kredit = 500;
                    $keterangan = "Persediaan Barang Dagang";
                }
                else {
                    throw new \Exception('Jenis transaksi tidak valid');
                }

                $transaksi = new Transaksi();
                $transaksi->user_id = Auth::user()->id;
                $transaksi->tgl = $request->tgl;
                $transaksi->nomor_akun_debit = $request->jenis_transaksi;
                $transaksi->nominal_debit = $request->nominal;
                $transaksi->nomor_akun_kredit = $nomor_akun_kredit;
                $transaksi->nominal_kredit = $request->nominal;
                $transaksi->keterangan = $keterangan;
                $transaksi->type = $module;
                $transaksi->save();

                $akunDebit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $request->jenis_transaksi)->firstOrFail();
                if ($akunDebit->saldo_normal == 'kredit') {
                    $akunDebit->nominal -= $request->nominal;
                } else {
                    $akunDebit->nominal += $request->nominal;
                }
                $akunDebit->save();

                $akunKredit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $nomor_akun_kredit)->firstOrFail();
                if ($akunKredit->saldo_normal == 'kredit') {
                    $akunKredit->nominal += $request->nominal;
                } else {
                    $akunKredit->nominal -= $request->nominal;
                }
                $akunKredit->save();

                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menambahkan data penyesuaian!',
                    'code' => 200,
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                LogError::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Tambah Penyesuaian',
                    'message' => $e,
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal menambahkan data penyesuaian!',
                    'code' => 500,
                ], 500);
            }
        }
        else {
            return response()->json([
                'status' => 'error',
                'message' => 'Module tidak valid!',
                'code' => 404,
            ], 404);
        }
    }

    public function processModuleUpdate($module, $request)
    {
        if ($module === 'pemasukan') {
            DB::beginTransaction();
            try {
                $transaksi = Transaksi::where('id', $request->id)->where('user_id', Auth::user()->id)->where('type', 'pemasukan')->firstOrFail();
                $potongan = Transaksi::where('user_id', Auth::user()->id)->where('keterangan', 'LIKE', "Potongan: ".$transaksi->keterangan)->where('type', 'pemasukan')->first();

                if ($request->jenis_transaksi == 111 || $request->jenis_transaksi == 121 || $request->jenis_transaksi == 122 || $request->jenis_transaksi == 124 || $request->jenis_transaksi == 511) {
                    $nomor_akun_kredit = 311;
                    $nomor_akun_debit = $request->jenis_transaksi;
                } else {
                    $nomor_akun_debit = 111;
                    $nomor_akun_kredit = $request->jenis_transaksi;
                }

                $akunDebit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $transaksi->nomor_akun_debit)->firstOrFail();
                if($nomor_akun_debit == $transaksi->nomor_akun_debit) {
                    if($akunDebit->saldo_normal == 'kredit') {
                        $akunDebit->nominal += $transaksi->nominal_debit;
                        $akunDebit->nominal -= $request->nominal;
                    } else {
                        $akunDebit->nominal -= $transaksi->nominal_debit;
                        $akunDebit->nominal += $request->nominal;
                    }
                    $akunDebit->save();
                }
                else {
                    if($akunDebit->saldo_normal == 'kredit') {
                        $akunDebit->nominal += $transaksi->nominal_debit;
                    } else {
                        $akunDebit->nominal -= $transaksi->nominal_debit;
                    }
                    $akunDebit->save();

                    $akunDebitBaru = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $nomor_akun_debit)->firstOrFail();
                    if ($akunDebitBaru->saldo_normal == 'kredit') {
                        $akunDebitBaru->nominal -= $request->nominal;
                    } else {
                        $akunDebitBaru->nominal += $request->nominal;
                    }
                    $akunDebitBaru->save();
                }

                $akunKredit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $transaksi->nomor_akun_kredit)->firstOrFail();
                if($nomor_akun_kredit == $transaksi->nomor_akun_kredit) {
                    if($akunKredit->saldo_normal == 'kredit') {
                        $akunKredit->nominal -= $transaksi->nominal_kredit;
                        $akunKredit->nominal += $request->nominal;
                    } else {
                        $akunKredit->nominal += $transaksi->nominal_kredit;
                        $akunKredit->nominal -= $request->nominal;
                    }
                    $akunKredit->save();
                }
                else {
                    if($akunKredit->saldo_normal == 'kredit') {
                        $akunKredit->nominal -= $transaksi->nominal_kredit;
                    } else {
                        $akunKredit->nominal += $transaksi->nominal_kredit;
                    }
                    $akunKredit->save();

                    $akunKreditBaru = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $nomor_akun_kredit)->firstOrFail();
                    if ($akunKreditBaru->saldo_normal == 'kredit') {
                        $akunKreditBaru->nominal += $request->nominal;
                    } else {
                        $akunKreditBaru->nominal -= $request->nominal;
                    }
                    $akunKreditBaru->save();
                }

                if($request->has('potongan')) {
                    if($potongan) {
                        $akunDebitPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 412)->firstOrFail();
                        $akunDebitPot->nominal -= $potongan->nominal_debit;
                        $akunDebitPot->nominal += $request->potongan;
    
                        $akunKreditPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 111)->firstOrFail();
                        $akunKreditPot->nominal += $potongan->nominal_kredit;
                        $akunKreditPot->nominal -= $request->potongan;

                        $potongan->user_id = Auth::user()->id;
                        $potongan->tgl = $request->tgl;
                        $potongan->nominal_debit = $request->potongan;
                        $potongan->nominal_kredit = $request->potongan;
                        $potongan->keterangan = "Potongan: " . ucfirst($request->keterangan);
                        $potongan->save();
                    }
                    else {
                        $transaksiPot = new Transaksi();
                        $transaksiPot->user_id = Auth::user()->id;
                        $transaksiPot->tgl = $request->tgl;
                        $transaksiPot->nomor_akun_debit = 412;
                        $transaksiPot->nominal_debit = $request->potongan;
                        $transaksiPot->nomor_akun_kredit = 111;
                        $transaksiPot->nominal_kredit = $request->potongan;
                        $transaksiPot->keterangan = "Potongan: " . ucfirst($request->keterangan);
                        $transaksiPot->type = $module;
                        $transaksiPot->save();

                        $akunDebitPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 412)->firstOrFail();
                        $akunDebitPot->nominal += $request->potongan;

                        $akunKreditPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 111)->firstOrFail();
                        $akunKreditPot->nominal -= $request->potongan;
                    }
                }
                else {
                    $akunDebitPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 412)->firstOrFail();
                    $akunKreditPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 111)->firstOrFail();
                    if($potongan) {
                        $akunDebitPot->nominal -= $potongan->nominal_debit;
    
                        $akunKreditPot->nominal += $potongan->nominal_kredit;

                        $potongan->delete();
                    }
                }
                $akunDebitPot->save();
                $akunKreditPot->save();

                $transaksi->user_id = Auth::user()->id;
                $transaksi->tgl = $request->tgl;
                $transaksi->nomor_akun_debit = $nomor_akun_debit;
                $transaksi->nominal_debit = $request->nominal;
                $transaksi->nomor_akun_kredit = $nomor_akun_kredit;
                $transaksi->nominal_kredit = $request->nominal;
                $transaksi->keterangan = ucfirst($request->keterangan);
                $transaksi->save();

                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengupdate data pemasukan!',
                    'code' => 200,
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                LogError::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Ubah Pemasukan',
                    'message' => $e,
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengupdate data pemasukan!',
                    'code' => 500,
                ], 500);
            }
        }
        else if ($module === 'pengeluaran') {
            DB::beginTransaction();
            try {
                $transaksi = Transaksi::where('id', $request->id)->where('user_id', Auth::user()->id)->where('type', 'pengeluaran')->firstOrFail();
                $potongan = Transaksi::where('user_id', Auth::user()->id)->where('keterangan', 'LIKE', "Potongan: " . $transaksi->keterangan)->where('type', 'pengeluaran')->first();

                $akunKredit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 111)->firstOrFail();
                $akunKredit->nominal += $transaksi->nominal_kredit;
                $akunKredit->nominal -= $request->nominal;
                $akunKredit->save();

                $akunDebit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $transaksi->nomor_akun_debit)->firstOrFail();
                if ($request->jenis_transaksi == $transaksi->nomor_akun_debit) {
                    if ($akunDebit->saldo_normal == 'kredit') {
                        $akunDebit->nominal += $transaksi->nominal_debit;
                        $akunDebit->nominal -= $request->nominal;
                    } else {
                        $akunDebit->nominal -= $transaksi->nominal_debit;
                        $akunDebit->nominal += $request->nominal;
                    }
                    $akunDebit->save();
                } else {
                    if ($akunDebit->saldo_normal == 'kredit') {
                        $akunDebit->nominal += $transaksi->nominal_debit;
                    } else {
                        $akunDebit->nominal -= $transaksi->nominal_debit;
                    }
                    $akunDebit->save();

                    $akunDebitBaru = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $request->jenis_transaksi)->firstOrFail();
                    if ($akunDebitBaru->saldo_normal == 'kredit') {
                        $akunDebitBaru->nominal -= $request->nominal;
                    } else {
                        $akunDebitBaru->nominal += $request->nominal;
                    }
                    $akunDebitBaru->save();
                }

                if ($request->has('potongan')) {
                    if ($potongan) {
                        $akunKreditPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 514)->firstOrFail();
                        $akunKreditPot->nominal -= $potongan->nominal_kredit;
                        $akunKreditPot->nominal += $request->potongan;

                        $akunDebitPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 111)->firstOrFail();
                        $akunDebitPot->nominal -= $potongan->nominal_debit;
                        $akunDebitPot->nominal += $request->potongan;

                        $potongan->user_id = Auth::user()->id;
                        $potongan->tgl = $request->tgl;
                        $potongan->nominal_debit = $request->potongan;
                        $potongan->nominal_kredit = $request->potongan;
                        $potongan->keterangan = "Potongan: " . ucfirst($request->keterangan);
                        $potongan->save();
                    } else {
                        $transaksiPot = new Transaksi();
                        $transaksiPot->user_id = Auth::user()->id;
                        $transaksiPot->tgl = $request->tgl;
                        $transaksiPot->nomor_akun_debit = 111;
                        $transaksiPot->nominal_debit = $request->potongan;
                        $transaksiPot->nomor_akun_kredit = 514;
                        $transaksiPot->nominal_kredit = $request->potongan;
                        $transaksiPot->keterangan = "Potongan: " . ucfirst($request->keterangan);
                        $transaksiPot->type = $module;
                        $transaksiPot->save();

                        $akunKreditPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 514)->firstOrFail();
                        $akunKreditPot->nominal += $request->potongan;

                        $akunDebitPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 111)->firstOrFail();
                        $akunDebitPot->nominal += $request->potongan;
                    }
                } else {
                    $akunKreditPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 514)->firstOrFail();
                    $akunDebitPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 111)->firstOrFail();
                    if ($potongan) {
                        $akunKreditPot->nominal -= $potongan->nominal_kredit;

                        $akunDebitPot->nominal -= $potongan->nominal_debit;

                        $potongan->delete();
                    }
                }
                $akunKreditPot->save();
                $akunDebitPot->save();

                $transaksi->user_id = Auth::user()->id;
                $transaksi->tgl = $request->tgl;
                $transaksi->nominal_debit = $request->nominal;
                $transaksi->nomor_akun_debit = $request->jenis_transaksi;
                $transaksi->nominal_kredit = $request->nominal;
                $transaksi->keterangan = ucfirst($request->keterangan);
                $transaksi->save();

                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengupdate data pengeluaran!',
                    'code' => 200,
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                LogError::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Ubah Pengeluaran',
                    'message' => $e,
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengupdate data pengeluaran!',
                    'code' => 500,
                ], 500);
            }
        }
        else if ($module === 'utang') {
            DB::beginTransaction();
            try {
                $transaksi = Transaksi::where('id', $request->id)->where('user_id', Auth::user()->id)->where('type', 'utang')->firstOrFail();
                $potongan = Transaksi::where('user_id', Auth::user()->id)->where('keterangan', 'LIKE', "Potongan: " . $transaksi->keterangan)->where('type', 'utang')->first();

                if ($request->jenis_transaksi == 511 || $request->jenis_transaksi == 512) {
                    $nomor_akun_kredit = 211;
                } else if ($request->jenis_transaksi == 211) {
                    $nomor_akun_kredit = 513;
                } else {
                    $nomor_akun_kredit = 212;
                }

                $akunKredit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $transaksi->nomor_akun_kredit)->firstOrFail();
                if ($nomor_akun_kredit == $transaksi->nomor_akun_kredit) {
                    if ($akunKredit->saldo_normal == 'kredit') {
                        $akunKredit->nominal -= $transaksi->nominal_kredit;
                        $akunKredit->nominal += $request->nominal;
                    } else {
                        $akunKredit->nominal += $transaksi->nominal_kredit;
                        $akunKredit->nominal -= $request->nominal;
                    }
                    $akunKredit->save();
                } else {
                    if ($akunKredit->saldo_normal == 'kredit') {
                        $akunKredit->nominal -= $transaksi->nominal_kredit;
                    } else {
                        $akunKredit->nominal += $transaksi->nominal_kredit;
                    }
                    $akunKredit->save();

                    $akunKreditBaru = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $nomor_akun_kredit)->firstOrFail();
                    if ($akunKreditBaru->saldo_normal == 'kredit') {
                        $akunKreditBaru->nominal += $request->nominal;
                    } else {
                        $akunKreditBaru->nominal -= $request->nominal;
                    }
                    $akunKreditBaru->save();
                }


                $akunDebit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $transaksi->nomor_akun_debit)->firstOrFail();
                if ($request->jenis_transaksi == $transaksi->nomor_akun_debit) {
                    if ($akunDebit->saldo_normal == 'kredit') {
                        $akunDebit->nominal += $transaksi->nominal_debit;
                        $akunDebit->nominal -= $request->nominal;
                    } else {
                        $akunDebit->nominal -= $transaksi->nominal_debit;
                        $akunDebit->nominal += $request->nominal;
                    }
                    $akunDebit->save();
                } else {
                    if ($akunDebit->saldo_normal == 'kredit') {
                        $akunDebit->nominal += $transaksi->nominal_debit;
                    } else {
                        $akunDebit->nominal -= $transaksi->nominal_debit;
                    }
                    $akunDebit->save();

                    $akunDebitBaru = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $request->jenis_transaksi)->firstOrFail();
                    if ($akunDebitBaru->saldo_normal == 'kredit') {
                        $akunDebitBaru->nominal -= $request->nominal;
                    } else {
                        $akunDebitBaru->nominal += $request->nominal;
                    }
                    $akunDebitBaru->save();
                }

                if ($request->has('potongan')) {
                    if ($potongan) {
                        $akunDebitPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 211)->firstOrFail();
                        $akunDebitPot->nominal += $potongan->nominal_debit;
                        $akunDebitPot->nominal -= $request->potongan;

                        $akunKreditPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 514)->firstOrFail();
                        $akunKreditPot->nominal -= $potongan->nominal_kredit;
                        $akunKreditPot->nominal += $request->potongan;

                        $potongan->user_id = Auth::user()->id;
                        $potongan->tgl = $request->tgl;
                        $potongan->nominal_debit = $request->potongan;
                        $potongan->nominal_kredit = $request->potongan;
                        $potongan->keterangan = "Potongan: " . ucfirst($request->keterangan);
                        $potongan->save();
                    } else {
                        $transaksiPot = new Transaksi();
                        $transaksiPot->user_id = Auth::user()->id;
                        $transaksiPot->tgl = $request->tgl;
                        $transaksiPot->nomor_akun_debit = 211;
                        $transaksiPot->nominal_debit = $request->potongan;
                        $transaksiPot->nomor_akun_kredit = 514;
                        $transaksiPot->nominal_kredit = $request->potongan;
                        $transaksiPot->keterangan = "Potongan: " . ucfirst($request->keterangan);
                        $transaksiPot->type = $module;
                        $transaksiPot->save();

                        $akunDebitPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 211)->firstOrFail();
                        $akunDebitPot->nominal -= $request->potongan;

                        $akunKreditPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 514)->firstOrFail();
                        $akunKreditPot->nominal += $request->potongan;
                    }
                } else {
                    $akunDebitPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 211)->firstOrFail();
                    $akunKreditPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 514)->firstOrFail();
                    if ($potongan) {
                        $akunDebitPot->nominal += $potongan->nominal_debit;

                        $akunKreditPot->nominal -= $potongan->nominal_kredit;

                        $potongan->delete();
                    }
                }
                $akunDebitPot->save();
                $akunKreditPot->save();

                $transaksi->user_id = Auth::user()->id;
                $transaksi->tgl = $request->tgl;
                $transaksi->nomor_akun_debit = $request->jenis_transaksi;
                $transaksi->nominal_debit = $request->nominal;
                $transaksi->nomor_akun_kredit = $nomor_akun_kredit;
                $transaksi->nominal_kredit = $request->nominal;
                $transaksi->keterangan = ucfirst($request->keterangan);
                $transaksi->save();

                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengupdate data utang!',
                    'code' => 200,
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                LogError::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Ubah Utang',
                    'message' => $e,
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengupdate data utang!',
                    'code' => 500,
                ], 500);
            }
        }
        else if ($module === 'piutang') {
            DB::beginTransaction();
            try {
                $transaksi = Transaksi::where('id', $request->id)->where('user_id', Auth::user()->id)->where('type', 'piutang')->firstOrFail();
                $potongan = Transaksi::where('user_id', Auth::user()->id)->where('keterangan', 'LIKE', "Potongan: " . $transaksi->keterangan)->where('type', 'piutang')->first();

                if ($request->jenis_transaksi == 112) {
                    $nomor_akun_debit = 413;
                } else {
                    $nomor_akun_debit = 112;
                }

                $akunDebit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $transaksi->nomor_akun_debit)->firstOrFail();
                if ($nomor_akun_debit == $transaksi->nomor_akun_debit) {
                    if ($akunDebit->saldo_normal == 'kredit') {
                        $akunDebit->nominal += $transaksi->nominal_debit;
                        $akunDebit->nominal -= $request->nominal;
                    } else {
                        $akunDebit->nominal -= $transaksi->nominal_debit;
                        $akunDebit->nominal += $request->nominal;
                    }
                    $akunDebit->save();
                } else {
                    if ($akunDebit->saldo_normal == 'kredit') {
                        $akunDebit->nominal += $transaksi->nominal_debit;
                    } else {
                        $akunDebit->nominal -= $transaksi->nominal_debit;
                    }
                    $akunDebit->save();

                    $akunDebitBaru = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $nomor_akun_debit)->firstOrFail();
                    if ($akunDebitBaru->saldo_normal == 'kredit') {
                        $akunDebitBaru->nominal -= $request->nominal;
                    } else {
                        $akunDebitBaru->nominal += $request->nominal;
                    }
                    $akunDebitBaru->save();
                }


                $akunKredit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $transaksi->nomor_akun_kredit)->firstOrFail();
                if ($request->jenis_transaksi == $transaksi->nomor_akun_kredit) {
                    if ($akunKredit->saldo_normal == 'kredit') {
                        $akunKredit->nominal -= $transaksi->nominal_kredit;
                        $akunKredit->nominal += $request->nominal;
                    } else {
                        $akunKredit->nominal += $transaksi->nominal_kredit;
                        $akunKredit->nominal -= $request->nominal;
                    }
                    $akunKredit->save();
                } else {
                    if ($akunKredit->saldo_normal == 'kredit') {
                        $akunKredit->nominal -= $transaksi->nominal_kredit;
                    } else {
                        $akunKredit->nominal += $transaksi->nominal_kredit;
                    }
                    $akunKredit->save();

                    $akunKreditBaru = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $request->jenis_transaksi)->firstOrFail();
                    if ($akunKreditBaru->saldo_normal == 'kredit') {
                        $akunKreditBaru->nominal += $request->nominal;
                    } else {
                        $akunKreditBaru->nominal -= $request->nominal;
                    }
                    $akunKreditBaru->save();
                }

                if ($request->has('potongan')) {
                    if ($potongan) {
                        $akunDebitPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 412)->firstOrFail();
                        $akunDebitPot->nominal -= $potongan->nominal_debit;
                        $akunDebitPot->nominal += $request->potongan;

                        $akunKreditPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 112)->firstOrFail();
                        $akunKreditPot->nominal += $potongan->nominal_kredit;
                        $akunKreditPot->nominal -= $request->potongan;

                        $potongan->user_id = Auth::user()->id;
                        $potongan->tgl = $request->tgl;
                        $potongan->nominal_debit = $request->potongan;
                        $potongan->nominal_kredit = $request->potongan;
                        $potongan->keterangan = "Potongan: " . ucfirst($request->keterangan);
                        $potongan->save();
                    } else {
                        $transaksiPot = new Transaksi();
                        $transaksiPot->user_id = Auth::user()->id;
                        $transaksiPot->tgl = $request->tgl;
                        $transaksiPot->nomor_akun_debit = 412;
                        $transaksiPot->nominal_debit = $request->potongan;
                        $transaksiPot->nomor_akun_kredit = 112;
                        $transaksiPot->nominal_kredit = $request->potongan;
                        $transaksiPot->keterangan = "Potongan: " . ucfirst($request->keterangan);
                        $transaksiPot->type = $module;
                        $transaksiPot->save();

                        $akunDebitPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 412)->firstOrFail();
                        $akunDebitPot->nominal += $request->potongan;

                        $akunKreditPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 112)->firstOrFail();
                        $akunKreditPot->nominal -= $request->potongan;
                    }
                } else {
                    $akunDebitPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 412)->firstOrFail();
                    $akunKreditPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 112)->firstOrFail();
                    if ($potongan) {
                        $akunDebitPot->nominal -= $potongan->nominal_debit;

                        $akunKreditPot->nominal += $potongan->nominal_kredit;

                        $potongan->delete();
                    }
                }
                $akunDebitPot->save();
                $akunKreditPot->save();

                $transaksi->user_id = Auth::user()->id;
                $transaksi->tgl = $request->tgl;
                $transaksi->nomor_akun_debit = $nomor_akun_debit;
                $transaksi->nominal_debit = $request->nominal;
                $transaksi->nomor_akun_kredit = $request->jenis_transaksi;
                $transaksi->nominal_kredit = $request->nominal;
                $transaksi->keterangan = ucfirst($request->keterangan);
                $transaksi->save();

                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengupdate data piutang!',
                    'code' => 200,
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                LogError::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Ubah Piutang',
                    'message' => $e,
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengupdate data piutang!',
                    'code' => 500,
                ], 500);
            }
        }
        else if ($module === 'penyesuaian') {
            DB::beginTransaction();
            try {
                $transaksi = Transaksi::where('id', $request->id)->where('user_id', Auth::user()->id)->where('type', 'penyesuaian')->firstOrFail();

                if ($request->jenis_transaksi == 527) {
                    $nomor_akun_kredit = 125;
                    $keterangan = "Penyusutan Peralatan";
                } 
                else if ($request->jenis_transaksi == 526) {
                    $nomor_akun_kredit = 123;
                    $keterangan = "Penyusutan Bangunan";
                }
                else if ($request->jenis_transaksi == 524) {
                    $nomor_akun_kredit = 113;
                    $keterangan = "Penyesuaian Perlengkapan";
                }
                else if ($request->jenis_transaksi == 114) {
                    $nomor_akun_kredit = 500;
                    $keterangan = "Persediaan Barang Dagang";
                }
                else {
                    throw new \Exception('Jenis transaksi tidak valid');
                }

                $akunDebit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $transaksi->nomor_akun_debit)->firstOrFail();
                if ($request->jenis_transaksi == $transaksi->nomor_akun_debit) {
                    if ($akunDebit->saldo_normal == 'kredit') {
                        $akunDebit->nominal += $transaksi->nominal_debit;
                        $akunDebit->nominal -= $request->nominal;
                    } else {
                        $akunDebit->nominal -= $transaksi->nominal_debit;
                        $akunDebit->nominal += $request->nominal;
                    }
                    $akunDebit->save();
                } else {
                    if ($akunDebit->saldo_normal == 'kredit') {
                        $akunDebit->nominal += $transaksi->nominal_debit;
                    } else {
                        $akunDebit->nominal -= $transaksi->nominal_debit;
                    }
                    $akunDebit->save();

                    $akunDebitBaru = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $request->jenis_transaksi)->firstOrFail();
                    if ($akunDebitBaru->saldo_normal == 'kredit') {
                        $akunDebitBaru->nominal -= $request->nominal;
                    } else {
                        $akunDebitBaru->nominal += $request->nominal;
                    }
                    $akunDebitBaru->save();
                }


                $akunKredit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $transaksi->nomor_akun_kredit)->firstOrFail();
                if ($nomor_akun_kredit == $transaksi->nomor_akun_kredit) {
                    if ($akunKredit->saldo_normal == 'kredit') {
                        $akunKredit->nominal -= $transaksi->nominal_kredit;
                        $akunKredit->nominal += $request->nominal;
                    } else {
                        $akunKredit->nominal += $transaksi->nominal_kredit;
                        $akunKredit->nominal -= $request->nominal;
                    }
                    $akunKredit->save();
                } else {
                    if ($akunKredit->saldo_normal == 'kredit') {
                        $akunKredit->nominal -= $transaksi->nominal_kredit;
                    } else {
                        $akunKredit->nominal += $transaksi->nominal_kredit;
                    }
                    $akunKredit->save();

                    $akunKreditBaru = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $nomor_akun_kredit)->firstOrFail();
                    if ($akunKreditBaru->saldo_normal == 'kredit') {
                        $akunKreditBaru->nominal += $request->nominal;
                    } else {
                        $akunKreditBaru->nominal -= $request->nominal;
                    }
                    $akunKreditBaru->save();
                }

                $transaksi->user_id = Auth::user()->id;
                $transaksi->tgl = $request->tgl;
                $transaksi->nomor_akun_debit = $request->jenis_transaksi;
                $transaksi->nominal_debit = $request->nominal;
                $transaksi->nomor_akun_kredit = $nomor_akun_kredit;
                $transaksi->nominal_kredit = $request->nominal;
                $transaksi->keterangan = $keterangan;
                $transaksi->save();

                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil mengupdate data penyesuaian!',
                    'code' => 200,
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                LogError::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Ubah Penyesuaian',
                    'message' => $e,
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengupdate data penyesuaian!',
                    'code' => 500,
                ], 500);
            }
        }
        else {
            return response()->json([
                'status' => 'error',
                'message' => 'Module tidak valid!',
                'code' => 404,
            ], 404);
        }
    }

    public function processModuleDestroy($module, $request)
    {
        if ($module === 'pemasukan') {
            DB::beginTransaction();
            try {
                $transaksi = Transaksi::where('id', $request->id)->where('user_id', Auth::user()->id)->where('type', 'pemasukan')->firstOrFail();
                $potongan = Transaksi::where('user_id', Auth::user()->id)->where('keterangan', 'LIKE', "Potongan: ".$transaksi->keterangan)->where('type', 'pemasukan')->first();

                $akunDebit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $transaksi->nomor_akun_debit)->firstOrFail();
                if ($akunDebit->saldo_normal == 'kredit') {
                    $akunDebit->nominal += $transaksi->nominal_debit;
                    $akunDebit->save();
                }
                else {
                    $akunDebit->nominal -= $transaksi->nominal_debit;
                    $akunDebit->save();
                }

                $akunKredit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $transaksi->nomor_akun_kredit)->firstOrFail();
                if ($akunKredit->saldo_normal == 'kredit') {
                    $akunKredit->nominal -= $transaksi->nominal_kredit;
                    $akunKredit->save();
                }
                else {
                    $akunKredit->nominal += $transaksi->nominal_kredit;
                    $akunKredit->save();
                }

                if ($potongan) {
                    $akunDebitPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 412)->firstOrFail();
                    $akunDebitPot->nominal -= $potongan->nominal_debit;
                    $akunDebitPot->save();
                    $akunKreditPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 111)->firstOrFail();
                    $akunKreditPot->nominal += $potongan->nominal_kredit;
                    $akunKreditPot->save();

                    $potongan->delete();
                }
                $transaksi->delete();

                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menghapus data pemasukan!',
                    'code' => 200,
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                LogError::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Hapus Pemasukan',
                    'message' => $e,
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengahapus data pemasukan!',
                    'code' => 500,
                ], 500);
            }
        }
        else if ($module === 'pengeluaran') {
            DB::beginTransaction();
            try {
                $transaksi = Transaksi::where('id', $request->id)->where('user_id', Auth::user()->id)->where('type', 'pengeluaran')->firstOrFail();
                $potongan = Transaksi::where('user_id', Auth::user()->id)->where('keterangan', 'LIKE', "Potongan: " . $transaksi->keterangan)->where('type', 'pengeluaran')->first();

                $akunKredit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 111)->firstOrFail();
                $akunKredit->nominal += $transaksi->nominal_kredit;
                $akunKredit->save();

                $akunDebit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $transaksi->nomor_akun_debit)->firstOrFail();
                if ($akunDebit->saldo_normal == 'kredit') {
                    $akunDebit->nominal += $transaksi->nominal_debit;
                    $akunDebit->save();
                } else {
                    $akunDebit->nominal -= $transaksi->nominal_debit;
                    $akunDebit->save();
                }

                if ($potongan) {
                    $akunKreditPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 514)->firstOrFail();
                    $akunKreditPot->nominal -= $potongan->nominal_kredit;
                    $akunKreditPot->save();
                    $akunDebitPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 111)->firstOrFail();
                    $akunDebitPot->nominal -= $potongan->nominal_debit;
                    $akunDebitPot->save();

                    $potongan->delete();
                }
                $transaksi->delete();

                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menghapus data pengeluaran!',
                    'code' => 200,
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                LogError::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Hapus Pengeluaran',
                    'message' => $e,
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengahapus data pengeluaran!',
                    'code' => 500,
                ], 500);
            }
        }
        else if ($module === 'utang') {
            DB::beginTransaction();
            try {
                $transaksi = Transaksi::where('id', $request->id)->where('user_id', Auth::user()->id)->where('type', 'utang')->firstOrFail();
                $potongan = Transaksi::where('user_id', Auth::user()->id)->where('keterangan', 'LIKE', "Potongan: " . $transaksi->keterangan)->where('type', 'utang')->first();

                $akunKredit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $transaksi->nomor_akun_kredit)->firstOrFail();
                if ($akunKredit->saldo_normal == 'kredit') {
                    $akunKredit->nominal -= $transaksi->nominal_kredit;
                } else {
                    $akunKredit->nominal += $transaksi->nominal_kredit;
                }
                $akunKredit->save();

                $akunDebit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $transaksi->nomor_akun_debit)->firstOrFail();
                if ($akunDebit->saldo_normal == 'kredit') {
                    $akunDebit->nominal += $transaksi->nominal_debit;
                    $akunDebit->save();
                } else {
                    $akunDebit->nominal -= $transaksi->nominal_debit;
                    $akunDebit->save();
                }

                if ($potongan) {
                    $akunDebitPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 211)->firstOrFail();
                    $akunDebitPot->nominal += $potongan->nominal_debit;
                    $akunDebitPot->save();
                    $akunKreditPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 514)->firstOrFail();
                    $akunKreditPot->nominal -= $potongan->nominal_kredit;
                    $akunKreditPot->save();

                    $potongan->delete();
                }
                $transaksi->delete();

                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menghapus data utang!',
                    'code' => 200,
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                LogError::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Hapus Utang',
                    'message' => $e,
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengahapus data utang!',
                    'code' => 500,
                ], 500);
            }
        }
        else if ($module === 'piutang') {
            DB::beginTransaction();
            try {
                $transaksi = Transaksi::where('id', $request->id)->where('user_id', Auth::user()->id)->where('type', 'piutang')->firstOrFail();
                $potongan = Transaksi::where('user_id', Auth::user()->id)->where('keterangan', 'LIKE', "Potongan: " . $transaksi->keterangan)->where('type', 'piutang')->first();

                $akunDebit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $transaksi->nomor_akun_debit)->firstOrFail();
                if ($akunDebit->saldo_normal == 'kredit') {
                    $akunDebit->nominal += $transaksi->nominal_debit;
                } else {
                    $akunDebit->nominal -= $transaksi->nominal_debit;
                }
                $akunDebit->save();

                $akunKredit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $transaksi->nomor_akun_kredit)->firstOrFail();
                if ($akunKredit->saldo_normal == 'kredit') {
                    $akunKredit->nominal -= $transaksi->nominal_kredit;
                    $akunKredit->save();
                } else {
                    $akunKredit->nominal += $transaksi->nominal_kredit;
                    $akunKredit->save();
                }

                if ($potongan) {
                    $akunDebitPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 412)->firstOrFail();
                    $akunDebitPot->nominal -= $potongan->nominal_debit;
                    $akunDebitPot->save();
                    $akunKreditPot = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', 112)->firstOrFail();
                    $akunKreditPot->nominal += $potongan->nominal_kredit;
                    $akunKreditPot->save();

                    $potongan->delete();
                }
                $transaksi->delete();

                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menghapus data piutang!',
                    'code' => 200,
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                LogError::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Hapus Piutang',
                    'message' => $e,
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengahapus data piutang!',
                    'code' => 500,
                ], 500);
            }
        }
        else if ($module === 'penyesuaian') {
            DB::beginTransaction();
            try {
                $transaksi = Transaksi::where('id', $request->id)->where('user_id', Auth::user()->id)->where('type', 'penyesuaian')->firstOrFail();

                $akunDebit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $transaksi->nomor_akun_debit)->firstOrFail();
                if ($akunDebit->saldo_normal == 'kredit') {
                    $akunDebit->nominal += $transaksi->nominal_debit;
                } else {
                    $akunDebit->nominal -= $transaksi->nominal_debit;
                }
                $akunDebit->save();

                $akunKredit = MasterAkun::where('user_id', Auth::user()->id)->where('nomor_akun', $transaksi->nomor_akun_kredit)->firstOrFail();
                if ($akunKredit->saldo_normal == 'kredit') {
                    $akunKredit->nominal -= $transaksi->nominal_kredit;
                    $akunKredit->save();
                } else {
                    $akunKredit->nominal += $transaksi->nominal_kredit;
                    $akunKredit->save();
                }

                $transaksi->delete();

                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menghapus data penyesuaian!',
                    'code' => 200,
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                LogError::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Hapus Penyesuaian',
                    'message' => $e,
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengahapus data penyesuaian!',
                    'code' => 500,
                ], 500);
            }
        }
        else {
            return response()->json([
                'status' => 'error',
                'message' => 'Module tidak valid!',
                'code' => 404,
            ], 404);
        }
    }
}