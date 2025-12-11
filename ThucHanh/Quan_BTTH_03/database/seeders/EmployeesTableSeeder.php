<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use Faker\Factory as Faker;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        // Lấy danh sách id dự án đã có
        $projectIds = DB::table('projects')->pluck('id')->toArray();

        // Nếu chưa có project nào thì dừng
        if (empty($projectIds)) {
            return;
        }

        $data = [];

        for ($i = 0; $i < 20; $i++) {
            $data[] = [
                'name'       => $faker->name,
                'position'   => $faker->randomElement([
                    'Quản lý dự án',
                    'Lập trình viên',
                    'Tester',
                    'Phân tích nghiệp vụ'
                ]),
                'project_id' => $faker->randomElement($projectIds),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('employees')->insert($data);
    }
}
