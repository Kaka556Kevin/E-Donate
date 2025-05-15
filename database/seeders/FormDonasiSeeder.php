<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Numbers;
use Illuminate\Support\Carbon;

class FormDonasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        for ($i = 0; $i < 20; $i++) {
            $data[] = [
                'nama' => fake()->name(),
                'nominal' => rand(50000, 10000000),
                'kontak' => fake()->phoneNumber(),
                'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ];
        }

        DB::table('form_donasis')->insert($data);
    }
}