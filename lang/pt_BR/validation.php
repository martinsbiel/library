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

    'accepted' => 'O campo :attribute deve ser accepted.',
    'accepted_if' => 'O campo :attribute must be accepted when :other is :value.',
    'active_url' => 'O campo :attribute não é uma URL válida.',
    'after' => 'O campo :attribute deve ser uma data posterior a :date.',
    'after_or_equal' => 'O campo :attribute deve ser uma data posterior ou igual a :date.',
    'alpha' => 'O campo :attribute deve conter apenas letras.',
    'alpha_dash' => 'O campo :attribute deve conter apenas letras, números, traços e underscores.',
    'alpha_num' => 'O campo :attribute deve conter apenas letras e números.',
    'array' => 'O campo :attribute deve ser um array.',
    'ascii' => 'O campo :attribute must only contain single-byte alphanumeric characters and symbols.',
    'before' => 'O campo :attribute deve ser uma data anterior a :date.',
    'before_or_equal' => 'O campo :attribute deve ser uma data anterior ou igual a :date.',
    'between' => [
        'array' => 'O campo :attribute deve conter entre :min e :max itens.',
        'file' => 'O campo :attribute deve ter entre :min e :max kilobytes.',
        'numeric' => 'O campo :attribute deve conter entre :min e :max.',
        'string' => 'O campo :attribute deve conter entre :min e :max caracteres.',
    ],
    'boolean' => 'O campo :attribute deve ser verdadeiro ou falso.',
    'confirmed' => 'O campo :attribute não coincide.',
    'current_password' => 'Senha incorreta.',
    'date' => 'O campo :attribute não é uma data válida.',
    'date_equals' => 'O campo :attribute deve ser uma data igual a :date.',
    'date_format' => 'O campo :attribute não corresponde com o formato :format.',
    'decimal' => 'O campo :attribute deve conter :decimal casas decimais.',
    'declined' => 'O campo :attribute deve ser declined.',
    'declined_if' => 'O campo :attribute deve ser declined quando :other é :value.',
    'different' => 'O campo :attribute e :other devem ser diferentes.',
    'digits' => 'O campo :attribute deve conter :digits dígitos.',
    'digits_between' => 'O campo :attribute deve conter entre :min e :max dígitos.',
    'dimensions' => 'O campo :attribute possui dimensões inválidas.',
    'distinct' => 'O campo :attribute possui um valor duplicado.',
    'doesnt_end_with' => 'O campo :attribute não pode terminar com: :values.',
    'doesnt_start_with' => 'O campo :attribute não pode começar com: :values.',
    'email' => 'O campo :attribute deve conter um email válido.',
    'ends_with' => 'O campo :attribute deve terminar com um dos seguintes: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'O campo :attribute deve ser um arquivo.',
    'filled' => 'O campo :attribute deve conter um valor.',
    'gt' => [
        'array' => 'O campo :attribute deve conter mais de :value itens.',
        'file' => 'O campo :attribute deve ser maior que :value kilobytes.',
        'numeric' => 'O campo :attribute deve ser maior que :value.',
        'string' => 'O campo :attribute deve conter mais de :value caracteres.',
    ],
    'gte' => [
        'array' => 'O campo :attribute deve conter :value itens ou mais.',
        'file' => 'O campo :attribute deve ser maior ou igual a :value kilobytes.',
        'numeric' => 'O campo :attribute deve ser maior ou igual a :value.',
        'string' => 'O campo :attribute deve ser maior ou igual a :value caracteres.',
    ],
    'image' => 'O campo :attribute deve conter uma imagem.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'O campo :attribute não existe em :other.',
    'integer' => 'O campo :attribute deve ser um número inteiro.',
    'ip' => 'O campo :attribute deve conter um endereço de IP válido.',
    'ipv4' => 'O campo :attribute deve conter um endereço de IPv4 válido.',
    'ipv6' => 'O campo :attribute deve conter um endereço de IPv6 válido.',
    'json' => 'O campo :attribute deve conter um JSON válido.',
    'lowercase' => 'O campo :attribute deve ser minúsculo.',
    'lt' => [
        'array' => 'O campo :attribute deve conter menos de :value itens.',
        'file' => 'O campo :attribute deve ser menor que :value kilobytes.',
        'numeric' => 'O campo :attribute deve ser menor que :value.',
        'string' => 'O campo :attribute deve conter menos de :value caracteres.',
    ],
    'lte' => [
        'array' => 'O campo :attribute não deve conter mais de :value itens.',
        'file' => 'O campo :attribute deve ser menor ou igual a :value kilobytes.',
        'numeric' => 'O campo :attribute deve ser menor ou igual a :value.',
        'string' => 'O campo :attribute deve ser menor ou igual a :value caracteres.',
    ],
    'mac_address' => 'O campo :attribute deve conter um endereço MAC válido.',
    'max' => [
        'array' => 'O campo :attribute não deve conter mais de :max itens.',
        'file' => 'O campo :attribute não pode ser superior a :max kilobytes.',
        'numeric' => 'O campo :attribute não pode ser superior a :max.',
        'string' => 'O campo :attribute não deve conter mais de :max caracteres.',
    ],
    'max_digits' => 'O campo :attribute não deve conter mais do que :max dígitos.',
    'mimes' => 'O campo :attribute deve ser um arquivo do tipo: :values.',
    'mimetypes' => 'O campo :attribute deve ser um arquivo do tipo: :values.',
    'min' => [
        'array' => 'O campo :attribute deve conter pelo menos :min itens.',
        'file' => 'O campo :attribute deve ter pelo menos :min kilobytes.',
        'numeric' => 'O campo :attribute deve ser pelo menos :min.',
        'string' => 'O campo :attribute deve conter pelo menos :min caracteres.',
    ],
    'min_digits' => 'O campo :attribute deve conter pelo menos :min dígitos.',
    'multiple_of' => 'O campo :attribute deve ser múltiplo de :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'O campo :attribute possui um formato inválido.',
    'numeric' => 'O campo :attribute deve ser um número.',
    'password' => [
        'letters' => 'O campo :attribute deve conter pelo menos uma letra.',
        'mixed' => 'O campo :attribute deve conter pelo menos uma letra maiúscula e minúscula.',
        'numbers' => 'O campo :attribute deve conter pelo menos um número.',
        'symbols' => 'O campo :attribute deve conter pelo menos um símbolo.',
        'uncompromised' => 'A :attribute fornecida já apareceu em um vazamento de dados. Por favor selecione uma :attribute diferente.',
    ],
    'present' => 'O campo :attribute deve estar presente.',
    'prohibited' => 'O campo :attribute field is prohibited.',
    'prohibited_if' => 'O campo :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'O campo :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'O campo :attribute field prohibits :other from being present.',
    'regex' => 'O campo :attribute possui um formato inválido.',
    'required' => 'O campo :attribute é obrigatório.',
    'required_array_keys' => 'O campo :attribute field must contain entries for: :values.',
    'required_if' => 'O campo :attribute é obrigatório quando :other é :value.',
    'required_if_accepted' => 'O campo :attribute é obrigatório quando :other é accepted.',
    'required_unless' => 'O campo :attribute field is required unless :other is in :values.',
    'required_with' => 'O campo :attribute é obrigatório quando :values está presente.',
    'required_with_all' => 'O campo :attribute é obrigatório :values estão presentes.',
    'required_without' => 'O campo :attribute é obrigatório quando :values não está presente.',
    'required_without_all' => 'O campo :attribute field is required when none of :values are present.',
    'same' => 'O campo :attribute e :other devem corresponder.',
    'size' => [
        'array' => 'O campo :attribute deve conter :size itens.',
        'file' => 'O campo :attribute deve ter :size kilobytes.',
        'numeric' => 'O campo :attribute deve ter :size.',
        'string' => 'O campo :attribute deve ter :size caracteres.',
    ],
    'starts_with' => 'O campo :attribute deve começar com um dos seguintes: :values.',
    'string' => 'O campo :attribute deve ser uma string.',
    'timezone' => 'O campo :attribute deve conter um fuso horário válido.',
    'unique' => 'O :attribute já está em uso.',
    'uploaded' => 'O campo :attribute failed to upload.',
    'uppercase' => 'O campo :attribute deve ser maiúsculo.',
    'url' => 'O campo :attribute deve ser uma URL válida.',
    'ulid' => 'O campo :attribute deve ser um ULID válido.',
    'uuid' => 'O campo :attribute deve ser um UUID válido.',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'nome',
        'password' => 'senha',
        'new_password' => 'confirmar senha',
        'book_id' => 'livro',
        'user_id' => 'usuário',
        'genre_id' => 'gênero',
    ],

];
