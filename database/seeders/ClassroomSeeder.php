<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Period;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $period = Period::active()->first();

        foreach (range(0, 11) as $classNumber) {
            foreach (range('A', 'D') as $classPostfix) {
                Classroom::factory([
                    'number' => $classNumber,
                    'postfix' => $classPostfix,
                    'period_id' => $period->id
                ])->hasStudents(10)->create();
            }
        }
    }
}
