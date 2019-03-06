<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('data.php');
require_once('function.php');
require_once('config.php');
require_once('availability_check.php');

$categories = db_fetch_data($link, $sql_get_categories, [$user_id]);
$sql_insert_new_project = "INSERT INTO projects (user_id, title) VALUES (?, ?)";
$sql_existence_check_project_in_bd = "SELECT EXISTS(SELECT * FROM projects WHERE projects.user_id = ? and projects.title = ?) as result_check";
$errors = '';
$title_project = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['title'])) {
        $errors = 'Это поле надо заполнить';
    } else if (ctype_space($_POST['title'])) {
        $errors = 'Название не должно состоять только из пробелов';
    } else {
        $title_project = esc(trim($_POST['title']));
        $count_project = db_fetch_data($link, $sql_existence_check_project_in_bd, [$user_id, $title_project]);
        if ($count_project[0]['result_check'] > 0) {
            $errors = 'Такой проект существует';
        }
    }
    if (!empty($errors) === false) {
        $id_new_project = db_insert_data($link, $sql_insert_new_project, [$user_id, $title_project]);
        header("Location: /add_project.php");
        exit();
    }
}

$page_content = include_template('form_project.php', [
    'errors' => $errors,
]);

$page_layout = include_template('layout.php', [
    'user_name' => $user_name[0]['name'],
    'categories' => $categories,
    'title' => $title,
    'task_list' => $task_list,
    'content' => $page_content,
    'sql_get_count_tasks_in_project' => $sql_get_count_tasks_in_project,
    'user_id' => $user_id,
    'link' => $link,
]);

print($page_layout);