<?php
session_start();
$db = [
    'host' => '127.0.0.1',
    'database' => 'doingdone',
    'user' => 'root',
    'password' => '',
];
$link = getConnection($db);
mysqli_set_charset($link, "utf8");