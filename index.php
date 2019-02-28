<?php
require_once('function.php');
require_once('data.php');

$page_content = include_template('index.php', ['task_list' => $task_list,
    'show_complete_tasks' => $show_complete_tasks]);
$page_layout = include_template('layout.php',['categories' => $categories,
    'title' => $title, 'task_list' => $task_list, 'content' => $page_content]);
print($page_layout);