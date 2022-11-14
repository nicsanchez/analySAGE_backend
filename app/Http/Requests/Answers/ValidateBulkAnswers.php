<?php

namespace App\Http\Requests\Answers;

use Illuminate\Foundation\Http\FormRequest;

class ValidateBulkAnswers extends FormRequest
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

    public function rules()
    {
        return [
            'file' => 'file|mimes:xls,xlsx|max:3000'
        ];
    }
}
