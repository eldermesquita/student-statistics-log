<?php


namespace App\ManageServices;


use App\Http\Requests\Grades\CreateRequest;
use App\Models\Grade;

class GradeService
{
    public function updateGradesFromArray(CreateRequest $request)
    {
        foreach ($request['grades'] as $grade) {
            $temp = Grade::where('task_id', $grade['task_id'])
                ->where('student_id', $grade['student_id']);

            $temp->update([
                'value' => $grade['value'],
                'status' => Grade::STATUS_TOUCHED
            ]);
        }
    }
}
