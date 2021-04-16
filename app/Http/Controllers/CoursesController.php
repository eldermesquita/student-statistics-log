<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Http\Resources\Courses\CourseCollection;
use App\Http\Resources\Courses\CourseDetailResource;
use App\Http\Resources\Courses\CourseResource;
use App\Models\Course;
use App\Models\User;
use App\Services\CourseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class CoursesController extends Controller
{
    /**
     * @var CourseService
     */
    private $service;

    public function __construct(CourseService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        $courses = Course::with(['teachers', 'tests'])->paginate(16);

        return Inertia::render('Courses/Index', [
            'courses' => new CourseCollection($courses)
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(CourseRequest $request): RedirectResponse
    {
        $this->service->create($request);
        return redirect()->route('courses.index');
    }

    /**
     * @param Course $course
     * @return \Inertia\Response
     */
    public function edit(Course $course): \Inertia\Response
    {
        return Inertia::render('Courses/Edit', [
            'course' => new CourseDetailResource($course)
        ]);
    }

    /**
     * @param CourseRequest $request
     * @param Course $course
     * @return RedirectResponse
     */
    public function update(CourseRequest $request, Course $course): RedirectResponse
    {
        $this->service->edit($course->id, $request);
        return redirect()->route('courses.index');
    }

    /**
     * @param Course $course
     * @return RedirectResponse
     */
    public function destroy(Course $course): RedirectResponse
    {
        $this->service->remove($course->id);
        return redirect()->route('courses.index');
    }
}
