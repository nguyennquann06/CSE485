<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class MedicinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $forms = ['viên nén', 'viên nang', 'siro', 'tiêm', 'bột', 'gel'];
        $faker = Faker::create();
        for ($i = 1; $i < 101; $i++){
            DB::table('medicines')->insert([
                'name' => $faker->word,
                'brand' => $faker->company,
                'dosage' => $faker->randomFloat(2, 5, 100),
                'form' => $faker->randomElement($forms),
                'price' => $faker->randomFloat(null, 2, 100),
                'stock' => $faker->numberBetween(0, 100),
                'created_at' => now(),
                'updated_at' => now(),
                ]);

        }
    }
}
