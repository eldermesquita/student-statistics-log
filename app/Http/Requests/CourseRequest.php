<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:128|unique:courses'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
