<?php

namespace App\Http\Requests\Inscribed;

use Illuminate\Foundation\Http\FormRequest;

class ValidateBulkFile extends FormRequest
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
            'file' => 'file|mimes:xls,xlsx|max:5000'
        ];
    }
}
