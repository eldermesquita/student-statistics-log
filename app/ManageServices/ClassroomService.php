<?php

namespace App\ManageServices;

use App\Http\Requests\Classrooms\ManageRequest;
use App\Models\Classroom;
use App\Models\Period;

class ClassroomService
{
    public function create(Period $period, ManageRequest $request): Classroom
    {
        $classroom = Classroom::make([
            'number' => $request['number'],
            'postfix' => $request['postfix']
        ]);

        $period->classrooms()->save($classroom);

        return $classroom;
    }

    public function update(Classroom $classroom, ManageRequest $request): void
    {
        $classroom->update($request->only('number', 'postfix'));
    }

    public function remove(Classroom $classroom)
    {
        $classroom->delete();
    }
}
