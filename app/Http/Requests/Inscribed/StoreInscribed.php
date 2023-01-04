<?php

namespace App\Http\Requests\Inscribed;

use Illuminate\Foundation\Http\FormRequest;

class StoreInscribed extends FormRequest
{
    public $required = 'required';
    public $integer = 'integer';
    public $string = 'string';
    public $nullable = 'nullable';

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
            'birth_date' => $this->required.'|date_format:Y-m-d',
            'identification' => $this->required.'|regex:/^[\s\w-]+$/',
            'id_gender' => $this->required.'|'.$this->string,
            'id_birth_municipality' => $this->required.'|'.$this->integer,
            'id_residence_municipality' => $this->required.'|'.$this->integer,
            'id_birth_continent' => $this->required.'|'.$this->integer,
            'id_birth_country' => $this->required.'|'.$this->integer,
            'id_birth_state' => $this->required.'|'.$this->integer,
            'id_residence_continent' => $this->required.'|'.$this->integer,
            'id_residence_country' => $this->required.'|'.$this->integer,
            'id_residence_state' => $this->required.'|'.$this->integer,
            'id_stratum' => $this->required.'|'.$this->integer,
            'id_school' => $this->required.'|'.$this->integer,
            'year_of_degree' => $this->required.'|'.$this->integer,
            'registration_date' => $this->required.'|date_format:Y-m-d H:i:s',
            'credential' => $this->required.'|'.$this->integer,
            'id_first_option_program' => $this->required.'|'.$this->integer,
            'id_second_option_program' => $this->nullable.'|'.$this->integer,
            'id_registration_type' => $this->required.'|'.$this->string,
            'id_semester' => $this->required.'|'.$this->integer,
            'version' => $this->nullable.'|'.$this->integer,
            'day_session' => $this->nullable.'|'.$this->integer,
            //'' => '', // pendiente de augusto que pregunte
            'admitted' => $this->nullable.'|'.$this->string,
            'id_acceptance_type' => $this->nullable.'|'.$this->string,
            'id_accepted_program' => $this->nullable.'|'.$this->integer,
        ];
    }

    public function messages()
    {
        return [
            'birth_date'.$this->required => 'La Fecha de Nacimiento es obligatoria',
            'identification'.$this->required => 'La identificación es obligatoria',
            'id_gender'.$this->required => 'El Sexo es obligatorio',
            'id_birth_municipality'.$this->required => 'El Id Municipio de Nacimiento es obligatorio',
            'id_residence_municipality'.$this->required => 'El Id Municipio de Residencia es obligatorio',
            'id_birth_continent'.$this->required => 'El Id Continente de Nacimiento es obligatorio',
            'id_birth_country'.$this->required => 'El Id País de Nacimiento es obligatorio',
            'id_birth_state'.$this->required => 'El Id Departamento de Nacimiento es obligatorio',
            'id_residence_continent'.$this->required => 'El Id Continente de Residencia es obligatorio',
            'id_residence_country'.$this->required => 'El Id País de Residencia es obligatorio',
            'id_residence_state'.$this->required => 'El Id Departamento de Residencia es obligatorio',
            'id_stratum'.$this->required => 'El Estrato es obligatorio',
            'id_school'.$this->required => 'El Id de Colegio es obligatorio',
            'year_of_degree'.$this->required => 'El Año de titulación es obligatorio',
            'registration_date'.$this->required => 'La Fecha de Inscripción es obligatoria',
            'credential'.$this->required => 'La Credencial es obligatoria',
            'id_first_option_program'.$this->required => 'El Id Programa Primera Opción es obligatorio',
            'id_second_option_program'.$this->required => 'El Id Programa Segunda Opción es obligatorio',
            'id_semester'.$this->required => 'El Semestre es obligatorio',
            //'' => 'La Sede de presentación es obligatoria', // pendiente de augusto que pregunte
            'birth_date.date_format' => 'La Fecha de Nacimiento no cumple con el formato de fecha',
            'id_gender'.$this->string => 'El Sexo debe ser de tipo texto',
            'id_birth_municipality'.$this->integer => 'El Id Municipio de Nacimiento debe ser de tipo entero',
            'identification.regex' => 'La identificación debe ser de tipo alfanumérico',
            'id_residence_municipality'.$this->integer => 'El Id Municipio de Residencia debe ser de tipo entero',
            'id_birth_continent'.$this->integer => 'El Id Continente de Nacimiento debe ser de tipo entero',
            'id_birth_country'.$this->integer => 'El Id País de Nacimiento debe ser de tipo entero',
            'id_birth_state'.$this->integer => 'El Id Departamento de Nacimiento debe ser de tipo entero',
            'id_residence_continent'.$this->integer => 'El Id Continente de Residencia debe ser de tipo entero',
            'id_residence_country'.$this->integer => 'El Id País de Residencia debe ser de tipo entero',
            'id_residence_state'.$this->integer => 'El Id Departamento de Residencia debe ser de tipo entero',
            'id_stratum'.$this->integer => 'El Estrato debe ser de tipo entero',
            'id_school'.$this->integer => 'El Id de Colegio debe ser de tipo entero',
            'year_of_degree'.$this->integer => 'El Año de titulación debe ser de tipo entero',
            'registration_date.date_format' => 'La Fecha de Inscripción no cumple con el formato de fecha',
            'credential'.$this->integer => 'La Credencial debe ser de tipo entero',
            'id_first_option_program'.$this->integer => 'El Id Programa Primera Opción debe ser de tipo entero',
            'id_second_option_program'.$this->integer => 'El Id Programa Segunda Opción debe ser de tipo entero',
            'id_registration_type'.$this->string => 'El Tipo de Inscripción debe ser de tipo texto',
            'id_semester'.$this->integer => 'El Semestre debe ser de tipo entero',
            'version'.$this->integer => 'La Versión debe ser de tipo entero',
            'day_session'.$this->integer => 'La Jornada debe ser de tipo entero',
            //'' => 'La Sede de presentación debe ser de tipo texto', // pendiente de augusto que pregunte
            'admitted'.$this->string => 'Admitido debe ser de tipo texto',
            'id_acceptance_type'.$this->string => 'Tipo de Aceptación debe ser de tipo texto',
            'id_accepted_program'.$this->integer => 'Id Programa Admitido debe ser de tipo entero',

        ];
    }

}
