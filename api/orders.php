<?php
require_once __DIR__ . '/../config.php';

$pdo = getDB();
$sessionToken = $_SESSION['session_token'];
$userId = $_SESSION['user_id'] ?? null;

// ==========================================
// 1. GET: Fetch My Orders or Track Order
// ==========================================
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET') {
    if (isset($_GET['track'])) {
        $orderNumber = trim($_GET['track']);
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE order_number = ?");
        $stmt->execute([$orderNumber]);
        $order = $stmt->fetch();
        if ($order) {
            $order['items'] = json_decode($order['items_json'] ?: '[]', true);
            jsonResponse(['success' => true, 'order' => $order]);
        } else {
            jsonResponse(['success' => false, 'error' => 'Order not found with number ' . htmlspecialchars($orderNumber)], 404);
        }
    }

    if (isset($_GET['my_orders'])) {
        if (!$userId && empty($_SESSION['user']['email'])) {
            jsonResponse(['success' => true, 'orders' => []]);
        }
        $email = $_SESSION['user']['email'] ?? '';
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? OR customer_email = ? ORDER BY id DESC");
        $stmt->execute([$userId, $email]);
        $orders = $stmt->fetchAll();
        foreach ($orders as &$ord) {
            $ord['items'] = json_decode($ord['items_json'] ?: '[]', true);
        }
        jsonResponse(['success' => true, 'orders' => $orders]);
    }

    jsonResponse(['success' => false, 'error' => 'Invalid request'], 400);
}

// ==========================================
// 2. POST: Checkout & Create Order
// ==========================================
$data = json_decode(file_get_contents('php://input'), true) ?? $_POST;

$name = trim($data['name'] ?? ($_SESSION['user']['name'] ?? 'Healthcare Professional'));
$email = trim($data['email'] ?? ($_SESSION['user']['email'] ?? 'doctor@trademeds.com'));
$phone = trim($data['phone'] ?? ($_SESSION['user']['phone'] ?? '+91 98765 43210'));
$address = trim($data['address'] ?? 'Apollo Hospitals Medical Quarters, Chennai');
$paymentMethod = trim($data['payment_method'] ?? 'COD');

// Get cart items
$stmt = $pdo->prepare("SELECT * FROM cart_items WHERE session_token = ?");
$stmt->execute([$sessionToken]);
$items = $stmt->fetchAll();

if (empty($items)) {
    jsonResponse(['success' => false, 'error' => 'Your bag is empty. Please add items to checkout.'], 400);
}

// Verify stock for all items
foreach ($items as $item) {
    $pStmt = $pdo->prepare("SELECT title, stock FROM products WHERE id = ?");
    $pStmt->execute([$item['product_id']]);
    $prod = $pStmt->fetch();
    if ($prod && $prod['stock'] < $item['quantity']) {
        jsonResponse([
            'success' => false,
            'error' => "Insufficient stock for '{$prod['title']}'. Only {$prod['stock']} units available."
        ], 400);
    }
}

$subtotal = 0;
foreach ($items as $item) {
    $subtotal += ($item['product_price'] * $item['quantity']);
}

$discount = 0;
$couponCode = $_SESSION['applied_coupon'] ?? null;
if ($couponCode) {
    $stmtCpn = $pdo->prepare("SELECT * FROM coupons WHERE code = ? AND is_active = 1");
    $stmtCpn->execute([$couponCode]);
    $cpn = $stmtCpn->fetch();
    if ($cpn) {
        if ($cpn['discount_type'] === 'percentage') {
            $discount = round(($subtotal * ($cpn['discount_value'] / 100)), 2);
            if ($cpn['max_discount_amount'] > 0 && $discount > $cpn['max_discount_amount']) {
                $discount = (float)$cpn['max_discount_amount'];
            }
        } else {
            $discount = min($subtotal, (float)$cpn['discount_value']);
        }
        $pdo->prepare("UPDATE coupons SET times_used = times_used + 1 WHERE id = ?")->execute([$cpn['id']]);
    } elseif ($couponCode === 'FLASH12') {
        $discount = round($subtotal * 0.12, 2);
    } elseif ($couponCode === 'WELCOME10') {
        $discount = round($subtotal * 0.10, 2);
    }
}

$shippingFee = ($subtotal >= 1499) ? 0 : 99;
$total = max(0, $subtotal - $discount + $shippingFee);
$orderNumber = 'TM-' . date('Y') . '-' . strtoupper(substr(uniqid(), 8, 4)) . '-' . rand(100, 999);

$ins = $pdo->prepare("
    INSERT INTO orders (order_number, user_id, session_token, customer_name, customer_email, customer_phone, shipping_address, items_json, subtotal, discount, shipping_fee, total, payment_method, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Confirmed')
");
$ins->execute([
    $orderNumber,
    $userId,
    $sessionToken,
    $name,
    $email,
    $phone,
    $address,
    json_encode($items),
    $subtotal,
    $discount,
    $shippingFee,
    $total,
    $paymentMethod
]);
$orderId = $pdo->lastInsertId();

// Deduct stock for each purchased item & record stock history
foreach ($items as $item) {
    $prodId = (int)$item['product_id'];
    $qty = (int)$item['quantity'];

    // Get current stock
    $currStockStmt = $pdo->prepare("SELECT stock, title FROM products WHERE id = ?");
    $currStockStmt->execute([$prodId]);
    $curr = $currStockStmt->fetch();
    $stockBefore = $curr ? (int)$curr['stock'] : 0;
    $stockAfter = max(0, $stockBefore - $qty);

    // Update product stock
    $updStock = $pdo->prepare("UPDATE products SET stock = ? WHERE id = ?");
    $updStock->execute([$stockAfter, $prodId]);

    // Record stock history
    try {
        $pdo->prepare("
            INSERT INTO stock_history (product_id, product_title, change_type, quantity_changed, stock_before, stock_after, notes)
            VALUES (?, ?, 'order_reduction', ?, ?, ?, ?)
        ")->execute([
            $prodId,
            $curr['title'] ?? 'Product #' . $prodId,
            -$qty,
            $stockBefore,
            $stockAfter,
            "Order #$orderNumber checkout"
        ]);
    } catch (Exception $e) {
        // Continue even if table doesn't exist yet
    }
}

// Clear cart
$pdo->prepare("DELETE FROM cart_items WHERE session_token = ?")->execute([$sessionToken]);
unset($_SESSION['applied_coupon']);

jsonResponse([
    'success' => true,
    'message' => 'Order placed successfully! Thank you for ordering with TRADE MEDS.',
    'order_number' => $orderNumber,
    'order_id' => $orderId,
    'total' => $total,
    'item_count' => count($items)
]);
