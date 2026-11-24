<?php
require_once __DIR__ . '/../config.php';
unset($_SESSION['admin_user']);
header('Location: login.php');
exit;

