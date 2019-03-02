<?php
require_once('data.php');
require_once('function.php');
require_once('config.php');

$link = getConnection($db);
$user_id = 1;

$sql_get_task_list_by_category = "SELECT * FROM tasks WHERE tasks.user_id = ? and tasks.project_id = ?";
$sql_existence_check_tab_in_bd = "SELECT EXISTS(SELECT * FROM tasks WHERE tasks.user_id = ? and tasks.project_id = ?) as result_check";

$categories = db_fetch_data($link, $sql_get_categories, [$user_id]);
$task_list = db_fetch_data($link, $sql_get_task_list, [$user_id]);

if (isset($_GET['cat'])) {
    $project_id = $_GET['cat'];
    $result_existence_check_tab_in_bd = db_fetch_data($link, $sql_existence_check_tab_in_bd, [$user_id, $project_id]);
    if ($result_existence_check_tab_in_bd[0]['result_check'] == 0) {
        http_response_code(404);
        echo '404 Not Found';
        exit;
    }
    $task_list = db_fetch_data($link, $sql_get_task_list_by_category, [$user_id, $project_id]);
}

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
    'content' => $page_content,
    'sql_get_count_tasks_in_project' => $sql_get_count_tasks_in_project,
    'user_id' => $user_id,
    'link' => $link,
]);

print($page_layout);


