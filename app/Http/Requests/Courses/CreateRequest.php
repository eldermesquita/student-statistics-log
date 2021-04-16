<?php

namespace App\Http\Requests\Courses;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:128|unique:courses,title',
            'teachers' => 'array'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
