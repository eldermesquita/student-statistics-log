<?php

namespace App\Http\Requests\Grades;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'grades' => 'required|array',
            'grades.*.task_id' => 'integer',
            'grades.*.student_id' => 'integer',
            'grades.*.value' => 'nullable|integer'
        ];
    }
}
