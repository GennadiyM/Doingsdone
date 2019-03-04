<?php
session_start();
$title = "Дела в порядке";
$show_complete_tasks = 1;
if(isset($_SESSION['user'])) {
    $show_complete_tasks = $_SESSION['is_show_completed'];
}
$time_limit = 24;
$class_of_burning_tasks = "task--important";
$sql_get_categories = "SELECT projects.title, projects.id FROM projects WHERE projects.user_id = ?";
$sql_get_task_list = "SELECT * FROM tasks WHERE tasks.user_id = ? ORDER BY tasks.dt_create DESC";
$sql_get_count_tasks_in_project = "SELECT COUNT(tasks.project_id) AS count_tasks FROM tasks WHERE tasks.project_id = ? and tasks.user_id = ?";