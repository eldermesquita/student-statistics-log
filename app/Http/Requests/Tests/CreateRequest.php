<?php

namespace App\Http\Requests\Tests;

use App\Rules\UserSchoolWorkerRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'teacher' => [
                'required',
                'integer',
                new UserSchoolWorkerRule()
            ],
            'course' => 'integer|required',
            'classroom' => 'integer|required',
            'title' => 'string|required|max:255',
            'description' => 'string|nullable',
            'passed_at' => 'date|required',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
