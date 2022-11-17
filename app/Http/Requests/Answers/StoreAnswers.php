<?php

namespace App\Http\Requests\Answers;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnswers extends FormRequest
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
            'credential' => 'required|integer',
            'semester' => 'required|integer',
            'marked_answers' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'credential.required' => 'La Credencial es obligatoria',
            'semester.required' => 'El Semestre es obligatorio',
            'marked_answers.required' => 'Las Respuestas Marcadas son obligatorias',
            'credential.integer' => 'La Credencial debe ser de tipo entero',
            'semester.integer' => 'El Semestre debe ser de tipo entero',
            'marked_answers.string' => 'Las Respuestas Marcadas debe ser de tipo texto',
        ];
    }

}
