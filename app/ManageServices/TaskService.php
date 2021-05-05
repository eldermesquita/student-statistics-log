<?php


namespace App\ManageServices;


use App\Http\Requests\TaskRequest;
use App\Models\Course;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class TaskService
{
    public function createFromArray(int $test, TaskRequest $request): bool
    {
        $test = Course::findOrFail($test);

        $tasks = [];
        foreach ($request['tasks'] as $task) {
            array_push($tasks, [
                'test_id' => $test->id,
                'number' => $task['number'],
                'postfix' => $task['postfix'],
                'sort' => $task['sort'],
                'min_score' => $task['min_score'],
                'max_score' => $task['max_score']
            ]);
        }

        return Task::insert($tasks);
    }
}
