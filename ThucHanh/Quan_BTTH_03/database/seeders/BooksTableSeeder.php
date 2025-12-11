<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Lấy danh sách id thư viện để gán library_id
        $libraryIds = DB::table('libraries')->pluck('id')->toArray();

        if (empty($libraryIds)) {
            // Nếu chưa có thư viện thì không seed được sách
            return;
        }

        for ($i = 0; $i < 20; $i++) {
            DB::table('books')->insert([
                'title'            => $faker->sentence(3), // ví dụ: "Clean Code nâng cao"
                'author'           => $faker->name,
                'publication_year' => $faker->numberBetween(1980, 2024),
                'genre'            => $faker->randomElement([
                    'Programming', 'Networking', 'Database', 'AI', 'Math', 'Novel'
                ]),
                'library_id'       => $faker->randomElement($libraryIds),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
    }
}
