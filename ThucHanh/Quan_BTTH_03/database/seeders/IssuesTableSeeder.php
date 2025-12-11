<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class IssuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 100) as $index) {
            DB::table('issues')->insert([
                'computer_id' => $faker->numberBetween(1, 100),
                'reported_by' => $faker->Name,
                'reported_date' => $faker->date(),
                'description' => $faker->text,
                'urgency' => $faker->randomElement(['LOW','HIGH','MEDIUM']),
                'status' => $faker->randomElement(['OPEN','IN PROGRESS','RESOLVED']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } 
    }
}
