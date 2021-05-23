<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Classrooms\ManageRequest;
use App\Http\Resources\Classrooms\ClassroomResource;
use App\ManageServices\ClassroomService;
use App\Models\Classroom;
use App\Models\Period;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ClassroomsController extends Controller
{
    /**
     * @var ClassroomService
     */
    private $service;

    public function __construct(ClassroomService $service)
    {
        $this->service = $service;
    }

    public function index(): RedirectResponse|Response
    {
        $period = Period::active()->first();

        if (!$period) {
            return redirect()->back()->with('error', __('messages.classroom.one_active_period'));
        }

        $classrooms = $period->classrooms()->orderByDesc('number')->paginate(10);

        return Inertia::render('Classrooms/Index', [
            'classrooms' => ClassroomResource::collection($classrooms),
            'period' => $period
        ]);
    }

    public function store(Period $period, ManageRequest $request): RedirectResponse
    {
        $this->service->create($period, $request);
        return redirect()->back()->with('success', __('messages.classroom.create'));
    }

    public function update(Classroom $classroom, ManageRequest $request): RedirectResponse
    {
        $this->service->update($classroom, $request);
        return redirect()->back()->with('success', __('messages.classroom.update'));
    }

    public function destroy(Classroom $classroom): RedirectResponse
    {
        $this->service->remove($classroom);
        return redirect()->back()->with('success', __('messages.classroom.delete'));
    }
}
