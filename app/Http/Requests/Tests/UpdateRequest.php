<?php

namespace App\Http\Requests\Tests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
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
