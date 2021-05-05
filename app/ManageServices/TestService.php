<?php


namespace App\ManageServices;


use App\Http\Requests\Tests\CreateRequest;
use App\Http\Requests\Tests\UpdateRequest;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\Test;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class TestService
{
    public function create(CreateRequest $request): Test
    {
        $teacher = User::findOrFail($request['teacher']);
        $course = Course::findOrFail($request['course']);
        $classroom = Classroom::findOrFail($request['classroom']);

        $test = Test::make([
            'title' => $request['title'],
            'description' => $request['description'],
            'passed_at' => $request['passed_at'],
            'number_classroom_archived' => $classroom->number,
            'postfix_classroom_archived' => $classroom->postfix
        ]);

        $test->course()->associate($course);
        $test->teacher()->associate($teacher);

        $test->saveOrFail();

        return $test;
    }

    public function edit(int $id, UpdateRequest $request): void
    {
        $test = $this->getModel($id);

        $test->update($request->only(['title', 'description', 'passed_at']));
    }

    public function remove(int $id): void
    {
        $test = $this->getModel($id);
        $test->delete();
    }

    private function getModel(int $id)
    {
        return Test::findOrFail($id);
    }
}
