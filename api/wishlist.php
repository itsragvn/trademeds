<?php
require_once __DIR__ . '/../config.php';

$pdo = getDB();
$sessionToken = $_SESSION['session_token'];
$userId = $_SESSION['user_id'] ?? null;

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($method === 'GET') {
    $stmt = $pdo->prepare("SELECT product_id FROM wishlist WHERE session_token = ?");
    $stmt->execute([$sessionToken]);
    $ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $jsonFile = DATA_DIR . '/products.json';
    $products = json_decode(file_get_contents($jsonFile), true);
    $wishlistProducts = [];
    foreach ($products as $p) {
        if (in_array($p['id'], $ids)) {
            $wishlistProducts[] = $p;
        }
    }

    jsonResponse([
        'success' => true,
        'ids' => $ids,
        'count' => count($ids),
        'products' => $wishlistProducts
    ]);
}

$data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
$action = $data['action'] ?? '';

if ($action === 'toggle') {
    $productId = (int)($data['product_id'] ?? 0);
    if ($productId <= 0) {
        jsonResponse(['success' => false, 'error' => 'Invalid product'], 400);
    }

    $stmt = $pdo->prepare("SELECT id FROM wishlist WHERE session_token = ? AND product_id = ?");
    $stmt->execute([$sessionToken, $productId]);
    $existing = $stmt->fetch();

    if ($existing) {
        $del = $pdo->prepare("DELETE FROM wishlist WHERE id = ?");
        $del->execute([$existing['id']]);
        $status = 'removed';
        $message = 'Removed from Wishlist';
    } else {
        $ins = $pdo->prepare("INSERT INTO wishlist (session_token, user_id, product_id) VALUES (?, ?, ?)");
        $ins->execute([$sessionToken, $userId, $productId]);
        $status = 'added';
        $message = 'Added to Wishlist';
    }

    // Get updated count
    $cntStmt = $pdo->prepare("SELECT COUNT(*) as cnt FROM wishlist WHERE session_token = ?");
    $cntStmt->execute([$sessionToken]);
    $count = (int)$cntStmt->fetch()['cnt'];

    jsonResponse([
        'success' => true,
        'status' => $status,
        'message' => $message,
        'count' => $count
    ]);
}

if ($action === 'clear') {
    $del = $pdo->prepare("DELETE FROM wishlist WHERE session_token = ?");
    $del->execute([$sessionToken]);
    jsonResponse(['success' => true, 'message' => 'Wishlist cleared', 'count' => 0]);
}

jsonResponse(['error' => 'Invalid action'], 400);
