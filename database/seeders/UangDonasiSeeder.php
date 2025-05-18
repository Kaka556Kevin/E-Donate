<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UangDonasi;

class UangDonasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perusahaan = [
            'Astra International',
            'Bank Mandiri',
            'Pertamina',
            'Telkom Indonesia',
            'Unilever Indonesia',
            'Sinar Mas',
            'Indofood Sukses Makmur',
            'Wahana Mitra Perkasa',
            'Jasindo',
            'Djarum Foundation',
            'Sampoerna Foundation',
            'Salim Group',
            'Panin Bank',
            'XL Axiata',
            'Lippo Group'
        ];

        foreach ($perusahaan as $index => $pt) {
            $uangMasuk = rand(50000, 5000000);
            $uangKeluar = rand(0, $uangMasuk);
            $saldo = $uangMasuk - $uangKeluar;

            UangDonasi::create([
                'nama_donasi' => "PT. $pt",
                'uang_masuk' => $uangMasuk,
                'uang_keluar' => $uangKeluar,
                'saldo' => $saldo,
                'kelola_donasi_id' => 1,
            ]);
        }
    }
}