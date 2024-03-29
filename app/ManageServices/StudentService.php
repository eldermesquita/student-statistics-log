<?php


namespace App\ManageServices;


use App\Http\Requests\Students\ManageRequest;
use App\Http\Requests\Students\TransferRequest;
use App\Models\Classroom;
use App\Models\Student;

class StudentService
{
    public function create(Classroom $classroom, ManageRequest $request): Student
    {
        $student = Student::make([
            'name' => $request['name']
        ]);

        $classroom->students()->save($student);

        return $student;
    }

    public function transfer(Student $student, TransferRequest $request): void
    {
        $transfer = Classroom::findOrFail($request['transfer_id']);

        $student->classroom()->associate($transfer);

        $student->update();
    }

    public function update(Student $student, ManageRequest $request): void
    {
        $student->update($request->only('name'));
    }

    public function remove(Student $student): void
    {
        $student->delete();
    }
}
