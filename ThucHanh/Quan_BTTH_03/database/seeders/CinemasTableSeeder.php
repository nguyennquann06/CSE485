<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CinemasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        for ($i = 0; $i < 5; $i++) {
            DB::table('cinemas')->insert([
                'name'        => 'Rạp ' . $faker->company,
                'location'    => $faker->address,
                'total_seats' => $faker->numberBetween(100, 500),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
