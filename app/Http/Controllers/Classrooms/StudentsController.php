<?php

namespace App\Http\Controllers\Classrooms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Students\ManageRequest;
use App\Http\Resources\Students\StudentCollection;
use App\Models\Classroom;
use App\Models\Student;
use App\Services\StudentService;
use Inertia\Inertia;

class StudentsController extends Controller
{
    /**
     * @var StudentService
     */
    private $service;

    public function __construct(StudentService $service)
    {
        $this->service = $service;
    }

    public function index(Classroom $classroom)
    {
        $students = $classroom->students()->orderBy('name')->paginate(30);

        return Inertia::render('Classrooms/Students/Index', [
            'classroom' => $classroom,
            'students' => new StudentCollection($students)
        ]);
    }

    public function store(Classroom $classroom, ManageRequest $request)
    {
        $this->service->create($classroom, $request);
        return redirect()->back()->with('success', __('messages.student.create'));
    }

    public function update(Student $student, ManageRequest $request)
    {
        $this->service->update($student, $request);
        return redirect()->back()->with('success', __('messages.student.update'));
    }

    public function destroy(Student $student)
    {
        $this->service->remove($student);
        return redirect()->back()->with('success', __('messages.student.delete'));
    }
}
