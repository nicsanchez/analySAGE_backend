<?php

namespace App\Http\Requests\Inscribed;

use Illuminate\Foundation\Http\FormRequest;

class StoreInscribed extends FormRequest
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
            'birth_date' => 'required|date_format:Y-m-d',
            'identification' => 'required|alpha_num',
            'id_gender' => 'required|string',
            'id_birth_municipality' => 'required|integer',
            'id_residence_municipality' => 'required|integer',
            'id_birth_continent' => 'required|integer',
            'id_birth_country' => 'required|integer',
            'id_birth_state' => 'required|integer',
            'id_residence_continent' => 'required|integer',
            'id_residence_country' => 'required|integer',
            'id_residence_state' => 'required|integer',
            'id_stratum' => 'required|integer',
            'id_school' => 'required|integer',
            'year_of_degree' => 'required|integer',
            'registration_date' => 'required|date_format:Y-m-d H:i:s',
            'credential' => 'required|integer',
            'id_first_option_program' => 'required|integer',
            'id_second_option_program' => 'nullable|integer',
            'id_registration_type' => 'required|string',
            'id_semester' => 'required|integer',
            'version' => 'nullable|integer',
            'day_session' => 'nullable|integer',
            //'' => '', // pendiente de augusto que pregunte
            'admitted' => 'nullable|string',
            'id_acceptance_type' => 'nullable|string',
            'id_accepted_program' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'birth_date.required' => 'La Fecha de Nacimiento es obligatoria',
            'identification.required' => 'La identificación es obligatoria',
            'id_gender.required' => 'El Sexo es obligatorio',
            'id_birth_municipality.required' => 'El Id Municipio de Nacimiento es obligatorio',
            'id_residence_municipality.required' => 'El Id Municipio de Residencia es obligatorio',
            'id_birth_continent.required' => 'El Id Continente de Nacimiento es obligatorio',
            'id_birth_country.required' => 'El Id País de Nacimiento es obligatorio',
            'id_birth_state.required' => 'El Id Departamento de Nacimiento es obligatorio',
            'id_residence_continent.required' => 'El Id Continente de Residencia es obligatorio',
            'id_residence_country.required' => 'El Id País de Residencia es obligatorio',
            'id_residence_state.required' => 'El Id Departamento de Residencia es obligatorio',
            'id_stratum.required' => 'El Estrato es obligatorio',
            'id_school.required' => 'El Id de Colegio es obligatorio',
            'year_of_degree.required' => 'El Año de titulación es obligatorio',
            'registration_date.required' => 'La Fecha de Inscripción es obligatoria',
            'credential.required' => 'La Credencial es obligatoria',
            'id_first_option_program.required' => 'El Id Programa Primera Opción es obligatorio',
            'id_second_option_program.required' => 'El Id Programa Segunda Opción es obligatorio',
            'id_semester.required' => 'El Semestre es obligatorio',
            //'' => 'La Sede de presentación es obligatoria', // pendiente de augusto que pregunte
            'birth_date.date_format' => 'La Fecha de Nacimiento no cumple con el formato de fecha',
            'id_gender.string' => 'El Sexo debe ser de tipo texto',
            'id_birth_municipality.integer' => 'El Id Municipio de Nacimiento debe ser de tipo entero',
            'identification.alpha_num' => 'La identificación debe ser de tipo alfanumérico',
            'id_residence_municipality.integer' => 'El Id Municipio de Residencia debe ser de tipo entero',
            'id_birth_continent.integer' => 'El Id Continente de Nacimiento debe ser de tipo entero',
            'id_birth_country.integer' => 'El Id País de Nacimiento debe ser de tipo entero',
            'id_birth_state.integer' => 'El Id Departamento de Nacimiento debe ser de tipo entero',
            'id_residence_continent.integer' => 'El Id Continente de Residencia debe ser de tipo entero',
            'id_residence_country.integer' => 'El Id País de Residencia debe ser de tipo entero',
            'id_residence_state.integer' => 'El Id Departamento de Residencia debe ser de tipo entero',
            'id_stratum.integer' => 'El Estrato debe ser de tipo entero',
            'id_school.integer' => 'El Id de Colegio debe ser de tipo entero',
            'year_of_degree.integer' => 'El Año de titulación debe ser de tipo entero',
            'registration_date.date_format' => 'La Fecha de Inscripción no cumple con el formato de fecha',
            'credential.integer' => 'La Credencial debe ser de tipo entero',
            'id_first_option_program.integer' => 'El Id Programa Primera Opción debe ser de tipo entero',
            'id_second_option_program.integer' => 'El Id Programa Segunda Opción debe ser de tipo entero',
            'id_registration_type.string' => 'El Tipo de Inscripción debe ser de tipo texto',
            'id_semester.integer' => 'El Semestre debe ser de tipo entero',
            'version.integer' => 'La Versión debe ser de tipo entero',
            'day_session.integer' => 'La Jornada debe ser de tipo entero',
            //'' => 'La Sede de presentación debe ser de tipo texto', // pendiente de augusto que pregunte
            'admitted.string' => 'Admitido debe ser de tipo texto',
            'id_acceptance_type.string' => 'Tipo de Aceptación debe ser de tipo texto',
            'id_accepted_program.integer' => 'Id Programa Admitido debe ser de tipo entero',

        ];
    }

}
