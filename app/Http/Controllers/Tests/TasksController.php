<?php

namespace App\Http\Controllers\Tests;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\ManageRequest;
use App\Http\Resources\Students\StudentResource;
use App\Http\Resources\Tests\TaskResource;
use App\Http\Resources\Tests\TestResource;
use App\ManageServices\TaskService;
use App\Models\Student;
use App\Models\Task;
use App\Models\Test;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TasksController extends Controller
{
    /**
     * @var TaskService
     */
    private TaskService $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    public function index(Test $test): Response
    {
        $tasks = $test->tasks()->orderBy('sort')->get();
        $taskIds = $tasks->pluck('id');

        $students = Student::whereClassroomId($test->classroom_id)->with(['grades' => function ($q) use ($taskIds) {
            return $q->whereIn('task_id', $taskIds)->join('tasks', 'task_id', '=', 'tasks.id')->orderBy('sort');
        }])->get();

        return Inertia::render('Tasks/Index', [
            'test' => new TestResource($test),
            'tasks' => TaskResource::collection($tasks),
            'students' => StudentResource::collection($students)
        ]);
    }

    public function store(Test $test, ManageRequest $request): RedirectResponse
    {
        $this->service->create($test, $request);

        return redirect()->back()->with('success', __('messages.task.create'));
    }

    public function up(Task $task): RedirectResponse
    {
        $task->moveOrderUp();

        return redirect()->back();
    }

    public function down(Task $task): RedirectResponse
    {
        $task->moveOrderDown();

        return redirect()->back();
    }

    public function destroy(Task $task): RedirectResponse
    {
        $this->service->remove($task);

        return redirect()->back();
    }
}
