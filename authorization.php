<?php
    require_once('functions.php');
    require_once('config.php');
    require_once('data.php');

    session_start();

    $link = getConnection($db);
    $errors = [];
    $tpl_data = [
        'errors' => [],
        'values' => []
    ];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $form = $_POST;
        $reg_fields = ['email', 'password'];

        foreach ($reg_fields as $field) {
            if (empty($form[$field])) {
                $errors[$field] = "Не заполнено поле " . $field;
            }
        }
        if (!empty($form['email'])) {
            $form['email'] = mb_strtolower($form['email'], 'UTF-8');
            if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['invalid_email'] = 'Некорректный email';
            }
        }
        if (empty($errors)) {
            $email = mysqli_real_escape_string($link, $form['email']);
            $sql = "SELECT * FROM users WHERE users.email = '$email'";
            $res = mysqli_query($link, $sql);
            $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

            if (!count($errors) and $user) {
                if (password_verify($form['password'], $user['password'])) {
                    unset($user['password']);
                    unset($user['dt_add']);
                    $_SESSION['user'] = $user;
                }
                else {
                    $errors['password_error'] = 'Неверный пароль';
                }
            }
            else {
                $errors['not_found_email'] = 'Такой пользователь не найден';
            }
        }
        if (!empty($errors)) {
            $tpl_data['errors'] = $errors;
            $tpl_data['values'] = $form;
            $page_content = include_template('auth.php', ['tpl_data' => $tpl_data]);
        }
        else {
            header("Location: /index.php");
            exit();
        }

    } else {
        if (isset($_SESSION['user'])) {
            header("Location: /index.php");
            exit();
        }
        else {
            $page_content = include_template('auth.php', ['tpl_data' => $tpl_data]);
        }
    }

    $page_layout = include_template('layout-auth.php', [
        'content' => $page_content,
        'title' => $title
    ]);

    print($page_layout);

