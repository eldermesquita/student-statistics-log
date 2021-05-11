<?php


namespace App\ManageServices;


use App\Http\Requests\Tasks\ManageRequest;
use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Task;
use App\Models\Test;
use Illuminate\Support\Facades\DB;

class TaskService
{
    public function create(Test $test, ManageRequest $request)
    {
        DB::transaction(function () use ($test, $request) {
            $classroom = Classroom::findOrFail($test->classroom_id);

            $task = Task::make([
                'number' => $request['number'],
                'postfix' => $request['postfix'],
                'min_score' => $request['min_score'],
                'max_score' => $request['max_score']
            ]);

            $task->test()->associate($test);

            $task->saveOrFail();

            $classroom->students()->each(function (Student $student) use ($task) {
                $student->grades()->create([
                    'task_id' => $task->id,
                    'value' => null,
                    'status' => Grade::STATUS_UNTOUCHED
                ]);
            });
            return $task;
        });
    }

    public function remove(Task $task)
    {
        $task->delete();
    }
}
