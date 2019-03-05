<?php
require_once('data.php');
require_once('function.php');
require_once('config.php');
require_once('absence _check.php');

$sql_check_email = "SELECT id FROM users WHERE users.email = ?";
$sql_user = "SELECT * FROM users WHERE email = ?";

$tpl_data = [
    'errors' => [],
    'values' => [
        'name' => '',
        'email' => '',
    ]
];

$categories = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $form = $_POST;
    $errors = [];
    $reg_fields = ['email', 'password'];
    foreach ($reg_fields as $field) {
        if (empty($form[$field])) {
            $errors[$field] = "Не заполнено поле " . $field;
        }
    }
    if (!empty($form['email'])) {
        $form['email'] = mb_strtolower($form['email'], 'UTF-8');
        $email = mysqli_real_escape_string($link, $form['email']);
        if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['invalid_email'] = 'Некорректный email';
        } else {
            $check_email = db_fetch_data($link, $sql_check_email, [$email]);
            if (count($check_email) === 0) {
                $errors['double_email'] = 'Пользователь с таким email не найден';
            }
        }
    }


    if (!count($errors)) {
        $user = db_fetch_data($link, $sql_user, [$email]);
        if (password_verify($form['password'], $user[0]['password'])) {
            unset($user[0]['password']);
            unset($user[0]['dt_add']);
            unset($user[0]['email']);
            unset($user[0]['name']);
            $_SESSION['user'] = $user[0]['id'];
            header("Location: /index.php");
            exit();
        } else {
            $errors['password_error'] = 'Неверный пароль';
        }
    }
    $tpl_data['errors'] = $errors;
    $tpl_data['values'] = $form;
}

$page_content = include_template('form-authorization.php', [
    'tpl_data' => $tpl_data
]);

$page_layout = include_template('layout.php',[
    'categories' => $categories,
    'title' => $title,
    'content' => $page_content,
]);

print($page_layout);
