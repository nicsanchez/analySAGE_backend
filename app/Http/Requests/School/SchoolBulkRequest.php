<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;

class SchoolBulkRequest extends FormRequest
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
            'schoolCode' => $this->codeValidation,
            'schoolName' => $this->nameValidation,
            'stateCode' => $this->codeValidation,
            'stateName' => $this->nameValidation,
            'municipalityCode' => $this->codeValidation,
            'municipalityName' => $this->nameValidation,
            'naturalness' => $this->nameValidation,
        ];
    }

    public function messages()
    {
        return [
            'schoolCode.required' => 'El código del colegio debe ser requerido.',
            'schoolCode.integer' => 'El código del colegio debe ser numérico.',
            'schoolName.required' => 'El nombre del colegio debe ser requerido.',
            'schoolName.string' => 'El nombre del colegio debe ser de tipo texto.',
            'naturalness.required' => 'La naturalidad del colegio debe ser requerido.',
            'naturalness.string' => 'La naturalidad del colegio debe ser de tipo texto.',
            'stateCode.required' => 'El código del departamento debe ser requerido.',
            'stateCode.integer' => 'El código del departamento debe ser numérico.',
            'stateName.required' => 'El nombre del departamento debe ser requerido.',
            'stateName.string' => 'El nombre del departamento debe ser de tipo texto.',
            'municipalityCode.required' => 'El código del municipio debe ser requerido.',
            'municipalityCode.integer' => 'El código del municipio debe ser numérico.',
            'municipalityName.required' => 'El nombre del municipio debe ser requerido.',
            'municipalityName.string' => 'El nombre del municipio debe ser de tipo texto.'
        ];
    }
}
