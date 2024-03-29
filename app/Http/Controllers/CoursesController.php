<?php

namespace App\Http\Controllers;

use App\Http\Requests\Courses\CreateRequest;
use App\Http\Requests\Courses\UpdateRequest;
use App\Http\Resources\Courses\CourseDetailResource;
use App\Http\Resources\Courses\CourseResource;
use App\Models\Course;
use App\ManageServices\CourseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

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
     * @return Response
     */
    public function index(): Response
    {
        $courses = Course::with(['teachers', 'tests'])->paginate(16);

        return Inertia::render('Courses/Index', [
            'can' => [
                'manageCourses' => Auth::user()->can('manage-courses')
            ],
            'courses' => CourseResource::collection($courses)
        ]);
    }

    public function teachers(Course $course): array
    {
        return $course->teachers()->get()->all();
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Courses/Create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(CreateRequest $request): RedirectResponse
    {
        $this->service->create($request);
        return redirect()->route('courses.index')->with('success', __('messages.course.create'));
    }

    /**
     * @param Course $course
     * @return Response
     */
    public function edit(Course $course): Response
    {
        return Inertia::render('Courses/Edit', [
            'course' => new CourseDetailResource($course)
        ]);
    }

    /**
     * @param UpdateRequest $request
     * @param Course $course
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Course $course): RedirectResponse
    {
        $this->service->edit($course->id, $request);
        return redirect()->back()->with('success', __('messages.course.update'));
    }

    /**
     * @param Course $course
     * @return RedirectResponse
     */
    public function destroy(Course $course): RedirectResponse
    {
        $this->service->remove($course->id);
        return redirect()->back()->with('success', __('messages.course.delete'));
    }
}
