<?php

namespace App\Http\Controllers\Tests;

use App\Http\Controllers\Controller;
use App\Http\Resources\Students\StudentResource;
use App\Http\Resources\Tests\TaskResource;
use App\Models\Student;
use App\Models\Task;
use App\Models\Test;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TasksController extends Controller
{
    public function index(Test $test)
    {
        $tasks = $test->tasks;
        $taskIds = $tasks->pluck('id');

        $students = Student::whereClassroomId($test->classroom_id)->with(['grades' => function ($q) use ($taskIds) {
            $q->whereIn('task_id', $taskIds);
        }])->get();

        return Inertia::render('Tasks/Index', [
            'tasks' => TaskResource::collection($test->tasks),
            'students' => StudentResource::collection($students)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Task $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Task $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
