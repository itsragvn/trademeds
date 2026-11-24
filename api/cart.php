<?php
require_once __DIR__ . '/../config.php';

$pdo = getDB();
$sessionToken = $_SESSION['session_token'];
$userId = $_SESSION['user_id'] ?? null;

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// Handle GET request: return cart items & totals
if ($method === 'GET') {
    $stmt = $pdo->prepare("SELECT * FROM cart_items WHERE session_token = ? ORDER BY id DESC");
    $stmt->execute([$sessionToken]);
    $items = $stmt->fetchAll();

    $subtotal = 0;
    $itemCount = 0;
    foreach ($items as $item) {
        $subtotal += ($item['product_price'] * $item['quantity']);
        $itemCount += $item['quantity'];
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
        } elseif ($couponCode === 'FLASH12') {
            $discount = round($subtotal * 0.12, 2);
        } elseif ($couponCode === 'WELCOME10') {
            $discount = round($subtotal * 0.10, 2);
        }
    }

    $freeShippingThreshold = 1499;
    $shippingFee = ($subtotal >= $freeShippingThreshold || $subtotal === 0) ? 0 : 99;
    $total = max(0, $subtotal - $discount + $shippingFee);
    $freeShippingProgress = min(100, round(($subtotal / $freeShippingThreshold) * 100));
    $freeShippingRemaining = max(0, $freeShippingThreshold - $subtotal);

    jsonResponse([
        'success' => true,
        'items' => $items,
        'itemCount' => $itemCount,
        'subtotal' => $subtotal,
        'discount' => $discount,
        'shippingFee' => $shippingFee,
        'total' => $total,
        'couponCode' => $couponCode,
        'freeShippingThreshold' => $freeShippingThreshold,
        'freeShippingProgress' => $freeShippingProgress,
        'freeShippingRemaining' => $freeShippingRemaining
    ]);
}

// Handle POST request: add, update, remove, clear, coupon
$data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
$action = $data['action'] ?? '';

if ($action === 'add') {
    $productId = (int)($data['product_id'] ?? 0);
    $size = trim($data['size'] ?? 'M');
    $color = trim($data['color'] ?? 'Navy Blue');
    $colorHex = trim($data['color_hex'] ?? '#1c2447');
    $quantity = max(1, (int)($data['quantity'] ?? 1));
    $embroidery = trim($data['embroidery'] ?? '');

    // Lookup product info
    $jsonFile = DATA_DIR . '/products.json';
    $products = json_decode(file_get_contents($jsonFile), true);
    $product = null;
    foreach ($products as $p) {
        if ($p['id'] === $productId) {
            $product = $p;
            break;
        }
    }

    if (!$product) {
        jsonResponse(['success' => false, 'error' => 'Product not found'], 404);
    }

    // Check if same item already exists in cart
    $stmt = $pdo->prepare("SELECT id, quantity FROM cart_items WHERE session_token = ? AND product_id = ? AND size = ? AND color = ? AND (embroidery = ? OR (embroidery IS NULL AND ? = ''))");
    $stmt->execute([$sessionToken, $productId, $size, $color, $embroidery, $embroidery]);
    $existing = $stmt->fetch();

    if ($existing) {
        $newQty = $existing['quantity'] + $quantity;
        $upd = $pdo->prepare("UPDATE cart_items SET quantity = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $upd->execute([$newQty, $existing['id']]);
    } else {
        $ins = $pdo->prepare("
            INSERT INTO cart_items (session_token, user_id, product_id, product_title, product_price, product_image, size, color, color_hex, quantity, embroidery)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $ins->execute([
            $sessionToken,
            $userId,
            $productId,
            $product['title'],
            $product['price'],
            $product['primaryImage'],
            $size,
            $color,
            $colorHex,
            $quantity,
            $embroidery ?: null
        ]);
    }

    jsonResponse(['success' => true, 'message' => 'Item added to bag!']);
}

if ($action === 'update') {
    $itemId = (int)($data['item_id'] ?? 0);
    $quantity = (int)($data['quantity'] ?? 1);

    if ($quantity <= 0) {
        $del = $pdo->prepare("DELETE FROM cart_items WHERE id = ? AND session_token = ?");
        $del->execute([$itemId, $sessionToken]);
    } else {
        $upd = $pdo->prepare("UPDATE cart_items SET quantity = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ? AND session_token = ?");
        $upd->execute([$quantity, $itemId, $sessionToken]);
    }

    jsonResponse(['success' => true, 'message' => 'Cart updated']);
}

if ($action === 'remove') {
    $itemId = (int)($data['item_id'] ?? 0);
    $del = $pdo->prepare("DELETE FROM cart_items WHERE id = ? AND session_token = ?");
    $del->execute([$itemId, $sessionToken]);
    jsonResponse(['success' => true, 'message' => 'Item removed']);
}

if ($action === 'clear') {
    $del = $pdo->prepare("DELETE FROM cart_items WHERE session_token = ?");
    $del->execute([$sessionToken]);
    unset($_SESSION['applied_coupon']);
    jsonResponse(['success' => true, 'message' => 'Cart cleared']);
}

if ($action === 'apply_coupon') {
    $coupon = strtoupper(trim($data['coupon_code'] ?? ''));
    if (!$coupon) {
        jsonResponse(['success' => false, 'error' => 'Please enter a coupon code'], 400);
    }

    // Check database coupons
    $stmt = $pdo->prepare("SELECT * FROM coupons WHERE code = ? AND is_active = 1");
    $stmt->execute([$coupon]);
    $cpn = $stmt->fetch();

    if ($cpn) {
        // Check usage limit
        if ($cpn['usage_limit'] > 0 && $cpn['times_used'] >= $cpn['usage_limit']) {
            jsonResponse(['success' => false, 'error' => 'This coupon has reached its usage limit'], 400);
        }
        // Check expiry date
        if (!empty($cpn['expires_at']) && strtotime($cpn['expires_at']) < time()) {
            jsonResponse(['success' => false, 'error' => 'This promo code has expired'], 400);
        }
        $_SESSION['applied_coupon'] = $coupon;
        $discLabel = ($cpn['discount_type'] === 'percentage') ? $cpn['discount_value'] . '% OFF' : '₹' . $cpn['discount_value'] . ' OFF';
        jsonResponse(['success' => true, 'message' => "Coupon $coupon applied ($discLabel)!"]);
    } elseif ($coupon === 'FLASH12' || $coupon === 'WELCOME10') {
        $_SESSION['applied_coupon'] = $coupon;
        jsonResponse(['success' => true, 'message' => "Coupon $coupon applied successfully!"]);
    } else {
        jsonResponse(['success' => false, 'error' => 'Invalid or expired promo code'], 400);
    }
}

jsonResponse(['error' => 'Invalid action'], 400);
