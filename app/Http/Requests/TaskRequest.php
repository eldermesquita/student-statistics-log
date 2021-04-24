<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function rules()
    {
        return [
            "tasks" => 'required|array',
            'tasks.*.number' => 'required|integer',
            'tasks.*.postfix' => 'string',
            'tasks.*.sort' => 'required|integer',
            'tasks.*.min_score' => 'required|integer',
            'tasks.*.max_score' => 'required|integer'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
