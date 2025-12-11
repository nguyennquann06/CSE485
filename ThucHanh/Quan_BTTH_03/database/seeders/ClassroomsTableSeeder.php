<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ClassroomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Tạo 10 phòng học
        for ($i = 0; $i < 10; $i++) {
            DB::table('classrooms')->insert([
                'room_number' => strtoupper($faker->randomLetter) . $faker->numberBetween(100, 499),
                'capacity'    => $faker->numberBetween(30, 100),
                'building'    => 'Tòa nhà ' . strtoupper($faker->randomLetter),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
