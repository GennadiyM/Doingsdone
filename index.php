<?php
require_once('data.php');
require_once('function.php');
require_once('config.php');
require_once('availability_check.php');

$sql_get_task_list_by_category = "SELECT * FROM tasks WHERE tasks.user_id = ? AND tasks.project_id = ? ORDER BY tasks.dt_create DESC";
$sql_existence_check_tab_in_bd = "SELECT EXISTS(SELECT * FROM projects WHERE user_id = ? and id = ?) as result_check";
$sql_get_task_list_today = "SELECT * FROM tasks WHERE user_id = ? and dt_doing > DATE_SUB(CURDATE(), INTERVAL 1 day) AND dt_doing < DATE_ADD(CURDATE(), INTERVAL 1 day) ORDER BY dt_doing DESC";
$sql_get_task_list_today_by_category = "SELECT * FROM tasks WHERE user_id = ? AND project_id = ? AND dt_doing > DATE_SUB(CURDATE(), INTERVAL 1 day) AND dt_doing < DATE_ADD(CURDATE(), INTERVAL 1 day) ORDER BY dt_doing DESC";
$sql_get_task_list_tomorrow = "SELECT * FROM tasks WHERE user_id = ? AND dt_doing > CURDATE() AND dt_doing < DATE_ADD(CURDATE(), INTERVAL 2 day)";
$sql_get_task_list_tomorrow_by_category = "SELECT * FROM tasks WHERE user_id = ? AND project_id = ? AND dt_doing > CURDATE() AND dt_doing < DATE_ADD(CURDATE(), INTERVAL 2 day) ORDER BY dt_doing DESC";
$sql_get_task_list_overdue = "SELECT * FROM tasks WHERE user_id = ? AND dt_doing <CURDATE() ORDER BY dt_doing DESC";
$sql_get_task_list_overdue_by_category = "SELECT * FROM tasks WHERE user_id = ? AND project_id = ? AND dt_doing < CURDATE() ORDER BY dt_doing DESC";
$sql_check_task_done = "UPDATE tasks SET tasks.status = ? WHERE tasks.id = ? and tasks.user_id = ?";
$sql_search_tasks = "SELECT * FROM tasks WHERE MATCH(tasks.name_task) AGAINST(?) and tasks.user_id = ?";

$categories = db_fetch_data($link, $sql_get_categories, [$user_id]);

$error = '';

if (isset($_GET['cat'])) {
    $project_id = esc($_GET['cat']);
    $request_by_time = [
        "all" => "all" . "&cat=" . $project_id,
        "today" => "today" . "&cat=" . $project_id,
        "tomorrow" => "tomorrow" . "&cat=" . $project_id,
        "overdue" => "overdue" . "&cat=" . $project_id,
    ];
} else {
    $request_by_time = [
        "all" => "all",
        "today" => "today",
        "tomorrow" => "tomorrow",
        "overdue" => "overdue",
    ];
}

if (isset($_GET["check"])) {
    $task_id = esc($_GET["task_id"]);
    $task_status = 0;
    if ($_GET["check"] === '1') {
        $task_status = 1;
    }
    $stmt = mysqli_prepare($link, $sql_check_task_done);
    mysqli_stmt_bind_param($stmt, 'iii', $task_status, $task_id, $user_id);
    mysqli_stmt_execute($stmt);
    header('Location: ' . ($_SERVER['HTTP_REFERER']) ?? '/');
    exit;
}

if (isset($_GET['cat']) || isset($_GET['time'])) {
    if (isset($_GET['cat']) && isset($_GET['time'])) {
        $project_id = esc($_GET['cat']);
        verification_existence_project($link, $sql_existence_check_tab_in_bd, $user_id, $project_id);
        if ($_GET['time'] === 'all') {
            $task_list = db_fetch_data($link, $sql_get_task_list_by_category, [$user_id, $project_id]);
        } else if ($_GET['time'] === 'today') {
            $task_list = db_fetch_data($link, $sql_get_task_list_today_by_category, [$user_id, $project_id]);
        } else if ($_GET['time'] === 'tomorrow') {
            $task_list = db_fetch_data($link, $sql_get_task_list_tomorrow_by_category, [$user_id, $project_id]);
        } else {
            $task_list = db_fetch_data($link, $sql_get_task_list_overdue_by_category, [$user_id, $project_id]);
        }
    } else if (isset($_GET['cat'])) {
        $project_id = esc($_GET['cat']);
        verification_existence_project($link, $sql_existence_check_tab_in_bd, $user_id, $project_id);
        $task_list = db_fetch_data($link, $sql_get_task_list_by_category, [$user_id, $project_id]);
    } else {
        if ($_GET['time'] === 'all') {
            $task_list = db_fetch_data($link, $sql_get_task_list, [$user_id]);
        } else if ($_GET['time'] === 'today') {
            $task_list = db_fetch_data($link, $sql_get_task_list_today, [$user_id]);
        } else if ($_GET['time'] === 'tomorrow') {
            $task_list = db_fetch_data($link, $sql_get_task_list_tomorrow, [$user_id]);
        } else {
            $task_list = db_fetch_data($link, $sql_get_task_list_overdue, [$user_id]);
        }
    }
}

if (isset($_GET['show_completed'])) {
    $_SESSION['is_show_completed'] = (int)$_GET['show_completed'];
    header('Location: ' . ($_SERVER['HTTP_REFERER']) ?? '/');
    exit();
}

$search_in_get = $_GET['search'] ?? '';

if ($search_in_get) {
    $search = esc(trim($search_in_get));
    if (empty($search)) {
        $error = 'Введите запрос';
    } else {
        $task_list = db_fetch_data($link, $sql_search_tasks, [$search, $user_id]);
        if (empty($task_list)) {
            $error = "Ничего не найдено по вашему запросу";
        }
    }
}

$page_content = include_template('index.php', [
    'error' => $error,
    'request_by_time' => $request_by_time,
    'task_list' => $task_list,
    'show_complete_tasks' => $show_complete_tasks,
    'time_limit' => $time_limit,
    'class_of_burning_tasks' => $class_of_burning_tasks
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
