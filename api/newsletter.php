<?php
require_once __DIR__ . '/../config.php';

$pdo = getDB();
$data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
$email = trim($data['email'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(['success' => false, 'error' => 'Please enter a valid medical email address'], 400);
}

try {
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO newsletter (email) VALUES (?)");
    $stmt->execute([$email]);
    jsonResponse([
        'success' => true,
        'message' => 'Thank you for joining Trade Meds! Use code FLASH12 for 12% off your first scrub order.',
        'coupon' => 'FLASH12'
    ]);
} catch (Exception $e) {
    jsonResponse(['success' => true, 'message' => 'Welcome back to Trade Meds! Use code FLASH12 for 12% off.', 'coupon' => 'FLASH12']);
}

