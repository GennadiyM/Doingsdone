<?php
require_once('data.php');
require_once('function.php');
require_once('config.php');

$link = getConnection($db);
$user_id = 1;

$sql_get_categories = "SELECT projects.title, projects.id FROM projects WHERE projects.user_id = ?";
$sql_get_task_list = "SELECT * FROM tasks WHERE tasks.user_id = ?";

$categories = db_fetch_data($link, $sql_get_categories, [$user_id]);
$task_list = db_fetch_data($link, $sql_get_task_list, [$user_id]);

$page_content = include_template('index.php', [
    'task_list' => $task_list,
    'show_complete_tasks' => $show_complete_tasks,
    'time_limit' => $time_limit,
    'class_of_burning_tasks' => $class_of_burning_tasks
]);

$page_layout = include_template('layout.php',[
    'categories' => $categories,
    'title' => $title,
    'task_list' => $task_list,
    'content' => $page_content
]);

print($page_layout);