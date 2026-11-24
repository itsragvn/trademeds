<?php
require_once __DIR__ . '/../config.php';

$pdo = getDB();

$sql = "SELECT * FROM doctor_reviews WHERE is_active = 1 ORDER BY display_order ASC, id ASC";
$stmt = $pdo->query($sql);
$reviews = $stmt->fetchAll();

jsonResponse([
    'success' => true,
    'reviews' => $reviews
]);

