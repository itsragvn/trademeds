<?php
require_once __DIR__ . '/../config.php';

if (!isset($_SESSION['admin_user'])) {
    header('Location: login.php');
    exit;
}
$adminUser = $_SESSION['admin_user'];

