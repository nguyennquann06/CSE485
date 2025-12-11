<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 100) as $index) {
            DB::table('classes')->insert([
                'grade_level' => $faker->randomElement(['Pre-k','Kindergarten']),
                'room_number' => $faker->randomElement(['VH7','VH8']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
