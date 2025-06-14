<?php

return [
    'create' => [
        'title' => 'Создать задачу',
        'fields' => [
            'name' => 'Имя',
            'description' => 'Описание',
            'status' => 'Статус',
            'assignee' => 'Исполнитель',
            'labels' => 'Метки',
        ],
        'submit' => 'Создать',
        'status_placeholder' => 'Выберите статус',
    ],
    'edit' => [
        'title' => 'Изменение задачи',
        'submit' => 'Обновить',
    ],
    'index' => [
        'title' => 'Задачи',
        'columns' => [
            'id' => 'ID',
            'status' => 'Статус',
            'name' => 'Имя',
            'author' => 'Автор',
            'assignee' => 'Исполнитель',
            'created_at' => 'Дата создания',
            'actions' => 'Действия',
        ],
        'filters' => [
            'status' => 'Статус',
            'author' => 'Автор',
            'assignee' => 'Исполнитель',
        ],
        'buttons' => [
            'apply' => 'Применить',
            'create' => 'Создать задачу',
            'edit' => 'Изменить',
            'delete' => 'Удалить',
        ],
        'delete_confirmation' => 'Вы уверены?',
    ],
    'show' => [
        'title' => 'Просмотр задачи: :name',
        'fields' => [
            'name' => 'Имя',
            'status' => 'Статус',
            'description' => 'Описание',
            'labels' => 'Метки',
        ],
        'empty_description' => '—',
    ],
];
