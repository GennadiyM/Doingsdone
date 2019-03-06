<?php
require_once('data.php');
require_once('function.php');
require_once('config.php');
require_once('availability_check.php');

$sql_insert_new_task = "INSERT INTO tasks (user_id, project_id, name_task, dt_doing, status, path) VALUES (?, ?, ?, ?, ?, ?)";
$sql_insert_new_task_without_file = "INSERT INTO tasks (user_id, project_id, name_task, dt_doing, status) VALUES (?, ?, ?, ?, ?)";
$sql_insert_new_task_without_date = "INSERT INTO tasks (user_id, project_id, name_task, status, path) VALUES (?, ?, ?, ?, ?)";
$sql_insert_new_task_without_file_and_date = "INSERT INTO tasks (user_id, project_id, name_task, status) VALUES (?, ?, ?, ?)";
$sql_get_task_list_by_category = "SELECT * FROM tasks WHERE tasks.user_id = ? and tasks.project_id = ?";
$sql_existence_check_project_in_bd = "SELECT EXISTS(SELECT * FROM projects WHERE projects.user_id = ? and projects.id = ?) as result_check";

$categories = db_fetch_data($link, $sql_get_categories, [$user_id]);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $dt_today = strtotime(date("d.m.Y"));
    $dt_doing = NULL;
    if(!empty($_POST["date"])){
        $str_dt_doing = strtotime($_POST["date"]);
        $dt_doing = date("Y.m.d", $str_dt_doing);
        $different_date = $str_dt_doing - $dt_today;
        if ($different_date < 0) {
            $errors['date'] = 'Дата не должна быть из прошлого';
            $dt_doing = NULL;
        }
    }
    if (empty($_POST['name'])) {
        $errors['name'] = 'Это поле надо заполнить';
    }
    if (empty($_POST['project'])) {
        $errors['project'] = 'Создайте проект';
    } else {
        $id_project = esc($_POST['project']);
        $count_project = db_fetch_data($link, $sql_existence_check_project_in_bd, [$user_id, $id_project]);
        if ($count_project[0]['result_check'] === 0) {
            $errors['project'] = 'Такой проект не существует';
        }
    }
    if ($_FILES['doc']['name'] ?? false) {
        $tmp_name = $_FILES['doc']['tmp_name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type == "text/plain" || strpos($file_type, 'image') === 0) {
            $filename = getFileName($file_type);
            move_uploaded_file($_FILES['doc']['tmp_name'], $filename);
            $path = $filename;
        } else {
            $errors['file'] = 'Только txt файлы и картинки';
        }
    } else {
        $path = NULL;
    }
    if(empty($errors['name']) && empty($errors['project']) && empty($errors['file']) && empty($errors['date'])) {
        $status = 0;
        $project_id = esc($_POST['project']);
        $name_task = esc($_POST['name']);
        if (is_null($path) && is_null($dt_doing)) {
            $id_new_tasks = db_insert_data($link, $sql_insert_new_task_without_file_and_date, [$user_id, $project_id, $name_task, $status]);
            header("Location: /index.php");
            exit();
        }
        if (is_null($path)) {
            $id_new_tasks = db_insert_data($link, $sql_insert_new_task_without_file, [$user_id, $project_id, $name_task, $dt_doing, $status]);
            header("Location: /index.php");
            exit();
        }
        if (is_null($dt_doing)) {
            $id_new_tasks = db_insert_data($link, $sql_insert_new_task_without_date, [$user_id, $project_id, $name_task, $status, $path]);
            header("Location: /index.php");
            exit();
        }
        $id_new_tasks = db_insert_data($link, $sql_insert_new_task, [$user_id, $project_id, $name_task, $dt_doing, $status, $path]);
        header("Location: /index.php");
        exit();
    }
}

$page_content = include_template('form_task.php', [
    'errors' => $errors,
    'categories' => $categories,
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
