<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class LibrariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        for ($i = 0; $i < 5; $i++) {
            DB::table('libraries')->insert([
                'name'           => 'Thư viện ' . $faker->company,
                'address'        => $faker->address,
                'contact_number' => $faker->phoneNumber,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }
}
