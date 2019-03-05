<?php
require_once('function.php');
require_once('config.php');
session_start();
$link = getConnection($db);
mysqli_set_charset($link, "utf8");
$show_complete_tasks = 1;
if(isset($_SESSION['user'])) {
    if (isset($_SESSION['is_show_completed'])) {
        $show_complete_tasks = $_SESSION['is_show_completed'];
    }
    $user_id = $_SESSION['user'];
    $sql_get_categories = "SELECT projects.title, projects.id FROM projects WHERE projects.user_id = ?";
    $sql_get_task_list = "SELECT * FROM tasks WHERE tasks.user_id = ? ORDER BY tasks.dt_create DESC";
    $sql_get_count_tasks_in_project = "SELECT COUNT(tasks.project_id) AS count_tasks FROM tasks WHERE tasks.project_id = ? and tasks.user_id = ?";
    $sql_get_user_name = "SELECT name FROM users WHERE id = ?";
    $user_name = db_fetch_data($link, $sql_get_user_name, [$user_id]);
    $task_list = db_fetch_data($link, $sql_get_task_list, [$user_id]);
}
$title = "Дела в порядке";
$time_limit = 24;
$class_of_burning_tasks = "task--important";
