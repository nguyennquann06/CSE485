<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use Faker\Factory as Faker;

class It_centersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        for ($i = 0; $i < 5; $i++) {
            DB::table('it_centers')->insert([
                'name'          => 'Trung tâm Tin học ' . $faker->company,
                'location'      => $faker->address,
                'contact_email' => $faker->unique()->safeEmail,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
