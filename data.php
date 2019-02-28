<?php
$title = "Дела в порядке";
$show_complete_tasks = rand(0, 1);
$time_limit = 24;
$class_of_burning_tasks = "task--important";
$categories = ["Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];
$task_list = [
    [
        'task' => 'Собеседование в IT компании',
        'date' => '01.08.2019',
        'categories' => 'Работа',
        'status' => 'Нет'
    ],
    [
        'task' => 'Выполнить тестовое задание',
        'date' => '25.07.2019',
        'categories' => 'Работа',
        'status' => 'Нет'
    ],
    [
        'task' => 'Сделать задание первого раздела',
        'date' => '01.03.2019',
        'categories' => 'Учеба',
        'status' => 'Да'
    ],
    [
        'task' => 'Встреча с другом',
        'date' => '22.12.2019',
        'categories' => 'Входящие',
        'status' => 'Нет'
    ],
    [
        'task' => 'Купить корм для кота',
        'date' => 'Нет',
        'categories' => 'Домашние дела',
        'status' => 'Нет'
    ],
    [
        'task' => 'Заказать пиццу',
        'date' => 'Нет',
        'categories' => 'Домашние дела',
        'status' => 'Нет'
    ]
];
