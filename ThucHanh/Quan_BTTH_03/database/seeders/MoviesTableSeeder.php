<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class MoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        // Lấy danh sách id rạp chiếu
        $cinemaIds = DB::table('cinemas')->pluck('id')->toArray();

        for ($i = 0; $i < 15; $i++) {
            DB::table('movies')->insert([
                'title'        => $faker->randomElement([
                    'Avengers: Endgame', 'Avatar 2', 'Fast & Furious 9',
                    'Spider-Man: No Way Home', 'The Batman'
                ]),
                'director'     => $faker->name,
                'release_date' => $faker->date(),
                'duration'     => $faker->numberBetween(90, 200),
                'cinema_id'    => $faker->randomElement($cinemaIds),
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}
