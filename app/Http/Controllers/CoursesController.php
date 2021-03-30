<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
    public function index()
    {
        //
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
     * @return Response
     */
    public function edit(Course $course): Response
    {
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
