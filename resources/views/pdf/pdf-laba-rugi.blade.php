<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />

    <title>Laporan Laba Rugi - {{ $dataUsaha['nama'] }}</title>
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
    width: 100%;
    border-collapse: collapse;
    font-size: 16px;
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
        <span class="judulLaporan">Laporan Laba Rugi</span>
        <br>
        <span>Per {{ $dataUsaha['bulan'] }} {{ $dataUsaha['tahun'] }}</span>
    </div>

    <table>
        <tbody>
            {{-- Pendapatan --}}
            <tr>
                <td class="sub-title">Pendapatan</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-012']['Penjualan']->nama }}
                        </span>
                    </td>
                    <td></td>
                    <td></td>
                    <td class="text-left">{{ "Rp " . number_format($data['JK-PFA-2024-012']['Penjualan']->nominal) }}</td>
                </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-012']['Potongan Penjualan']->nama }}
                        </span>
                    </td>
                    <td></td>
                    <td class="text-left">{{ "Rp " . number_format($data['JK-PFA-2024-012']['Potongan Penjualan']->nominal) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-012']['Retur Penjualan']->nama }}
                        </span>
                    </td>
                    <td></td>
                    <td class="text-left">{{ "Rp " . number_format($data['JK-PFA-2024-012']['Retur Penjualan']->nominal) }}</td>
                    <td></td>
                </tr>
            <tr>
                <td class="sub-title">Penjualan Bersih</td>
                <td></td>
                <td></td>
                @php
                    $penjualanBersih = $data['JK-PFA-2024-012']['Penjualan']->nominal - $data['JK-PFA-2024-012']['Potongan Penjualan']->nominal - $data['JK-PFA-2024-012']['Retur Penjualan']->nominal;
                @endphp
                <td class="border-top text-right">{{ "Rp ".number_format($penjualanBersih) }}</td>
            </tr>
            <br>


            {{-- Harga Pokok Penjualan --}}
            <tr>
                <td class="sub-title">Harga Pokok Penjualan</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-013']['Pembelian Barang Dagang']->nama }}
                        </span>
                    </td>
                    <td></td>
                    <td class="text-left">{{ "Rp " . number_format($data['JK-PFA-2024-013']['Pembelian Barang Dagang']->nominal) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-013']['Beban Angkut Pembelian']->nama }}
                        </span>
                    </td>
                    <td></td>
                    <td class="text-left">{{ "Rp " . number_format($data['JK-PFA-2024-013']['Beban Angkut Pembelian']->nominal) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-013']['Retur Pembelian']->nama }}
                        </span>
                    </td>
                    <td class="text-left">{{ "Rp " . number_format($data['JK-PFA-2024-013']['Retur Pembelian']->nominal) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-013']['Potongan Pembelian']->nama }}
                        </span>
                    </td>
                    <td class="text-left">{{ "Rp " . number_format($data['JK-PFA-2024-013']['Potongan Pembelian']->nominal) }}</td>
                    <td></td>
                    <td></td>
                </tr>
            <tr>
                <td class="sub-title">Pembelian Bersih</td>
                <td></td>
                <td></td>
                @php
                    $pembelianBersih = $data['JK-PFA-2024-013']['Pembelian Barang Dagang']->nominal + $data['JK-PFA-2024-013']['Beban Angkut Pembelian']->nominal - $data['JK-PFA-2024-013']['Retur Pembelian']->nominal - $data['JK-PFA-2024-013']['Potongan Pembelian']->nominal;
                @endphp
                <td class="text-right">{{ "Rp ".number_format($pembelianBersih) }}</td>
            </tr>
            <tr>
                <td class="sub-title">Persediaan Akhir Barang</td>
                <td></td>
                <td></td>
                @php
                    $persediaanAkhirBarang = $data['JK-PFA-2024-013']['Harga Pokok Penjualan']->nominal;
                @endphp
                <td class="border-top text-right">{{ "Rp ".number_format($persediaanAkhirBarang) }}</td>
            </tr>
            <tr>
                <td class="sub-title">Harga Pokok Penjualan</td>
                <td></td>
                <td></td>
                @php
                    $hargaPokokPenjualan = $pembelianBersih - $persediaanAkhirBarang;
                @endphp
                <td class="text-right">{{ "Rp ".number_format($hargaPokokPenjualan) }}</td>
            </tr>
            <tr>
                <td class="sub-title">Laba Kotor</td>
                <td></td>
                <td></td>
                @php
                    $labaKotor = $penjualanBersih - $hargaPokokPenjualan;
                @endphp
                <td class="border-top text-right">{{ "Rp ".number_format($labaKotor) }}</td>
            </tr>
            <br>


            {{-- Pendapatan Lain-lain --}}
            <tr>
                <td class="sub-title">Pendapatan Lain-lain</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-016']['Pendapatan Bunga']->nama }}
                        </span>
                    </td>
                    <td class="text-left">{{ "Rp " . number_format($data['JK-PFA-2024-016']['Pendapatan Bunga']->nominal) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-016']['Pendapatan Usaha Lain']->nama }}
                        </span>
                    </td>
                    <td class="text-left">{{ "Rp " . number_format($data['JK-PFA-2024-016']['Pendapatan Usaha Lain']->nominal) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-016']['Pendapatan Lain-lain']->nama }}
                        </span>
                    </td>
                    <td class="text-left">{{ "Rp " . number_format($data['JK-PFA-2024-016']['Pendapatan Lain-lain']->nominal) }}</td>
                    <td></td>
                    <td></td>
                </tr>
            <tr>
                <td class="sub-title">Total Pendapatan Lain-lain</td>
                @php
                    $totalPendapatanLainLain = $data['JK-PFA-2024-016']['Pendapatan Bunga']->nominal + $data['JK-PFA-2024-016']['Pendapatan Usaha Lain']->nominal + $data['JK-PFA-2024-016']['Pendapatan Lain-lain']->nominal;
                @endphp
                <td></td>
                <td class="border-top text-right">{{ "Rp ".number_format($totalPendapatanLainLain) }}</td>
                <td></td>
            </tr>
            <br>

            {{-- Beban Operasional --}}
            <tr>
                <td class="sub-title">Beban Operasional</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-014']['Beban Telepon dan Listrik']->nama }}
                        </span>
                    </td>
                    @php
                        $bebanTeleponDanListrik = $data['JK-PFA-2024-014']['Beban Telepon dan Listrik']->nominal;
                    @endphp
                    <td class="text-left">{{ "Rp " . number_format($bebanTeleponDanListrik) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-014']['Beban Air']->nama }}
                        </span>
                    </td>
                    @php
                        $bebanAir = $data['JK-PFA-2024-014']['Beban Air']->nominal;
                    @endphp
                    <td class="text-left">{{ "Rp " . number_format($bebanAir) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-014']['Beban Perlengkapan Toko']->nama }}
                        </span>
                    </td>
                    @php
                        $bebanPerlengkapanToko = $data['JK-PFA-2024-014']['Beban Perlengkapan Toko']->nominal;
                    @endphp
                    <td class="text-left">{{ "Rp " . number_format($bebanPerlengkapanToko) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-014']['Beban Peralatan Toko']->nama }}
                        </span>
                    </td>
                    @php
                        $bebanPeralatanToko = $data['JK-PFA-2024-014']['Beban Peralatan Toko']->nominal;
                    @endphp
                    <td class="text-left">{{ "Rp " . number_format($bebanPeralatanToko) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-014']['Beban Penyusutan Bangunan']->nama }}
                        </span>
                    </td>
                    @php
                        $bebanPenyusutanBangunan = $data['JK-PFA-2024-014']['Beban Penyusutan Bangunan']->nominal;
                    @endphp
                    <td class="text-left">{{ "Rp " . number_format($bebanPenyusutanBangunan) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-014']['Beban Penyusutan Peralatan']->nama }}
                        </span>
                    </td>
                    @php
                        $bebanPenyusutanPeralatan = $data['JK-PFA-2024-014']['Beban Penyusutan Peralatan']->nominal;
                    @endphp
                    <td class="text-left">{{ "Rp " . number_format($bebanPenyusutanPeralatan) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-014']['Beban Gaji Karyawan']->nama }}
                        </span>
                    </td>
                    @php
                        $bebanGajiKaryawan = $data['JK-PFA-2024-014']['Beban Gaji Karyawan']->nominal;
                    @endphp
                    <td class="text-left">{{ "Rp " . number_format($bebanGajiKaryawan) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-014']['Beban Iklan']->nama }}
                        </span>
                    </td>
                    @php
                        $bebanIklan = $data['JK-PFA-2024-014']['Beban Iklan']->nominal;
                    @endphp
                    <td class="text-left">{{ "Rp " . number_format($bebanIklan) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-014']['Beban Administrasi Bank']->nama }}
                        </span>
                    </td>
                    @php
                        $bebanAdministrasiBank = $data['JK-PFA-2024-014']['Beban Administrasi Bank']->nominal;
                    @endphp
                    <td class="text-left">{{ "Rp " . number_format($bebanAdministrasiBank) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-014']['Beban Operasi Lainnya']->nama }}
                        </span>
                    </td>
                    @php
                        $bebanOperasiLainnya = $data['JK-PFA-2024-014']['Beban Operasi Lainnya']->nominal;
                    @endphp
                    <td class="text-left">{{ "Rp " . number_format($bebanOperasiLainnya) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-014']['Beban Angkut Penjualan']->nama }}
                        </span>
                    </td>
                    @php
                        $bebanAngkutPenjualan = $data['JK-PFA-2024-014']['Beban Angkut Penjualan']->nominal;
                    @endphp
                    <td class="text-left">{{ "Rp " . number_format($bebanAngkutPenjualan) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <span class="ml-20">
                            {{ $data['JK-PFA-2024-015']['Beban Lain-lain']->nama }}
                        </span>
                    </td>
                    @php
                        $bebanLainLain = $data['JK-PFA-2024-015']['Beban Lain-lain']->nominal;
                    @endphp
                    <td class="text-left">{{ "Rp " . number_format($bebanLainLain) }}</td>
                    <td></td>
                    <td></td>
                </tr>
            <tr>
                <td class="sub-title">Total Beban Operasional</td>
                @php
                    $totalBebanOperasional = $bebanTeleponDanListrik + $bebanAir + $bebanPerlengkapanToko + $bebanPeralatanToko + $bebanPenyusutanBangunan + $bebanPenyusutanPeralatan + $bebanGajiKaryawan + $bebanIklan + $bebanAdministrasiBank + $bebanOperasiLainnya + $bebanAngkutPenjualan + $bebanLainLain;
                @endphp
                <td></td>
                <td class="border-top text-right">{{ "Rp ".number_format($totalBebanOperasional) }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="sub-title">Total Pendapatan Lain dan Beban</td>
                @php
                    $totalPendapatanLainDanBeban = $totalPendapatanLainLain - $totalBebanOperasional;
                @endphp
                <td></td>
                <td></td>
                <td class="border-top text-right">{{ "Rp ".number_format($totalPendapatanLainDanBeban) }}</td>
            </tr>
            <br>


            {{-- Keterangan Akhir --}}
            <tr>
                @php
                    $labaRugiUsaha = $labaKotor + $totalPendapatanLainDanBeban;
                    $keteranganAkhir = ($labaRugiUsaha >= 0) ? "Laba Usaha" : "Rugi Usaha";
                @endphp
                <td class="sub-title">{{ $keteranganAkhir }}</td>
                <td></td>
                <td></td>
                <td class="border-top text-right">{{ "Rp ".number_format($labaRugiUsaha) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>