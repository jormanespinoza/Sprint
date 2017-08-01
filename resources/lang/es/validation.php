<?php

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

    'accepted'             => 'Este campo debe ser aceptado.',
    'active_url'           => 'Este campo no es una URL válida.',
    'after'                => 'Este campo debe ser una fecha posterior a la de Inicio.',
    'after_or_equal'       => 'Este campo debe ser una fecha posterior o igual a la de Inicio.',
    'alpha'                => 'Este campo sólo puede contener letras.',
    'alpha_dash'           => 'Este campo sólo puede contener letras, números y guiones (a-z, 0-9, -_).',
    'alpha_num'            => 'Este campo sólo puede contener letras y números.',
    'array'                => 'Este campo debe ser un array.',
    'before'               => 'Este campo debe ser una fecha anterior a la de cierre',
    'before_or_equal'      => 'Este campo debe ser una fecha anterior o igual a la de cierre',
    'between'              => [
        'numeric' => 'Este campo debe ser un valor entre :min y :max.',
        'file'    => 'El archivo debe pesar entre :min y :max kilobytes.',
        'string'  => 'Este campo debe contener entre :min y :max caracteres.',
        'array'   => 'Este campo debe contener entre :min y :max elementos.',
    ],
    'boolean'              => 'Este campo debe ser verdadero o falso.',
    'confirmed'            => 'Las contraseñas no coinciden',
    'country'              => 'Este campo no es un país válido.',
    'date'                 => 'Este campo no corresponde con una fecha válida.',
    'date_format'          => 'Este campo no corresponde con el formato de fecha :format.',
    'different'            => 'Los campos y :other han de ser diferentes.',
    'digits'               => 'Este campo debe ser un número de :digits dígitos.',
    'digits_between'       => 'Este campo debe contener entre :min y :max dígitos.',
    'dimensions'           => 'Este campo tiene dimensiones inválidas.',
    'distinct'             => 'Este campo tiene un valor duplicado.',
    'email'                => 'Este campo no corresponde con una dirección de e-mail válida.',
    'file'                 => 'Este campo debe ser un archivo.',
    'filled'               => 'Este campo es obligatorio.',
    'exists'               => 'Este campo no existe.',
    'image'                => 'Este campo debe ser una imagen.',
    'in'                   => 'Este campo debe ser igual a alguno de estos valores :values.',
    'in_array'             => 'Este campo no existe en :other.',
    'integer'              => 'Este campo debe ser un número entero.',
    'ip'                   => 'Este campo debe ser una dirección IP válida.',
    'ipv4'                 => 'Este campo debe ser una dirección IPv4 válida.',
    'ipv6'                 => 'Este campo debe ser una dirección IPv6 válida.',
    'json'                 => 'Este campo debe ser una cadena de texto JSON válida.',
    'max'                  => [
        'numeric' => 'Este campo debe ser :max como máximo.',
        'file'    => 'El archivo debe pesar :max kilobytes como máximo.',
        'string'  => 'Este campo debe contener :max caracteres como máximo.',
        'array'   => 'Este campo debe contener :max elementos como máximo.',
    ],
    'mimes'                => 'Este campo debe ser un archivo de tipo :values.',
    'mimetypes'            => 'Este campo debe ser un archivo de tipo :values.',
    'min'                  => [
        'numeric' => 'Este campo debe tener al menos :min.',
        'file'    => 'El archivo debe pesar al menos :min kilobytes.',
        'string'  => 'Este campo debe contener al menos :min caracteres.',
        'array'   => 'Este campo no debe contener más de :min elementos.',
    ],
    'not_in'               => 'Este campo seleccionado es inválido.',
    'numeric'              => 'Este campo debe ser un número.',
    'present'              => 'Este campo debe estar presente.',
    'regex'                => 'El formato dEste campo es inválido.',
    'required'             => 'Este campo es obligatorio.',
    'required_if'          => 'Este campo es obligatorio cuando Este campo :other es :value.',
    'required_unless'      => 'Este campo es requerido a menos que :other se encuentre en :values.',
    'required_with'        => 'Este campo es obligatorio cuando :values está presente.',
    'required_with_all'    => 'Este campo es obligatorio cuando :values está presente.',
    'required_without'     => 'Este campo es obligatorio cuando :values no está presente.',
    'required_without_all' => 'Este campo es obligatorio cuando ninguno de los campos :values está presente.',
    'same'                 => 'Los campos y :other deben coincidir.',
    'size'                 => [
        'numeric' => 'Este campo debe ser :size.',
        'file'    => 'El archivo debe pesar :size kilobytes.',
        'string'  => 'Este campo debe contener :size caracteres.',
        'array'   => 'Este campo debe contener :size elementos.',
    ],
    'state'                => 'El estado no es válido para el país seleccionado.',
    'string'               => 'Este campo debe contener sólo caracteres.',
    'timezone'             => 'Este campo debe contener una zona válida.',
    'unique'               => 'El elemento ya está en uso.',
    'uploaded'             => 'El elemento fallo al subir.',
    'url'                  => 'El formato de no corresponde con el de una URL válida.',
    "phone" => "Este campo contiene un número no válido",

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
