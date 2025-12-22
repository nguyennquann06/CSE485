<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ComputersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 100) as $index) {
            DB::table('computers')->insert([
                'computer_name' => $faker->randomElement(['Lab1','Lab2','Lab3']),
                'model' => $faker->randomElement(['Dell','MSI','ASUS']),
                'operating_system' => $faker->randomElement(['WIN','ANDO','LINUX']),
                'processor' => $faker->randomElement(['e.g','rtx','core i5']),
                'memory' => $faker->numberBetween(0, 100),
                'available' => $faker->randomElement(['ON','OFF']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
