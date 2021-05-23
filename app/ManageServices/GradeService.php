<?php


namespace App\ManageServices;


use App\Http\Requests\Grades\CreateRequest;
use App\Models\Grade;
use Illuminate\Support\Facades\DB;

class GradeService
{
    public function updateGradesFromArray(CreateRequest $request)
    {
        DB::transaction(function () use ($request) {
            foreach ($request['grades'] as $grade) {
                $temp = Grade::where('task_id', $grade['task_id'])
                    ->where('student_id', $grade['student_id']);

                $temp->update([
                    'value' => $grade['value'],
                    'status' => Grade::STATUS_TOUCHED
                ]);
            }
        });
    }
}
