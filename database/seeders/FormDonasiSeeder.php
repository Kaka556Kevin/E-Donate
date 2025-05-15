<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class FormDonasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kelola_donasi_id' => 1,
                'nama' => 'Ahmad Yasin',
                'nominal' => 500000,
                'kontak' => '081234567890',
                'pesan' => 'Semoga bermanfaat untuk yang membutuhkan.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kelola_donasi_id' => 1,
                'nama' => 'Siti Aminah',
                'nominal' => 1000000,
                'kontak' => '081987654321',
                'pesan' => 'Semangat terus untuk kegiatan sosialnya.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kelola_donasi_id' => 2,
                'nama' => 'Budi Santoso',
                'nominal' => 250000,
                'kontak' => '081345678901',
                'pesan' => 'Mohon doakan keluarga saya.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kelola_donasi_id' => 2,
                'nama' => 'Lina Marlina',
                'nominal' => 750000,
                'kontak' => '085678901234',
                'pesan' => 'Terima kasih sudah membantu.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kelola_donasi_id' => 1,
                'nama' => 'Rudi Hartono',
                'nominal' => 200000,
                'kontak' => '087654121098',
                'pesan' => 'Semoga semua amal diterima di sisi-Nya.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Tambahkan lebih banyak data dummy di sini...
            [
                'kelola_donasi_id' => 2,
                'nama' => 'Dewi Sartika',
                'nominal' => 1500000,
                'kontak' => '081111111111',
                'pesan' => 'Keep up the good work!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kelola_donasi_id' => 1,
                'nama' => 'Andi Saputra',
                'nominal' => 300000,
                'kontak' => '082222222222',
                'pesan' => 'Doakan kesembuhan ibu saya.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kelola_donasi_id' => 2,
                'nama' => 'Mira Lestari',
                'nominal' => 900000,
                'kontak' => '083333333333',
                'pesan' => 'Saya percaya dengan program kalian.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kelola_donasi_id' => 1,
                'nama' => 'Faisal Rahman',
                'nominal' => 400000,
                'kontak' => '084444444444',
                'pesan' => 'Tetap semangat dan jaga kesehatan tim.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kelola_donasi_id' => 2,
                'nama' => 'Nurul Fitri',
                'nominal' => 600000,
                'kontak' => '085555555555',
                'pesan' => 'Jazakumullah khair.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Lanjutkan sampai 20 data
        ];

        DB::table('form_donasi')->insert($data);
    }
}