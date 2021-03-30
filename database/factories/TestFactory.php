<?php

namespace Database\Factories;

use App\Models\Classroom;
use App\Models\Course;
use App\Models\Test;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TestFactory extends Factory
{
    protected $model = Test::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $classroom = Classroom::factory()->create();

        return [
            'teacher_id' => User::factory()->admin(),
            'course_id' => Course::factory(),
            'number_classroom_archived' => $classroom->number,
            'postfix_classroom_archived' => $classroom->postfix,
            'title' => $this->faker->word,
            'description' => $this->faker->text,
            'passed_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
