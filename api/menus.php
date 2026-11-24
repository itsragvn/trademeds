<?php
require_once __DIR__ . '/../config.php';

$pdo = getDB();
$location = trim($_GET['location'] ?? 'header');

$sql = "SELECT * FROM navigation_menus WHERE is_active = 1";
$params = [];
if ($location && $location !== 'all') {
    $sql .= " AND menu_location = ?";
    $params[] = $location;
}
$sql .= " ORDER BY display_order ASC, id ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$menus = $stmt->fetchAll();

jsonResponse([
    'success' => true,
    'location' => $location,
    'menus' => $menus
]);

