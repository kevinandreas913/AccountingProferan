<?php

namespace App\Console\Commands;

use App\Models\MasterAkun;
use App\Models\RekapDataAkun;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RekapAkunBulanan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:data-akun-bulanan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Memindahkan data dari tabel master akun ke rekap data akun setiap awal bulan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $masterAkunByUser = MasterAkun::get()->groupBy('user_id');
        DB::beginTransaction();
        try {
            foreach ($masterAkunByUser as $dataAkun) {
                $dataAkunGroupped = $dataAkun->groupBy('jenis_akun_id')
                    ->map(function($data) {
                        return $data->groupBy('nama')->map(function($data) {
                            return $data->first();
                        });
                    });

                // total beban operasional
                $bebanTeleponDanListrik = $dataAkunGroupped['JK-PFA-2024-014']['Beban Telepon dan Listrik']->nominal;
                $bebanAir = $dataAkunGroupped['JK-PFA-2024-014']['Beban Air']->nominal;
                $bebanPerlengkapanToko = $dataAkunGroupped['JK-PFA-2024-014']['Beban Perlengkapan Toko']->nominal;
                $bebanPeralatanToko = $dataAkunGroupped['JK-PFA-2024-014']['Beban Peralatan Toko']->nominal;
                $bebanPenyusutanBangunan = $dataAkunGroupped['JK-PFA-2024-014']['Beban Penyusutan Bangunan']->nominal;
                $bebanPenyusutanPeralatan = $dataAkunGroupped['JK-PFA-2024-014']['Beban Penyusutan Peralatan']->nominal;
                $bebanGajiKaryawan = $dataAkunGroupped['JK-PFA-2024-014']['Beban Gaji Karyawan']->nominal;
                $bebanIklan = $dataAkunGroupped['JK-PFA-2024-014']['Beban Iklan']->nominal;
                $bebanAdministrasiBank = $dataAkunGroupped['JK-PFA-2024-014']['Beban Administrasi Bank']->nominal;
                $bebanOperasiLainnya = $dataAkunGroupped['JK-PFA-2024-014']['Beban Operasi Lainnya']->nominal;
                $bebanAngkutPenjualan = $dataAkunGroupped['JK-PFA-2024-014']['Beban Angkut Penjualan']->nominal;
                $bebanLainLain = $dataAkunGroupped['JK-PFA-2024-015']['Beban Lain-lain']->nominal;
                // total beban operasional
                $totalBebanOperasional = $bebanTeleponDanListrik + $bebanAir + $bebanPerlengkapanToko + $bebanPeralatanToko + $bebanPenyusutanBangunan + $bebanPenyusutanPeralatan + $bebanGajiKaryawan + $bebanIklan + $bebanAdministrasiBank + $bebanOperasiLainnya + $bebanAngkutPenjualan + $bebanLainLain;
                
                // total pendapatan lain-lain
                $totalPendapatanLainLain = $dataAkunGroupped['JK-PFA-2024-016']['Pendapatan Bunga']->nominal + $dataAkunGroupped['JK-PFA-2024-016']['Pendapatan Usaha Lain']->nominal + $dataAkunGroupped['JK-PFA-2024-016']['Pendapatan Lain-lain']->nominal;
                // total pendapatan lain-lain

                // total pendapatan lain dan beban
                $totalPendapatanLainDanBeban = $totalPendapatanLainLain - $totalBebanOperasional;                

                // harga pokok penjualan
                $pembelianBersih = $dataAkunGroupped['JK-PFA-2024-013']['Pembelian Barang Dagang']->nominal + $dataAkunGroupped['JK-PFA-2024-013']['Beban Angkut Pembelian']->nominal - $dataAkunGroupped['JK-PFA-2024-013']['Retur Pembelian']->nominal - $dataAkunGroupped['JK-PFA-2024-013']['Potongan Pembelian']->nominal;
                $persediaanAkhirBarang = $dataAkunGroupped['JK-PFA-2024-013']['Harga Pokok Penjualan']->nominal;
                // harga pokok penjualan
                $hargaPokokPenjualan = $pembelianBersih - $persediaanAkhirBarang;
            
                // penjualan bersih
                $penjualanBersih = $dataAkunGroupped['JK-PFA-2024-012']['Penjualan']->nominal - $dataAkunGroupped['JK-PFA-2024-012']['Potongan Penjualan']->nominal - $dataAkunGroupped['JK-PFA-2024-012']['Retur Penjualan']->nominal;
                // penjualan bersih
                
                // laba kotor
                $labaKotor = $penjualanBersih - $hargaPokokPenjualan;
                
                // laba rugi usaha / pertambahan modal
                $labaRugiUsaha = $labaKotor + $totalPendapatanLainDanBeban;

                $modalAwal = $dataAkunGroupped['JK-PFA-2024-011']['Modal Usaha']->nominal;

                $total = $modalAwal + $labaRugiUsaha;

                $prive = -$dataAkunGroupped['JK-PFA-2024-011']['Prive']->nominal;

                $modalAkhir = $total + $prive;

                $persediaanBarangDagang = $dataAkunGroupped['JK-PFA-2024-004']['Persediaan Barang Dagang']->nominal;

                foreach ($dataAkun as $data) {
                    // move all data account to backup
                    $rekap = new RekapDataAkun();
                    $rekap->user_id = $data->user_id;
                    $rekap->nama = $data->nama;
                    $rekap->nomor_akun = $data->nomor_akun;
                    $rekap->saldo_normal = $data->saldo_normal;
                    $rekap->jenis_akun_id = $data->jenis_akun_id;
                    $rekap->nominal = $data->nominal;
                    $rekap->periode_bulan = $data->periode_bulan;
                    $rekap->periode_tahun = $data->periode_tahun;
                    $rekap->save();

                    $data->periode_bulan = Carbon::now()->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F');
                    $data->periode_tahun = date('Y');
    
                    // to 0 on account type 11 - 16
                    for ($i = 11; $i <= 16; $i++) {
                        if($data->jenis_akun_id == "JK-PFA-2024-0$i") {
                            $data->nominal = 0;
                            $data->save();
                            break;
                        }
                    }

                    switch ($data->nomor_akun) {
                        case 311:
                            $data->nominal = $modalAkhir;
                            $data->save();
                            break;
                        case 511:
                            $data->nominal = $persediaanBarangDagang;
                            $data->save();
                            break;
                        case 114:
                            $data->nominal = 0;
                            $data->save();
                            break;
                        default:
                    }
                }
            }

            DB::commit();
            return $this->info('Berhasil backup data akun...');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->info($e->getMessage());
        }
    }
}
