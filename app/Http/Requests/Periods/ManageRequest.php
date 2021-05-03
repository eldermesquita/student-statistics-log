<?php

namespace App\Http\Requests\Periods;

use App\Rules\Periods\StatusExistRule;
use Illuminate\Foundation\Http\FormRequest;

class ManageRequest extends FormRequest
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
            'started_at' => 'required|date',
            'ended_at' => 'required|date|after:started_at',
        ];
    }
}
