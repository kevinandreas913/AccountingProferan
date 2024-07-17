<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />

    <title>Laporan Neraca - {{ $dataUsaha['nama'] }}</title>
</head>
<style>
body {
    font-family: Arial, sans-serif;
}
.header {
    text-align: center;
    margin-bottom: 50px;
    font-size: 18px;
}
.namaUsaha, .judulLaporan {
    font-size: 24px;
    font-weight: bold;
}
.sub-title {
    font-size: 20px;
    font-weight: bold;
}
table {
    width: 50%;
    border-collapse: collapse;
    font-size: 18px;
}
.text-center {
    text-align: center;
}
.text-left {
    text-align: left;
}
.text-right {
    text-align: right;
}
.ml-10 {
    margin-left: 10px;
}
.mr-10 {
    margin-right: 10px;
}
.border-top {
    border-top: 2px solid;
    font-weight: bold;
    font-size: 18px;
}
.border-right {
    border-right: 2px solid;
}
.float-right {
    float: right;
}
.float-left {
    float:left;
}
.p-1 {
    padding: 0 5px;
}
</style>
<body>
    <div class="header">
        <span class="namaUsaha">{{ $dataUsaha['nama'] }}</span>
        <br>
        <span class="judulLaporan">Laporan Neraca</span>
        <br>
        <span>Per {{ $dataUsaha['bulan'] }} {{ $dataUsaha['tahun'] }}</span>
    </div>

    @php
        // total beban operasional
        $bebanTeleponDanListrik = $data['JK-PFA-2024-014']['Beban Telepon dan Listrik']->nominal;
        $bebanAir = $data['JK-PFA-2024-014']['Beban Air']->nominal;
        $bebanPerlengkapanToko = $data['JK-PFA-2024-014']['Beban Perlengkapan Toko']->nominal;
        $bebanPeralatanToko = $data['JK-PFA-2024-014']['Beban Peralatan Toko']->nominal;
        $bebanPenyusutanBangunan = $data['JK-PFA-2024-014']['Beban Penyusutan Bangunan']->nominal;
        $bebanPenyusutanPeralatan = $data['JK-PFA-2024-014']['Beban Penyusutan Peralatan']->nominal;
        $bebanGajiKaryawan = $data['JK-PFA-2024-014']['Beban Gaji Karyawan']->nominal;
        $bebanIklan = $data['JK-PFA-2024-014']['Beban Iklan']->nominal;
        $bebanAdministrasiBank = $data['JK-PFA-2024-014']['Beban Administrasi Bank']->nominal;
        $bebanOperasiLainnya = $data['JK-PFA-2024-014']['Beban Operasi Lainnya']->nominal;
        $bebanAngkutPenjualan = $data['JK-PFA-2024-014']['Beban Angkut Penjualan']->nominal;
        $bebanLainLain = $data['JK-PFA-2024-015']['Beban Lain-lain']->nominal;
        // total beban operasional
        $totalBebanOperasional = $bebanTeleponDanListrik + $bebanAir + $bebanPerlengkapanToko + $bebanPeralatanToko + $bebanPenyusutanBangunan + $bebanPenyusutanPeralatan + $bebanGajiKaryawan + $bebanIklan + $bebanAdministrasiBank + $bebanOperasiLainnya + $bebanAngkutPenjualan + $bebanLainLain;
        
        // total pendapatan lain-lain
        $totalPendapatanLainLain = $data['JK-PFA-2024-016']['Pendapatan Bunga']->nominal + $data['JK-PFA-2024-016']['Pendapatan Usaha Lain']->nominal + $data['JK-PFA-2024-016']['Pendapatan Lain-lain']->nominal;
        // total pendapatan lain-lain

        // total pendapatan lain dan beban
        $totalPendapatanLainDanBeban = $totalPendapatanLainLain - $totalBebanOperasional;                

        // harga pokok penjualan
        $pembelianBersih = $data['JK-PFA-2024-013']['Pembelian Barang Dagang']->nominal + $data['JK-PFA-2024-013']['Beban Angkut Pembelian']->nominal - $data['JK-PFA-2024-013']['Retur Pembelian']->nominal - $data['JK-PFA-2024-013']['Potongan Pembelian']->nominal;
        $persediaanAkhirBarang = $data['JK-PFA-2024-013']['Harga Pokok Penjualan']->nominal;
        // harga pokok penjualan
        $hargaPokokPenjualan = $pembelianBersih - $persediaanAkhirBarang;
    
        // penjualan bersih
        $penjualanBersih = $data['JK-PFA-2024-012']['Penjualan']->nominal - $data['JK-PFA-2024-012']['Potongan Penjualan']->nominal - $data['JK-PFA-2024-012']['Retur Penjualan']->nominal;
        // penjualan bersih
        
        // laba kotor
        $labaKotor = $penjualanBersih - $hargaPokokPenjualan;
        
        // laba rugi usaha / pertambahan modal
        $labaRugiUsaha = $labaKotor + $totalPendapatanLainDanBeban;

        $modalAwal = $data['JK-PFA-2024-011']['Modal Usaha']->nominal;

        $total = $modalAwal + $labaRugiUsaha;

        $prive = -$data['JK-PFA-2024-011']['Prive']->nominal;

        $modalAkhir = $total + $prive;


        // aktiva lancar
        $kas = $data['JK-PFA-2024-001']['Kas']->nominal;
        $piutangUsaha = $data['JK-PFA-2024-002']['Piutang Usaha']->nominal;
        $perlengkapan = $data['JK-PFA-2024-004']['Perlengkapan']->nominal;
        $persediaanBarangDagang = $data['JK-PFA-2024-004']['Persediaan Barang Dagang']->nominal;
        $totalAktivaLancar = $kas + $piutangUsaha + $perlengkapan + $persediaanBarangDagang;
        // end aktiva lancar

        // aktiva tetap
        $tanah = $data['JK-PFA-2024-005']['Tanah']->nominal;
        $bangunan = $data['JK-PFA-2024-005']['Bangunan']->nominal;
        $akumulasiPenyusutanBangunan = $data['JK-PFA-2024-006']['Akumulasi Penyusutan Bangunan']->nominal;
        $peralatan = $data['JK-PFA-2024-005']['Peralatan']->nominal;
        $akumulasiPenyusutanPeralatan = $data['JK-PFA-2024-006']['Akumulasi Penyusutan Peralatan']->nominal;

        $totalAktivaTetap = $tanah + $bangunan - $akumulasiPenyusutanBangunan + $peralatan - $akumulasiPenyusutanPeralatan;
        // end aktiva tetap

        $totalAktiva = $totalAktivaLancar + $totalAktivaTetap;

        // utang lancar
        $utangUsaha = $data['JK-PFA-2024-008']['Utang Usaha']->nominal;
        $utangBeban = $data['JK-PFA-2024-009']['Utang Beban']->nominal;
        $totalUtangLancar = $utangUsaha + $utangBeban;
        // end utang lancar

        // utang jangka panjang
        $utangJangkaPanjangLainnya = $data['JK-PFA-2024-010']['Utang Jangka Panjang Lainnya']->nominal;
        $totalUtangJangkaPanjang = $utangJangkaPanjangLainnya;
        // end utang jangka panjang

        $totalUtangDanModal = $totalUtangLancar + $totalUtangJangkaPanjang + $modalAkhir;
    @endphp

    <table class="float-left">
        <tbody>
            <tr>
                <td class="sub-title">Aktiva</td>
                <td></td>
                <td class="border-right"></td>
            </tr>
            <tr>
                <td class="sub-title">Aktiva Lancar</td>
                <td></td>
                <td class="border-right"></td>
            </tr>
            {{-- content aktiva lancar --}}
                <tr>
                    <td>{{ $data['JK-PFA-2024-001']['Kas']->nama }}</td>
                    <td>{{ 'Rp '.number_format($kas) }}</td>
                    <td class="border-right"></td>
                </tr>
                <tr>
                    <td>{{ $data['JK-PFA-2024-002']['Piutang Usaha']->nama }}</td>
                    <td>{{ 'Rp '.number_format($piutangUsaha) }}</td>
                    <td class="border-right"></td>
                </tr>
                <tr>
                    <td>{{ $data['JK-PFA-2024-004']['Perlengkapan']->nama }}</td>
                    <td>{{ 'Rp '.number_format($perlengkapan) }}</td>
                    <td class="border-right"></td>
                </tr>
                <tr>
                    <td>{{ $data['JK-PFA-2024-004']['Persediaan Barang Dagang']->nama }}</td>
                    <td>{{ 'Rp '.number_format($persediaanBarangDagang) }}</td>
                    <td class="border-right"></td>
                </tr>
            {{-- end content aktiva lancar --}}
            <tr>
                <td class="sub-title">Total Aktiva Lancar</td>
                <td></td>
                <td class="text-right border-top border-right">
                    <span class="mr-10">
                        {{ 'Rp '.number_format($totalAktivaLancar) }}
                    </span>
                </td>
            </tr>
            <tr><td colspan="3" class="border-right">&nbsp;</td></tr>
            <tr>
                <td class="sub-title">Aktiva Tetap</td>
                <td></td>
                <td class="border-right"></td>
            </tr>
            {{-- content aktiva tetap --}}
                <tr>
                    <td>{{ $data['JK-PFA-2024-005']['Tanah']->nama }}</td>
                    <td>{{ 'Rp '.number_format($tanah) }}</td>
                    <td class="border-right"></td>
                </tr>
                <tr>
                    <td>{{ $data['JK-PFA-2024-005']['Bangunan']->nama }}</td>
                    <td>{{ 'Rp '.number_format($bangunan) }}</td>
                    <td class="border-right"></td>
                </tr>
                <tr>
                    <td>{{ $data['JK-PFA-2024-006']['Akumulasi Penyusutan Bangunan']->nama }}</td>
                    <td>{{ 'Rp '.number_format($akumulasiPenyusutanBangunan) }}</td>
                    <td class="border-right"></td>
                </tr>
                <tr>
                    <td>{{ $data['JK-PFA-2024-005']['Peralatan']->nama }}</td>
                    <td>{{ 'Rp '.number_format($peralatan) }}</td>
                    <td class="border-right"></td>
                </tr>
                <tr>
                    <td>{{ $data['JK-PFA-2024-006']['Akumulasi Penyusutan Peralatan']->nama }}</td>
                    <td>{{ 'Rp '.number_format($akumulasiPenyusutanPeralatan) }}</td>
                    <td class="border-right"></td>
                </tr>
            {{-- end content aktiva tetap --}}
            <tr>
                <td class="sub-title">Total Aktiva Tetap</td>
                <td></td>
                <td class="text-right border-top border-right">
                    <span class="mr-10">
                        {{ 'Rp '.number_format($totalAktivaTetap) }}
                    </span>
                </td>
            </tr>
            <tr><td colspan="3" class="border-right">&nbsp;</td></tr>
            <tr>
                <td>Total Aktiva</td>
                <td></td>
                <td class="text-right border-top border-right" style="border-top: none;">
                    <span class="mr-10">
                        {{ 'Rp '.number_format($totalAktiva) }}
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="float-right">
        <tbody>
            <tr>
                <td class="sub-title">
                    <span class="ml-10">
                        Utang
                    </span>
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="sub-title">
                    <span class="ml-10">
                        Utang Lancar
                    </span>
                </td>
                <td></td>
                <td></td>
            </tr>
            {{-- content utang lancar --}}
                <tr>
                    <td>
                        <span class="ml-10">
                            {{ $data['JK-PFA-2024-008']['Utang Usaha']->nama }}
                        </span>
                    </td>
                    <td>{{ 'Rp '.number_format($utangUsaha) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <span class="ml-10">
                            {{ $data['JK-PFA-2024-009']['Utang Beban']->nama }}
                        </span>
                    </td>
                    <td>{{ 'Rp '.number_format($utangBeban) }}</td>
                    <td></td>
                </tr>
            {{-- end content utang lancar --}}
            <tr>
                <td class="sub-title">
                    <span class="ml-10">
                        Total Utang Lancar
                    </span>
                </td>
                <td></td>
                <td class="text-right border-top">{{ 'Rp '.number_format($totalUtangLancar) }}</td>
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr>
                <td class="sub-title">
                    <span class="ml-10">
                        Utang Jangka Panjang
                    </span>
                </td>
                <td></td>
                <td></td>
            </tr>
            {{-- content utang jangka panjang --}}
                <tr>
                    <td>
                        <span class="ml-10">
                            {{ $data['JK-PFA-2024-010']['Utang Jangka Panjang Lainnya']->nama }}
                        </span>
                    </td>
                    <td>{{ 'Rp '.number_format($utangJangkaPanjangLainnya) }}</td>
                    <td></td>
                </tr>
            {{-- end content utang jangka panjang --}}
            <tr>
                <td class="sub-title">
                    <span class="ml-10">
                        Total Utang Jangka Panjang
                    </span>
                </td>
                <td></td>
                <td class="text-right border-top">{{ 'Rp '.number_format($totalUtangJangkaPanjang) }}</td>
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr>
                <td class="sub-title">
                    <span class="ml-10">
                        Modal
                    </span>
                </td>
                <td></td>
                <td></td>
            </tr>
            {{-- content modal --}}
                <tr>
                    <td>
                        <span class="ml-10">
                            Modal {{ $dataUsaha['nama'] }}
                        </span>
                    </td>
                    <td></td>
                    <td class="text-right border-top">{{ 'Rp '.number_format($modalAkhir) }}</td>
                </tr>
            {{-- end content modal --}}
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr>
                <td>
                    <span class="ml-10">
                        Total Utang dan Modal
                    </span>
                </td>
                <td></td>
                <td class="text-right border-top" style="border-top: none;">{{ 'Rp '.number_format($totalUtangDanModal) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>