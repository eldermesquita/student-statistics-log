<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Period;
use App\Models\Test;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $period = Period::active()->first();

        Test::factory([
            'period_id' => $period->id,
            'classroom_id' => $period->classrooms()->inRandomOrder()->first()
        ])->count(10)->create();
    }
}
