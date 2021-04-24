<?php

namespace Database\Seeders;

use App\Models\Classroom;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ClassroomSeeder::class,
            CourseSeeder::class,
            TestSeeder::class,
            UserSeeder::class,
        ]);
    }
}
