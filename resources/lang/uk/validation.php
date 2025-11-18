<?php

return [
    'required' => 'Поле :attribute є обов’язковим.',
    'string' => 'Поле :attribute повинно бути текстовим.',
    'email' => 'Поле :attribute повинно бути дійсною email-адресою.',
    'unique' => 'Поле :attribute вже зайняте.',
    'confirmed' => 'Підтвердження для :attribute не співпадає.',
    'integer' => 'Поле :attribute повинно бути числом.',
    'numeric' => 'Поле :attribute повинно бути числом.',
    'between' => [
        'numeric' => 'Поле :attribute повинно бути між :min і :max.',
        'string' => 'Поле :attribute повинно містити від :min до :max символів.',
    ],
    'max' => [
        'string' => 'Поле :attribute не може бути довшим за :max символів.',
    ],
    'min' => [
        'string' => 'Поле :attribute повинно містити не менше ніж :min символів.',
    ],
    'in' => 'Обране значення для :attribute некоректне.',
    'exists' => 'Обране значення для :attribute некоректне.',

    'attributes' => [
        'first_name' => 'ім’я',
        'last_name' => 'прізвище',
        'email' => 'email',
        'password' => 'пароль',
        'city_id' => 'місто',
        'name' => 'назва',
        'type' => 'тип',
        'status' => 'статус',
        'latitude' => 'широта',
        'longitude' => 'довгота',
        'description' => 'опис',
        'public_address' => 'публічна адреса',
    ],
];