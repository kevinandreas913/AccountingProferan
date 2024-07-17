<?php

namespace Database\Seeders;

use App\Models\MasterJenisAkun;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisAkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 'JK-PFA-2024-001',
                'nama' => 'Kas',
            ],
            [
                'id' => 'JK-PFA-2024-002',
                'nama' => 'Piutang',
            ],
            [
                'id' => 'JK-PFA-2024-003',
                'nama' => 'Persediaan',
            ],
            [
                'id' => 'JK-PFA-2024-004',
                'nama' => 'Aktiva Lancar Lainnya',
            ],
            [
                'id' => 'JK-PFA-2024-005',
                'nama' => 'Aktiva Tetap',
            ],
            [
                'id' => 'JK-PFA-2024-006',
                'nama' => 'Akumulasi Penyusutan',
            ],
            [
                'id' => 'JK-PFA-2024-007',
                'nama' => 'Aktiva Lainnya',
            ],
            [
                'id' => 'JK-PFA-2024-008',
                'nama' => 'Akun Hutang',
            ],
            [
                'id' => 'JK-PFA-2024-009',
                'nama' => 'Hutang Lancar Lainnya',
            ],
            [
                'id' => 'JK-PFA-2024-010',
                'nama' => 'Hutang Jangka Panjang',
            ],
            [
                'id' => 'JK-PFA-2024-011',
                'nama' => 'Ekuitas',
            ],
            [
                'id' => 'JK-PFA-2024-012',
                'nama' => 'Pendapatan',
            ],
            [
                'id' => 'JK-PFA-2024-013',
                'nama' => 'Harga Pokok Penjualan',
            ],
            [
                'id' => 'JK-PFA-2024-014',
                'nama' => 'Beban',
            ],
            [
                'id' => 'JK-PFA-2024-015',
                'nama' => 'Beban Lain-lain',
            ],
            [
                'id' => 'JK-PFA-2024-016',
                'nama' => 'Pendapatan Lain-lain',
            ],
        ];

        foreach($data as $jenis) {
            MasterJenisAkun::create($jenis);
        }
    }
}
