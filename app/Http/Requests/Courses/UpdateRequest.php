<?php

namespace App\Http\Requests\Courses;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:128|unique:courses,title,' . $this->course->id,
            'teachers' => 'array'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
