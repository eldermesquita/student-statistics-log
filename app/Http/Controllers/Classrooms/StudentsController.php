<?php

namespace App\Http\Controllers\Classrooms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Students\ImportRequest;
use App\Http\Requests\Students\ManageRequest;
use App\Http\Requests\Students\TransferRequest;
use App\Http\Resources\Students\StudentCollection;
use App\Imports\ClassroomStudentsImport;
use App\Models\Classroom;
use App\Models\Student;
use App\ManageServices\StudentService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Maatwebsite\Excel\Facades\Excel;

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

    public function import()
    {
        return Inertia::render('Classrooms/Import');
    }

    public function storeImport(ImportRequest $request): RedirectResponse
    {
        Excel::import(
            new ClassroomStudentsImport($request['start_row'], (bool) $request['smart_addition']),
            $request->file('file')
        );

        return redirect()->route('classrooms.index')->with('success', __('messages.student.import'));
    }

    public function index(Classroom $classroom): Response
    {
        $students = $classroom->students()->orderBy('name')->paginate(30);
        $classrooms = Classroom::wherePeriodId($classroom->period_id)->get()->all();

        return Inertia::render('Classrooms/Students/Index', [
            'classroom' => $classroom,
            'classrooms' => $classrooms,
            'students' => new StudentCollection($students)
        ]);
    }

    public function store(Classroom $classroom, ManageRequest $request): RedirectResponse
    {
        $this->service->create($classroom, $request);
        return redirect()->back()->with('success', __('messages.student.create'));
    }

    public function update(Student $student, ManageRequest $request): RedirectResponse
    {
        $this->service->update($student, $request);
        return redirect()->back()->with('success', __('messages.student.update'));
    }

    public function destroy(Student $student): RedirectResponse
    {
        $this->service->remove($student);
        return redirect()->back()->with('success', __('messages.student.delete'));
    }

    public function transfer(Student $student, TransferRequest $request): RedirectResponse
    {
        $this->service->transfer($student, $request);
        return redirect()->back()->with('success', __('messages.student.transfer'));
    }
}
