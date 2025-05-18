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
        $yayasan = [
            'Yayasan Kemanusiaan Jakarta',
            'Yayasan Peduli Sesama',
            'Yayasan Anak Bangsa',
            'Yayasan Cinta Kasih Indonesia',
            'Yayasan Sahabat Yatim',
            'Yayasan Pendidikan Nasional',
            'Yayasan Bina Sehati',
            'Yayasan Harapan Baru',
            'Yayasan Cahaya Bangsa',
            'Yayasan Lentera Hati',
            'Yayasan Dana Sosial Rakyat',
            'Yayasan Rumah Berbagi',
            'Yayasan Mitra Kemanusiaan',
            'Yayasan Bumi Sehat',
            'Yayasan Senyum Indonesia'
        ];

        foreach ($yayasan as $index => $namaYayasan) {
            $uangMasuk = rand(50000, 5000000);
            $uangKeluar = rand(0, $uangMasuk);
            $saldo = $uangMasuk - $uangKeluar;

            UangDonasi::create([
                'nama_donasi' => "$namaYayasan",
                'uang_masuk' => $uangMasuk,
                'uang_keluar' => $uangKeluar,
                'saldo' => $saldo,
                'kelola_donasi_id' => 1,
            ]);
        }
    }
}