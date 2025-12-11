<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        for ($i = 0; $i < 50; $i++) {
            DB::table('customers')->insert([
                'name'       => $faker->name,
                'email'      => $faker->unique()->safeEmail,
                'phone'      => $faker->phoneNumber,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
