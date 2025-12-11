<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        // Chọn vài medicine_id hợp lệ từ bảng 'medicines' nếu có sẵn trong DB
        $medicineIds = DB::table('medicines')->pluck('id');

        // Kiểm tra có medicine_id trong DB
        if ($medicineIds->isEmpty()) {
            $this->command->info("No medicines found. Please seed the 'medicines' table first.");
            return;
        }
        // Tạo dữ liệu giả cho bảng 'sales'
        for ($i = 1; $i < 101; $i++) {
            DB::table('sales')->insert([
                'medicine_id' => $faker->randomElement($medicineIds),
                'quantity' => $faker->numberBetween(1, 100),
                'sale_date' => $faker->date(),
                'curtomer_phone' => $faker->numerify('0#########'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
