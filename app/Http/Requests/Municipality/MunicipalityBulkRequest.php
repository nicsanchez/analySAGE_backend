<?php

namespace App\Http\Requests\Municipality;

use Illuminate\Foundation\Http\FormRequest;

class MunicipalityBulkRequest extends FormRequest
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
            'continentCode' => $this->codeValidation,
            'continentName' => $this->nameValidation,
            'countryCode' => $this->codeValidation,
            'countryName' => $this->nameValidation,
            'stateCode' => $this->codeValidation,
            'stateName' => $this->nameValidation,
            'municipalityCode' => $this->codeValidation,
            'municipalityName' => $this->nameValidation,
        ];
    }

    public function messages()
    {
        return [
            'continentCode.required' => 'El código del continente debe ser requerido.',
            'continentCode.integer' => 'El código del continente debe ser numérico.',
            'continentName.required' => 'El nombre del continente debe ser requerido.',
            'continentName.string' => 'El nombre del continente debe ser de tipo texto.',
            'countryCode.required' => 'El código del pais debe ser requerido.',
            'countryCode.integer' => 'El código del pais debe ser numérico.',
            'countryName.required' => 'El nombre del pais debe ser requerido.',
            'countryName.string' => 'El nombre del pais debe ser de tipo texto.',
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
