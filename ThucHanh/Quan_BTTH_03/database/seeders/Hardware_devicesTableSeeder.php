<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use Faker\Factory as Faker;

class Hardware_devicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Lấy danh sách id center để random
        $centerIds = DB::table('it_centers')->pluck('id')->toArray();

        $types = ['Mouse', 'Keyboard', 'Headset'];

        for ($i = 0; $i < 30; $i++) {
            $isActive = $faker->boolean(80); // ~80% đang hoạt động

            DB::table('hardware_devices')->insert([
                'device_name' => $faker->randomElement([
                    'Logitech G502',
                    'Razer DeathAdder',
                    'Corsair K70',
                    'Logitech G213',
                    'HyperX Cloud II',
                    'SteelSeries Arctis 5',
                ]),
                'type'        => $faker->randomElement($types),
                'status'      => $isActive,
                'center_id'   => $faker->randomElement($centerIds),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
