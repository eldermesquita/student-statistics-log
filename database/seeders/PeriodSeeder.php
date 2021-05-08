<?php

namespace Database\Seeders;

use App\Models\Period;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Period::factory()->create([
            'started_at' => Carbon::now(),
            'ended_at' => Carbon::now()->addYear(),
            'status' => Period::STATUS_ACTIVE
        ]);
    }
}
