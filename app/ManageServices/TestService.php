<?php


namespace App\ManageServices;


use App\Http\Requests\Tests\CreateRequest;
use App\Http\Requests\Tests\UpdateRequest;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\Period;
use App\Models\Test;
use App\Models\User;

class TestService
{
    public function create(CreateRequest $request): Test
    {
        $teacher = User::findOrFail($request['teacher_id']);
        $course = Course::findOrFail($request['course_id']);
        $classroom = Classroom::findOrFail($request['classroom_id']);
        $period = Period::findOrFail($request['period_id']);

        $test = Test::make([
            'title' => $request['title'],
            'description' => $request['description'],
            'passed_at' => $request['passed_at'],
        ]);

        $test->course()->associate($course);
        $test->teacher()->associate($teacher);
        $test->classroom()->associate($classroom);
        $test->period()->associate($period);

        $test->saveOrFail();

        return $test;
    }

    public function edit(Test $test, UpdateRequest $request): void
    {
        $teacher = User::findOrFail($request['teacher_id']);
        $course = Course::findOrFail($request['course_id']);
        $classroom = Classroom::findOrFail($request['classroom_id']);

        $test->course()->associate($course);
        $test->teacher()->associate($teacher);
        $test->classroom()->associate($classroom);

        $test->update($request->only('title', 'description', 'passed_at'));
    }

    public function remove(Test $test): void
    {
        $test->delete();
    }
}
