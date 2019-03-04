<?php
require_once('data.php');
require_once('function.php');
require_once('config.php');

if (isset($_SESSION['user'])) {
    header("Location: /index.php");
    exit();
}

$page_guest = include_template('guest.php', [
    'title' => $title,
]);

print($page_guest);
