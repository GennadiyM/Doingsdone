<?php
require_once('data.php');
require_once('function.php');
require_once('config.php');

if (isset($_SESSION['user'])) {
    header("Location: /index.php");
    exit();
}

$sql_check_email = "SELECT id FROM users WHERE users.email = ?";
$sql_new_users = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";

$tpl_data = [
    'errors' => [],
    'values' => []
];

$id_new_user = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $form = $_POST;
        $errors = [];
        $reg_fields = ['email', 'password', 'name'];
        foreach ($reg_fields as $field) {
            if (empty($form[$field])) {
                $errors[$field] = "Не заполнено поле " . $field;
            }
        }
        if (empty($errors)) {
            $email = mysqli_real_escape_string($link, $form['email']);
            $check_email = db_fetch_data($link, $sql_check_email, [$email]);
            if (count($check_email) > 0) {
                $errors['double_email'] = 'Пользователь с этим email уже зарегистрирован';
            } else {
                $user_name = esc($form['name']);
                $password = password_hash($form['password'], PASSWORD_DEFAULT);
                $id_new_user = db_insert_data($link, $sql_new_users, [$user_name, $email, $password]);
            }
        }
        if ($id_new_user && empty($errors)) {
            $_SESSION['user'] = $id_new_user;
            header("Location: /index.php");
            exit();
        }
    $tpl_data['errors'] = $errors;
    $tpl_data['values'] = $form;
}

$page_content = include_template('register.php', [
    'tpl_data' => $tpl_data
]);

$page_layout = include_template('layout.php',[
    'title' => $title,
    'content' => $page_content,
]);

print($page_layout);