<?php

namespace App\Http\Requests\Students;

use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
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
            'start_row' => 'required|integer',
            'smart_addition' => 'required|boolean',
            'file' => 'required|file|mimes:csv,xls,xlsx'
        ];
    }
}
