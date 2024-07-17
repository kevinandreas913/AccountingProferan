<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />

    <title>Laporan Perubahan Modal - {{ $dataUsaha['nama'] }}</title>
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
}
table {
    width: 100%;
    border-collapse: collapse;
    font-size: 20px;
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
.ml-20 {
    margin-left: 20px;
}
.border-top {
    border-top: 1px solid;
}
</style>
<body>
    <div class="header">
        <span class="namaUsaha">{{ $dataUsaha['nama'] }}</span>
        <br>
        <span class="judulLaporan">Laporan Perubahan Ekuitas</span>
        <br>
        <span>Per {{ $dataUsaha['bulan'] }} {{ $dataUsaha['tahun'] }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="width: 25%;"></td>
            </tr>
        </thead>
        <tbody>
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
            @endphp
            

            <tr>
                <td class="sub-title">Modal Awal {{ $dataUsaha['nama'] }}</td>
                <td></td>
                <td></td>
                <td class="text-right">{{ "Rp ".number_format($modalAwal) }}</td>
            </tr>
            <tr>
                <td class="sub-title">Pertambahan Modal</td>
                <td></td>
                <td></td>
                <td class="text-right">{{ "Rp ".number_format($labaRugiUsaha) }}</td>
            </tr>
            <tr>
                <td class="sub-title">Total</td>
                <td></td>
                <td></td>
                <td class="border-top text-right">{{ "Rp ".number_format($total) }}</td>
            </tr>
            <tr>
                <td class="sub-title">Prive</td>
                <td></td>
                <td></td>
                <td class="text-right">{{ "Rp ".number_format($prive) }}</td>
            </tr>
            <tr>
                <td class="sub-title">Modal Akhir</td>
                <td></td>
                <td></td>
                <td class="border-top text-right">{{ "Rp ".number_format($modalAkhir) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>