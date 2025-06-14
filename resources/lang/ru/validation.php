<?php

return [
    'custom' => [
        'email' => [
            'exists' => 'Пользователь с таким email не существует',
            'unique' => 'Пользователь с таким email уже зарегистрирован',
        ],
        'password' => [
            'min' => 'Пароль должен иметь длину не менее :min символов',
            'confirmed' => 'Пароль и подтверждение не совпадают',
        ],
        'name' => [
            'unique' => ':entity с таким именем уже существует',
        ],
    ],

    'attributes' => [
        'email' => 'Email',
        'password' => 'Пароль',
        'name' => 'Имя',
        'description' => 'Описание',
        'status_id' => 'Статус',
        'assigned_to_id' => 'Исполнитель',
        'labels' => 'Метки',
    ],

    'required' => 'Это обязательное поле',

    'unique' => ':attribute с таким именем уже существует',

    'values' => [
        'entity' => 'Сущность',
    ],
];
