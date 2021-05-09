<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tests\CreateRequest;
use App\Http\Requests\Tests\UpdateRequest;
use App\Http\Resources\Classrooms\ClassroomResource;
use App\Http\Resources\Courses\CourseResource;
use App\Http\Resources\Periods\PeriodResource;
use App\Http\Resources\Tests\TestResource;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\Period;
use App\Models\Test;
use App\ManageServices\TestService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TestsController extends Controller
{
    /**
     * @var TestService
     */
    private $service;

    public function __construct(TestService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        $period = Period::active()->first();

        $tests = QueryBuilder::for(Test::class)->where('tests.period_id', '=', $period->id)->with(['classroom', 'teacher', 'course'])
            ->allowedFilters([
                AllowedFilter::exact('classroomNumber', 'classroom.number'),
                AllowedFilter::exact('classroomPostfix', 'classroom.postfix'),
                AllowedFilter::exact('course_id'),
                AllowedFilter::exact('teacher_id')
            ])->paginate(10);

        return Inertia::render('Tests/Index', [
            'params' => Request::all([
                'filter.classroomNumber',
                'filter.classroomPostfix',
                'filter.course_id',
                'filter.teacher_id',
            ]),
            'tests' => TestResource::collection($tests),
            'courses' => CourseResource::collection(Course::all()),
        ]);
    }

    public function create()
    {
        $period = Period::active()->first();

        return Inertia::render('Tests/Create', [
            'period' => new PeriodResource($period),
            'courses' => CourseResource::collection(Course::all()),
            'classrooms' => ClassroomResource::collection(
                Classroom::wherePeriodId($period->id)->orderByDesc('number')->get()->all()
            )
        ]);
    }

    /**
     * @param CreateRequest $request
     * @return RedirectResponse
     */
    public function store(CreateRequest $request): RedirectResponse
    {
        $this->service->create($request);
        return redirect()->route('tests.index')->with('success', __('messages.test.created'));
    }

    /**
     * @param Test $test
     * @return \Inertia\Response
     */
    public function show(Test $test)
    {
        return Inertia::render('Tests/Show', [
            'test' => $test
        ]);
    }

    public function edit(Test $test)
    {
        return Inertia::render('Tests/Edit', [
            'courses' => CourseResource::collection(Course::all()),
            'classrooms' => ClassroomResource::collection(
                Classroom::wherePeriodId($test->period_id)->orderByDesc('number')->get()->all()
            ),
            'test' => new TestResource($test)
        ]);
    }

    /**
     * @param UpdateRequest $request
     * @param Test $test
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Test $test): RedirectResponse
    {
        $this->service->edit($test, $request);
        return redirect()->route('tests.index')->with('success', __('messages.test.updated'));
    }

    /**
     * @param Test $test
     * @return RedirectResponse
     */
    public function destroy(Test $test): RedirectResponse
    {
        $this->service->remove($test);
        return redirect()->back()->with('success', __('messages.test.removed'));
    }
}
