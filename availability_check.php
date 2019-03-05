<?php

if (!isset($_SESSION['user'])) {
    header("Location: /guest.php");
    exit();
}