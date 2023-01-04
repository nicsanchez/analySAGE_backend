<?php

$atribute = ':attribute';
$field = 'El campo ';
$file = 'El archivo ';

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => $field . $atribute . ' debe ser aceptado.',
    'active_url'           => $field . $atribute . ' no es una URL válida.',
    'after'                => $field . $atribute . ' debe ser una fecha posterior a :date.',
    'after_or_equal'       => $field . $atribute . ' debe ser una fecha posterior o igual a :date.',
    'alpha'                => $field . $atribute . ' solo puede contener letras.',
    'alpha_dash'           => $field . $atribute . ' solo puede contener letras, números, guiones y guiones bajos.',
    'alpha_num'            => $field . $atribute . ' solo puede contener letras y números.',
    'array'                => $field . $atribute . ' debe ser un array.',
    'before'               => $field . $atribute . ' debe ser una fecha anterior a :date.',
    'before_or_equal'      => $field . $atribute . ' debe ser una fecha anterior o igual a :date.',
    'between'              => [
        'numeric' => $field . $atribute . ' debe ser un valor entre :min y :max.',
        'file'    => $file . $atribute . ' debe pesar entre :min y :max kilobytes.',
        'string'  => $field . $atribute . ' debe contener entre :min y :max caracteres.',
        'array'   => $field . $atribute . ' debe contener entre :min y :max elementos.',
    ],
    'boolean'              => $field . $atribute . ' debe ser verdadero o falso.',
    'confirmed'            => 'El campo confirmación de '. $atribute . ' no coincide.',
    'date'                 => $field . $atribute . ' no corresponde con una fecha válida.',
    'date_equals'          => $field . $atribute . ' debe ser una fecha igual a :date.',
    'date_format'          => $field . $atribute . ' no corresponde con el formato de fecha :format.',
    'different'            => 'Los campos '. $atribute . ' y :other deben ser diferentes.',
    'digits'               => $field . $atribute . ' debe ser un número de :digits dígitos.',
    'digits_between'       => $field . $atribute . ' debe contener entre :min y :max dígitos.',
    'dimensions'           => $field . $atribute . ' tiene dimensiones de imagen inválidas.',
    'distinct'             => $field . $atribute . ' tiene un valor duplicado.',
    'email'                => $field . $atribute . ' debe ser una dirección de correo válida.',
    'ends_with'            => $field . $atribute . ' debe finalizar con alguno de los siguientes valores: :values',
    'exists'               => $field . $atribute . ' seleccionado no existe.',
    'file'                 => $field . $atribute . ' debe ser un archivo.',
    'filled'               => $field . $atribute . ' debe tener un valor.',
    'gt'                   => [
        'numeric' => $field . $atribute . ' debe ser mayor a :value.',
        'file'    => $file . $atribute . ' debe pesar más de :value kilobytes.',
        'string'  => $field . $atribute . ' debe contener más de :value caracteres.',
        'array'   => $field . $atribute . ' debe contener más de :value elementos.',
    ],
    'gte'                  => [
        'numeric' => $field . $atribute . ' debe ser mayor o igual a :value.',
        'file'    => $file . $atribute . ' debe pesar :value o más kilobytes.',
        'string'  => $field . $atribute . ' debe contener :value o más caracteres.',
        'array'   => $field . $atribute . ' debe contener :value o más elementos.',
    ],
    'image'                => $field . $atribute . ' debe ser una imagen.',
    'in'                   => $field . $atribute . ' es inválido.',
    'in_array'             => $field . $atribute . ' no existe en :other.',
    'integer'              => $field . $atribute . ' debe ser un número entero.',
    'ip'                   => $field . $atribute . ' debe ser una dirección IP válida.',
    'ipv4'                 => $field . $atribute . ' debe ser una dirección IPv4 válida.',
    'ipv6'                 => $field . $atribute . ' debe ser una dirección IPv6 válida.',
    'json'                 => $field . $atribute . ' debe ser una cadena de texto JSON válida.',
    'lt'                   => [
        'numeric' => $field . $atribute . ' debe ser menor a :value.',
        'file'    => $file . $atribute . ' debe pesar menos de :value kilobytes.',
        'string'  => $field . $atribute . ' debe contener menos de :value caracteres.',
        'array'   => $field . $atribute . ' debe contener menos de :value elementos.',
    ],
    'lte'                  => [
        'numeric' => $field . $atribute . ' debe ser menor o igual a :value.',
        'file'    => $file . $atribute . ' debe pesar :value o menos kilobytes.',
        'string'  => $field . $atribute . ' debe contener :value o menos caracteres.',
        'array'   => $field . $atribute . ' debe contener :value o menos elementos.',
    ],
    'max'                  => [
        'numeric' => $field . $atribute . ' no debe ser mayor a :max.',
        'file'    => $file . $atribute . ' no debe pesar más de :max kilobytes.',
        'string'  => $field . $atribute . ' no debe contener más de :max caracteres.',
        'array'   => $field . $atribute . ' no debe contener más de :max elementos.',
    ],
    'mimes'                => $field . $atribute . ' debe ser un archivo de tipo: :values.',
    'mimetypes'            => $field . $atribute . ' debe ser un archivo de tipo: :values.',
    'min'                  => [
        'numeric' => $field . $atribute . ' debe ser al menos :min.',
        'file'    => $file . $atribute . ' debe pesar al menos :min kilobytes.',
        'string'  => $field . $atribute . ' debe contener al menos :min caracteres.',
        'array'   => $field . $atribute . ' debe contener al menos :min elementos.',
    ],
    'not_in'               => $field . $atribute . ' seleccionado es inválido.',
    'not_regex'            => 'El formato del campo '. $atribute . ' es inválido.',
    'numeric'              => $field . $atribute . ' debe ser un número.',
    'password'             => 'La contraseña es incorrecta.',
    'present'              => $field . $atribute . ' debe estar presente.',
    'regex'                => 'El formato del campo '. $atribute . ' es inválido.',
    'required'             => $field . $atribute . ' es obligatorio.',
    'required_if'          => $field . $atribute . ' es obligatorio cuando el campo :other es :value.',
    'required_unless'      => $field . $atribute . ' es requerido a menos que :other se encuentre en :values.',
    'required_with'        => $field . $atribute . ' es obligatorio cuando :values está presente.',
    'required_with_all'    => $field . $atribute . ' es obligatorio cuando :values están presentes.',
    'required_without'     => $field . $atribute . ' es obligatorio cuando :values no está presente.',
    'required_without_all' => $field . $atribute . ' es obligatorio cuando ninguno de los campos :values están presentes.',
    'same'                 => 'Los campos '. $atribute . ' y :other deben coincidir.',
    'size'                 => [
        'numeric' => $field . $atribute . ' debe ser :size.',
        'file'    => $file . $atribute . ' debe pesar :size kilobytes.',
        'string'  => $field . $atribute . ' debe contener :size caracteres.',
        'array'   => $field . $atribute . ' debe contener :size elementos.',
    ],
    'starts_with'          => $field . $atribute . ' debe comenzar con uno de los siguientes valores: :values',
    'string'               => $field . $atribute . ' debe ser una cadena de caracteres.',
    'timezone'             => $field . $atribute . ' debe ser una zona horaria válida.',
    'unique'               => 'El valor del campo '. $atribute . ' ya está en uso.',
    'uploaded'             => $field . $atribute . ' no se pudo subir.',
    'url'                  => 'El formato del campo '. $atribute . ' es inválido.',
    'uuid'                 => $field . $atribute . ' debe ser un UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
