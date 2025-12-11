<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use Faker\Factory as Faker;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        $data = [];

        for ($i = 0; $i < 5; $i++) {
            $start = $faker->dateTimeBetween('-2 months', 'now');
            $end   = (clone $start)->modify('+' . rand(1, 6) . ' weeks');

            $data[] = [
                'name'       => 'Dự án ' . $faker->company,
                'start_date' => $start->format('Y-m-d'),
                'end_date'   => $end->format('Y-m-d'),
                'budget'     => $faker->numberBetween(10000000, 200000000),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('projects')->insert($data);
    }
}
