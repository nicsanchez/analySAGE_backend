<?php

namespace App\Http\Requests\Questions;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestions extends FormRequest
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
            'day_session' => 'required|integer',
            'number' => 'required|integer',
            'right_answer' => 'required|string|max:1'
        ];
    }

    public function messages()
    {
        return [
            'day_session.required' => 'La Jornada es obligatoria',
            'number.required' => 'El Número de pregunta es obligatorio',
            'right_answer.required' => 'La Respuesta correcta es obligatoria',
            'day_session.integer' => 'La Jornada debe ser de tipo entero',
            'number.integer' => 'El Número de pregunta debe ser de tipo entero',
            'right_answer.string' => 'La Respuesta correcta de ser de tipo texto',
            'right_answer.max' => 'La Respuesta correcta es de máximo 1 caracter'
        ];
    }

}
