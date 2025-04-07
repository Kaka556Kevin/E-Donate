<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Donation;

class DonationSeeder extends Seeder {
    public function run(): void {
        Donation::create([
            'title' => 'Donasi Banjir Bekasi',
            'description' => 'Bantu korban banjir di Bekasi.',
            'image' => 'https://source.unsplash.com/400x300/?flood,disaster',
            'min_amount' => 1000,
            'max_amount' => 100000,
            'collected' => 500000,
            'target' => 1000000,
        ]);

        Donation::create([
            'title' => 'Bantu Pendidikan Anak Yatim',
            'description' => 'Dukung pendidikan anak-anak kurang mampu.',
            'image' => 'https://source.unsplash.com/400x300/?education,school',
            'min_amount' => 5000,
            'max_amount' => 200000,
            'collected' => 120000,
            'target' => 500000,
        ]);
    }
}
