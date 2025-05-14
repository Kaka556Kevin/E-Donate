<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UangDonasi;

class UangDonasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_donasi' => 'Donasi Pendidikan Anak',
                'uang_masuk' => 1000000,
                'uang_keluar' => 250000,
            ],
            [
                'nama_donasi' => 'Donasi Kesehatan Masyarakat',
                'uang_masuk' => 1500000,
                'uang_keluar' => 500000,
            ],
            [
                'nama_donasi' => 'Donasi Bencana Alam',
                'uang_masuk' => 2000000,
                'uang_keluar' => 600000,
            ],
            [
                'nama_donasi' => 'Donasi Sosial Yatim Piatu',
                'uang_masuk' => 1200000,
                'uang_keluar' => 300000,
            ],
            [
                'nama_donasi' => 'Donasi Rumah Ibadah',
                'uang_masuk' => 1800000,
                'uang_keluar' => 400000,
            ],
            [
                'nama_donasi' => 'Donasi Air Bersih',
                'uang_masuk' => 1300000,
                'uang_keluar' => 450000,
            ],
            [
                'nama_donasi' => 'Donasi Lingkungan Hijau',
                'uang_masuk' => 1100000,
                'uang_keluar' => 200000,
            ],
            [
                'nama_donasi' => 'Donasi Operasi Medis',
                'uang_masuk' => 2500000,
                'uang_keluar' => 750000,
            ],
            [
                'nama_donasi' => 'Donasi Pendidikan Luar Negeri',
                'uang_masuk' => 3000000,
                'uang_keluar' => 1000000,
            ],
            [
                'nama_donasi' => 'Donasi Panti Jompo',
                'uang_masuk' => 1400000,
                'uang_keluar' => 350000,
            ],
        ];

        foreach ($data as $donasi) {
            UangDonasi::create($donasi);
        }
    }
}
