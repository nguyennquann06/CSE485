<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class LaptopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // lấy danh sách id renter để random
        $renterIds = DB::table('renters')->pluck('id')->toArray();

        for ($i = 0; $i < 20; $i++) {
            $isRented  = $faker->boolean(60); // ~60% đang cho thuê
            $renterId  = $isRented && !empty($renterIds)
                       ? $faker->randomElement($renterIds)
                       : null;

            DB::table('laptops')->insert([
                'brand'          => $faker->randomElement(['Dell', 'HP', 'Lenovo', 'Asus', 'Acer']),
                'model'          => 'Model ' . $faker->bothify('??-###'),
                'specifications' => $faker->randomElement([
                    'Intel i5, 8GB RAM, 256GB SSD',
                    'Intel i7, 16GB RAM, 512GB SSD',
                    'Ryzen 5, 8GB RAM, 512GB SSD',
                ]),
                'rental_status'  => $isRented,
                'renter_id'      => $renterId,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }
}
