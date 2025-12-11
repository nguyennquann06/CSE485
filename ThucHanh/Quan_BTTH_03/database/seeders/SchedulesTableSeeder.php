<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Danh sách thứ trong tuần
        $days = ['Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu'];

        // Danh sách ca học
        $timeSlots = [
            '07:00 - 09:00',
            '09:00 - 11:00',
            '13:00 - 15:00',
            '15:00 - 17:00',
        ];

        // Lấy tất cả classroom_id từ bảng classrooms
        $classroomIds = DB::table('classrooms')->pluck('id');

        // Tạo 30 lịch học
        for ($i = 0; $i < 30; $i++) {
            DB::table('schedules')->insert([
                'classroom_id' => $faker->randomElement($classroomIds),
                'course_name'  => $faker->sentence(3),
                'day_of_week'  => $faker->randomElement($days),
                'time_slot'    => $faker->randomElement($timeSlots),
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}
