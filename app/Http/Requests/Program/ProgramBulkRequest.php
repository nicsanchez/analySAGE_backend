<?php

namespace App\Http\Requests\Program;

use Illuminate\Foundation\Http\FormRequest;

class ProgramBulkRequest extends FormRequest
{
    public $codeValidation = 'required|integer';
    public $nameValidation = 'required|string';

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
            'programCode' => $this->codeValidation,
            'programName' => $this->nameValidation,
            'headquarterName' => $this->nameValidation,
            'facultyCode' => $this->codeValidation,
            'facultyName' => $this->nameValidation
        ];
    }

    public function messages()
    {
        return [
            'programCode.required' => 'El código del programa debe ser requerido.',
            'programCode.integer' => 'El código del programa debe ser numérico.',
            'programName.required' => 'El nombre del programa debe ser requerido.',
            'programName.string' => 'El nombre del programa debe ser de tipo texto.',
            'headquarterName.required' => 'El nombre de la sede debe ser requerido.',
            'headquarterName.string' => 'El nombre de la sede debe ser de tipo texto.',
            'facultyCode.required' => 'El código de la facultad debe ser requerido.',
            'facultyCode.integer' => 'El código de la facultad debe ser numérico.',
            'facultyName.required' => 'El nombre de la facultad debe ser requerido.',
            'facultyName.string' => 'El nombre de la facultad debe ser de tipo texto.'
        ];
    }
}
