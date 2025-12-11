<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        // Lấy danh sách id khách hàng hiện có
        $customerIds = DB::table('customers')->pluck('id')->toArray();

        if (empty($customerIds)) {
            return; // Không có customer thì thôi
        }

        for ($i = 0; $i < 100; $i++) {
            DB::table('orders')->insert([
                'customer_id' => $faker->randomElement($customerIds),
                'order_date'  => $faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
                'total_price' => $faker->numberBetween(100000, 5000000),
                'status'      => $faker->randomElement(['Pending', 'Paid', 'Cancelled']),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }    
}