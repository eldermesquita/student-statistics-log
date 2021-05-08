<?php

namespace App\Http\Requests\Tests;

use App\Rules\UserSchoolWorkerRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'teacher_id' => [
                'required',
                'integer',
                new UserSchoolWorkerRule()
            ],
            'course_id' => 'required|integer',
            'classroom_id' => 'required|integer',
            'period_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'string|nullable',
            'passed_at' => 'date|required',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
