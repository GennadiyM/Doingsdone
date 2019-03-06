<?php
require_once('data.php');
require_once('function.php');
require_once('absence _check.php');

$page_guest = include_template('guest.php', [
    'title' => $title,
]);

print($page_guest);
