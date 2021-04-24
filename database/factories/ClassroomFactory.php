<?php

namespace Database\Factories;

use App\Models\Classroom;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ClassroomFactory extends Factory
{
    protected $model = Classroom::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->numberBetween(1, 10),
            'postfix' => Str::random(1),
            'status' => Classroom::STATUS_ACTIVE,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
