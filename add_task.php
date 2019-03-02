<?php
require_once('data.php');
require_once('function.php');
require_once('config.php');

$link = getConnection($db);
$user_id = 1;

$sql_insert_new_task = "INSERT INTO tasks (user_id, project_id, name_task, dt_doing, status, path) VALUES ($user_id, ?, ?, ?, 0, ?)";
$sql_get_task_list_by_category = "SELECT * FROM tasks WHERE tasks.user_id = ? and tasks.project_id = ?";

$categories = db_fetch_data($link, $sql_get_categories, [$user_id]);
$task_list = db_fetch_data($link, $sql_get_task_list, [$user_id]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;
//    var_dump($_POST['date']);
    $errors = [];
    if (empty($_POST['name'])) {
        $errors['name'] = 'Это поле надо заполнить';
    }
    if (empty($_POST['project'])) {
        $errors['project'] = 'Создайте проект';
    }
    if ($_FILES['doc']['name']) {
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
        $path = null;
    }
    if(!count($errors)) {
        $project_id = $_POST['project'];
        $name_task = $_POST['name'];;
        $dt_doing = $_POST['date'];;
        if (empty($_POST['date'])) {
            $dt_doing = null;
        }
        $stmt = mysqli_prepare($link, $sql_insert_new_task);
        mysqli_stmt_bind_param($stmt, 'isss', $project_id, $name_task, $dt_doing, $path);
        mysqli_stmt_execute($stmt);
        header("Location: /index.php");
    }
}

$page_content = include_template('form_task.php', [
    'errors' => $errors,
    'categories' => $categories,
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


