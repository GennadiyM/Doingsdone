<?php
require_once('data.php');
require_once('function.php');

$page_content = include_template('index.php', ['task_list' => $task_list,
    'show_complete_tasks' => $show_complete_tasks, 'time_limit' => $time_limit, 'class_of_burning_tasks' => $class_of_burning_tasks]);
$page_layout = include_template('layout.php',['categories' => $categories,
    'title' => $title, 'task_list' => $task_list, 'content' => $page_content]);

print($page_layout);