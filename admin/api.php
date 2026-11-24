<?php
require_once __DIR__ . '/../config.php';

// Ensure admin authentication
if (!isset($_SESSION['admin_user'])) {
    jsonResponse(['error' => 'Unauthorized admin access'], 401);
}

$pdo = getDB();
$data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
$action = $data['action'] ?? ($_GET['action'] ?? '');

// ==========================================
// 1. ORDERS MANAGEMENT
// ==========================================
if ($action === 'get_orders') {
    $status = trim($_GET['status'] ?? '');
    $sql = "SELECT * FROM orders";
    $params = [];
    if ($status && $status !== 'all') {
        $sql .= " WHERE status = ?";
        $params[] = $status;
    }
    $sql .= " ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $orders = $stmt->fetchAll();

    foreach ($orders as &$ord) {
        $ord['items'] = json_decode($ord['items_json'] ?: '[]', true);
    }

    jsonResponse(['success' => true, 'orders' => $orders]);
}

if ($action === 'update_order_status') {
    $orderId = (int)($data['order_id'] ?? 0);
    $newStatus = trim($data['status'] ?? 'Processing');

    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$newStatus, $orderId]);
    jsonResponse(['success' => true, 'message' => "Order #$orderId status updated to $newStatus"]);
}

// ==========================================
// 2. PRODUCTS & STOCK MANAGEMENT (CRUD)
// ==========================================
if ($action === 'get_products') {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
    $prods = $stmt->fetchAll();
    foreach ($prods as &$p) {
        $p['images'] = json_decode($p['images_json'] ?: '[]', true);
        $p['sizes'] = json_decode($p['sizes_json'] ?: '[]', true);
        $p['swatches'] = json_decode($p['swatches_json'] ?: '[]', true);
    }
    jsonResponse(['success' => true, 'products' => $prods]);
}

if ($action === 'update_stock') {
    $productId = (int)($data['product_id'] ?? 0);
    $stock = max(0, (int)($data['stock'] ?? 0));

    $stmt = $pdo->prepare("UPDATE products SET stock = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    $stmt->execute([$stock, $productId]);
    jsonResponse(['success' => true, 'message' => "Stock updated to $stock units"]);
}

if ($action === 'add_product') {
    $title = trim($data['title'] ?? '');
    $category = trim($data['category'] ?? 'Classic Scrubs');
    $collection = trim($data['collection'] ?? 'classic');
    $gender = trim($data['gender'] ?? 'Unisex');
    $price = (float)($data['price'] ?? 0);
    $origPrice = (float)($data['original_price'] ?? ($price * 1.3));
    $stock = (int)($data['stock'] ?? 50);
    $badge = trim($data['badge'] ?? '');
    $colorName = trim($data['color_name'] ?? 'Navy Blue');
    $colorHex = trim($data['color_hex'] ?? '#1c2447');
    $colorFamily = trim($data['color_family'] ?? 'All Blues');
    $primaryImage = trim($data['primary_image'] ?? '');
    $hoverImage = trim($data['hover_image'] ?? $primaryImage);
    $description = trim($data['description'] ?? '');
    $fabric = trim($data['fabric'] ?? '');
    $pockets = trim($data['pockets'] ?? '');

    if (!$title || $price <= 0 || !$primaryImage) {
        jsonResponse(['success' => false, 'error' => 'Title, Price, and Primary Image are required'], 400);
    }

    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title))) . '-' . rand(100, 999);
    $discount = ($origPrice > $price) ? round((($origPrice - $price) / $origPrice) * 100) . '% OFF' : '';

    $sizes = !empty($data['sizes']) ? (is_array($data['sizes']) ? $data['sizes'] : explode(',', $data['sizes'])) : ['XS','S','M','L','XL','2XL'];
    $images = !empty($data['images']) ? (is_array($data['images']) ? $data['images'] : [$primaryImage]) : [$primaryImage];
    $swatches = [
        ['name' => $colorName, 'hex' => $colorHex]
    ];

    $ins = $pdo->prepare("
        INSERT INTO products (
            title, slug, category, collection, gender, price, original_price, discount, stock,
            rating, reviews_count, badge, color_name, color_hex, color_family, primary_image, hover_image,
            images_json, sizes_json, swatches_json, description, fabric, pockets, status
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?,
            4.8, 12, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, 'active'
        )
    ");
    $ins->execute([
        $title, $slug, $category, $collection, $gender, $price, $origPrice, $discount, $stock,
        $badge, $colorName, $colorHex, $colorFamily, $primaryImage, $hoverImage,
        json_encode($images), json_encode($sizes), json_encode($swatches), $description, $fabric, $pockets
    ]);

    jsonResponse(['success' => true, 'message' => "Product '$title' added successfully!"]);
}

if ($action === 'update_product') {
    $id = (int)($data['id'] ?? 0);
    $title = trim($data['title'] ?? '');
    $category = trim($data['category'] ?? '');
    $collection = trim($data['collection'] ?? 'classic');
    $gender = trim($data['gender'] ?? 'Unisex');
    $price = (float)($data['price'] ?? 0);
    $origPrice = (float)($data['original_price'] ?? $price);
    $stock = (int)($data['stock'] ?? 0);
    $badge = trim($data['badge'] ?? '');
    $colorName = trim($data['color_name'] ?? '');
    $colorHex = trim($data['color_hex'] ?? '');
    $primaryImage = trim($data['primary_image'] ?? '');
    $hoverImage = trim($data['hover_image'] ?? $primaryImage);
    $description = trim($data['description'] ?? '');
    $fabric = trim($data['fabric'] ?? '');
    $pockets = trim($data['pockets'] ?? '');
    $status = trim($data['status'] ?? 'active');

    if ($id <= 0 || !$title || $price <= 0) {
        jsonResponse(['success' => false, 'error' => 'Invalid product details'], 400);
    }

    $discount = ($origPrice > $price) ? round((($origPrice - $price) / $origPrice) * 100) . '% OFF' : '';

    $upd = $pdo->prepare("
        UPDATE products SET
            title = ?, category = ?, collection = ?, gender = ?, price = ?, original_price = ?,
            discount = ?, stock = ?, badge = ?, color_name = ?, color_hex = ?,
            primary_image = ?, hover_image = ?, description = ?, fabric = ?, pockets = ?, status = ?,
            updated_at = CURRENT_TIMESTAMP
        WHERE id = ?
    ");
    $upd->execute([
        $title, $category, $collection, $gender, $price, $origPrice,
        $discount, $stock, $badge, $colorName, $colorHex,
        $primaryImage, $hoverImage, $description, $fabric, $pockets, $status,
        $id
    ]);

    jsonResponse(['success' => true, 'message' => "Product #$id updated successfully!"]);
}

if ($action === 'delete_product') {
    $id = (int)($data['id'] ?? 0);
    $del = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $del->execute([$id]);
    jsonResponse(['success' => true, 'message' => "Product #$id deleted successfully!"]);
}

// ==========================================
// 3. IMAGE UPLOAD HANDLER
// ==========================================
if ($action === 'upload_image' && !empty($_FILES['image'])) {
    $file = $_FILES['image'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

    if (!in_array($ext, $allowed)) {
        jsonResponse(['success' => false, 'error' => 'Only JPG, PNG, WEBP, or GIF images are allowed'], 400);
    }

    $filename = 'tm_prod_' . uniqid() . '.' . $ext;
    $targetPath = UPLOADS_DIR . '/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        $publicUrl = 'uploads/' . $filename;
        jsonResponse(['success' => true, 'url' => $publicUrl]);
    } else {
        jsonResponse(['success' => false, 'error' => 'Failed to save uploaded image'], 500);
    }
}

// ==========================================
// 4. SALES REPORT & ANALYTICS
// ==========================================
if ($action === 'sales_report') {
    $range = trim($_GET['range'] ?? 'all');
    $dateCondition = "";
    $isMysql = ($pdo->getAttribute(PDO::ATTR_DRIVER_NAME) === 'mysql');

    if ($range === 'today') {
        $dateCondition = " WHERE DATE(created_at) = CURRENT_DATE";
    } elseif ($range === 'week') {
        $dateCondition = $isMysql ? " WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)" : " WHERE created_at >= datetime('now', '-7 days')";
    } elseif ($range === 'month') {
        $dateCondition = $isMysql ? " WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)" : " WHERE created_at >= datetime('now', '-30 days')";
    } elseif ($range === 'year') {
        $dateCondition = $isMysql ? " WHERE created_at >= DATE_SUB(NOW(), INTERVAL 365 DAY)" : " WHERE created_at >= datetime('now', '-365 days')";
    }

    // Totals according to range
    $totals = $pdo->query("SELECT COUNT(*) as total_orders, COALESCE(SUM(total), 0) as total_revenue, COALESCE(AVG(total), 0) as aov FROM orders $dateCondition")->fetch();
    $custCount = $pdo->query("SELECT COUNT(DISTINCT customer_email) as total_customers FROM orders $dateCondition")->fetch()['total_customers'];
    $prodCount = $pdo->query("SELECT COUNT(*) as total_products, COALESCE(SUM(stock), 0) as total_stock FROM products WHERE status = 'active'")->fetch();
    $lowStock = $pdo->query("SELECT COUNT(*) as count FROM products WHERE stock < 20")->fetch()['count'];
    $outOfStock = $pdo->query("SELECT COUNT(*) as count FROM products WHERE stock = 0")->fetch()['count'];

    // Status Breakdown
    $statusRows = $pdo->query("SELECT status, COUNT(*) as count FROM orders $dateCondition GROUP BY status")->fetchAll();

    // Payment Methods Breakdown
    $payRows = $pdo->query("SELECT payment_method, COUNT(*) as count, COALESCE(SUM(total), 0) as amount FROM orders $dateCondition GROUP BY payment_method")->fetchAll();

    // Best Selling Products from JSON
    $ordersForBest = $pdo->query("SELECT items_json FROM orders $dateCondition")->fetchAll();
    $productSales = [];
    foreach ($ordersForBest as $row) {
        $items = json_decode($row['items_json'] ?: '[]', true);
        foreach ($items as $it) {
            $t = $it['product_title'] ?? 'Medical Item';
            $qty = (int)($it['quantity'] ?? 1);
            $amt = (float)($it['product_price'] ?? 0) * $qty;
            if (!isset($productSales[$t])) {
                $productSales[$t] = ['title' => $t, 'quantity' => 0, 'revenue' => 0];
            }
            $productSales[$t]['quantity'] += $qty;
            $productSales[$t]['revenue'] += $amt;
        }
    }
    usort($productSales, function($a, $b) { return $b['quantity'] <=> $a['quantity']; });
    $topProducts = array_slice(array_values($productSales), 0, 8);

    jsonResponse([
        'success' => true,
        'metrics' => [
            'total_revenue' => (float)$totals['total_revenue'],
            'total_orders' => (int)$totals['total_orders'],
            'aov' => round((float)$totals['aov'], 2),
            'total_customers' => (int)$custCount,
            'total_products' => (int)$prodCount['total_products'],
            'total_stock' => (int)$prodCount['total_stock'],
            'low_stock' => (int)$lowStock,
            'out_of_stock' => (int)$outOfStock
        ],
        'status_breakdown' => $statusRows,
        'payment_breakdown' => $payRows,
        'top_products' => $topProducts
    ]);
}

// ==========================================
// 5. CATEGORIES MANAGEMENT (CRUD)
// ==========================================
if ($action === 'get_categories') {
    $stmt = $pdo->query("SELECT c.*, (SELECT COUNT(*) FROM products p WHERE p.category = c.name) as product_count FROM categories c ORDER BY c.display_order ASC, c.id ASC");
    $cats = $stmt->fetchAll();
    jsonResponse(['success' => true, 'categories' => $cats]);
}

if ($action === 'add_category') {
    $name = trim($data['name'] ?? '');
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    $image = trim($data['image'] ?? '');
    $desc = trim($data['description'] ?? '');
    $order = (int)($data['display_order'] ?? 0);

    if (!$name) {
        jsonResponse(['success' => false, 'error' => 'Category name is required'], 400);
    }

    $ins = $pdo->prepare("INSERT INTO categories (name, slug, image, description, display_order) VALUES (?, ?, ?, ?, ?)");
    $ins->execute([$name, $slug, $image, $desc, $order]);
    jsonResponse(['success' => true, 'message' => "Category '$name' created successfully!"]);
}

if ($action === 'update_category') {
    $id = (int)($data['id'] ?? 0);
    $name = trim($data['name'] ?? '');
    $image = trim($data['image'] ?? '');
    $desc = trim($data['description'] ?? '');

    if ($id <= 0 || !$name) {
        jsonResponse(['success' => false, 'error' => 'Valid category ID and name required'], 400);
    }

    $upd = $pdo->prepare("UPDATE categories SET name = ?, image = ?, description = ? WHERE id = ?");
    $upd->execute([$name, $image, $desc, $id]);
    jsonResponse(['success' => true, 'message' => "Category updated successfully!"]);
}

if ($action === 'delete_category') {
    $id = (int)($data['id'] ?? 0);
    $del = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $del->execute([$id]);
    jsonResponse(['success' => true, 'message' => "Category deleted successfully!"]);
}

// ==========================================
// 6. STOCK HISTORY
// ==========================================
if ($action === 'get_stock_history') {
    $stmt = $pdo->query("SELECT * FROM stock_history ORDER BY id DESC LIMIT 50");
    jsonResponse(['success' => true, 'history' => $stmt->fetchAll()]);
}

// ==========================================
// 7. EXPORT CSV (Orders / Sales)
// ==========================================
if ($action === 'export_orders_csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=TRADE_MEDS_Orders_' . date('Y-m-d') . '.csv');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Order #', 'Customer Name', 'Email', 'Phone', 'Address', 'Subtotal', 'Discount', 'Shipping', 'Total', 'Payment', 'Status', 'Date']);

    $orders = $pdo->query("SELECT * FROM orders ORDER BY id DESC")->fetchAll();
    foreach ($orders as $ord) {
        fputcsv($output, [
            $ord['order_number'],
            $ord['customer_name'],
            $ord['customer_email'],
            $ord['customer_phone'],
            $ord['shipping_address'],
            $ord['subtotal'],
            $ord['discount'],
            $ord['shipping_fee'],
            $ord['total'],
            $ord['payment_method'],
            $ord['status'],
            $ord['created_at']
        ]);
    }
    fclose($output);
    exit;
}

// ==========================================
// 8. CHANGE ADMIN PASSWORD
// ==========================================
if ($action === 'change_password') {
    $currentPass = trim($data['current_password'] ?? '');
    $newPass = trim($data['new_password'] ?? '');

    if (strlen($newPass) < 6) {
        jsonResponse(['success' => false, 'error' => 'New password must be at least 6 characters long'], 400);
    }

    $adminId = $_SESSION['admin_user']['id'];
    $stmt = $pdo->prepare("SELECT password_hash FROM admin_users WHERE id = ?");
    $stmt->execute([$adminId]);
    $admin = $stmt->fetch();

    if (!$admin || !password_verify($currentPass, $admin['password_hash'])) {
        jsonResponse(['success' => false, 'error' => 'Current password is incorrect'], 401);
    }

    $newHash = password_hash($newPass, PASSWORD_DEFAULT);
    $upd = $pdo->prepare("UPDATE admin_users SET password_hash = ? WHERE id = ?");
    $upd->execute([$newHash, $adminId]);

    jsonResponse(['success' => true, 'message' => 'Admin password updated successfully!']);
}

// ==========================================
// 9. PRODUCT STATUS TOGGLE
// ==========================================
if ($action === 'toggle_product_status') {
    $id = (int)($data['id'] ?? 0);
    $stmt = $pdo->prepare("SELECT status FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $prod = $stmt->fetch();
    if (!$prod) {
        jsonResponse(['success' => false, 'error' => 'Product not found'], 404);
    }
    $newStatus = ($prod['status'] === 'active') ? 'archived' : 'active';
    $upd = $pdo->prepare("UPDATE products SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    $upd->execute([$newStatus, $id]);
    jsonResponse(['success' => true, 'status' => $newStatus, 'message' => "Product status changed to $newStatus"]);
}

// ==========================================
// 10. NAVIGATION MENUS CRUD
// ==========================================
if ($action === 'get_menus') {
    $location = trim($_GET['location'] ?? '');
    $sql = "SELECT * FROM navigation_menus";
    $params = [];
    if ($location && $location !== 'all') {
        $sql .= " WHERE menu_location = ?";
        $params[] = $location;
    }
    $sql .= " ORDER BY display_order ASC, id ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $menus = $stmt->fetchAll();
    jsonResponse(['success' => true, 'menus' => $menus]);
}

if ($action === 'add_menu') {
    $title = trim($data['title'] ?? '');
    $url = trim($data['url'] ?? '#');
    $parentId = (int)($data['parent_id'] ?? 0);
    $location = trim($data['menu_location'] ?? 'header');
    $badge = trim($data['badge'] ?? '');
    $target = trim($data['target'] ?? '_self');
    $order = (int)($data['display_order'] ?? 0);
    $isActive = isset($data['is_active']) ? (int)$data['is_active'] : 1;

    if (!$title) {
        jsonResponse(['success' => false, 'error' => 'Menu title is required'], 400);
    }

    $ins = $pdo->prepare("INSERT INTO navigation_menus (title, url, parent_id, menu_location, badge, target, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $ins->execute([$title, $url, $parentId, $location, $badge, $target, $order, $isActive]);
    jsonResponse(['success' => true, 'message' => "Menu item '$title' created successfully!"]);
}

if ($action === 'update_menu') {
    $id = (int)($data['id'] ?? 0);
    $title = trim($data['title'] ?? '');
    $url = trim($data['url'] ?? '#');
    $parentId = (int)($data['parent_id'] ?? 0);
    $location = trim($data['menu_location'] ?? 'header');
    $badge = trim($data['badge'] ?? '');
    $target = trim($data['target'] ?? '_self');
    $order = (int)($data['display_order'] ?? 0);
    $isActive = isset($data['is_active']) ? (int)$data['is_active'] : 1;

    if ($id <= 0 || !$title) {
        jsonResponse(['success' => false, 'error' => 'Valid menu ID and title required'], 400);
    }

    $upd = $pdo->prepare("UPDATE navigation_menus SET title = ?, url = ?, parent_id = ?, menu_location = ?, badge = ?, target = ?, display_order = ?, is_active = ? WHERE id = ?");
    $upd->execute([$title, $url, $parentId, $location, $badge, $target, $order, $isActive, $id]);
    jsonResponse(['success' => true, 'message' => "Menu item updated successfully!"]);
}

if ($action === 'delete_menu') {
    $id = (int)($data['id'] ?? 0);
    if ($id <= 0) {
        jsonResponse(['success' => false, 'error' => 'Valid menu ID required'], 400);
    }
    // Delete target menu item and unlink children
    $del = $pdo->prepare("DELETE FROM navigation_menus WHERE id = ?");
    $del->execute([$id]);
    $unlink = $pdo->prepare("UPDATE navigation_menus SET parent_id = 0 WHERE parent_id = ?");
    $unlink->execute([$id]);
    jsonResponse(['success' => true, 'message' => "Menu item deleted successfully!"]);
}

if ($action === 'toggle_menu_status') {
    $id = (int)($data['id'] ?? 0);
    $stmt = $pdo->prepare("SELECT is_active FROM navigation_menus WHERE id = ?");
    $stmt->execute([$id]);
    $menu = $stmt->fetch();
    if (!$menu) {
        jsonResponse(['success' => false, 'error' => 'Menu item not found'], 404);
    }
    $newStatus = $menu['is_active'] ? 0 : 1;
    $upd = $pdo->prepare("UPDATE navigation_menus SET is_active = ? WHERE id = ?");
    $upd->execute([$newStatus, $id]);
    jsonResponse(['success' => true, 'is_active' => $newStatus, 'message' => "Menu status updated"]);
}

// ==========================================
// 11. COUPONS / PROMO CODES CRUD
// ==========================================
if ($action === 'get_coupons') {
    $stmt = $pdo->query("SELECT * FROM coupons ORDER BY id DESC");
    jsonResponse(['success' => true, 'coupons' => $stmt->fetchAll()]);
}

if ($action === 'add_coupon') {
    $code = strtoupper(trim($data['code'] ?? ''));
    $type = trim($data['discount_type'] ?? 'percentage');
    $val = (float)($data['discount_value'] ?? 0);
    $minOrd = (float)($data['min_order_amount'] ?? 0);
    $maxDisc = (float)($data['max_discount_amount'] ?? 0);
    $limit = (int)($data['usage_limit'] ?? 0);
    $expires = !empty($data['expires_at']) ? trim($data['expires_at']) : null;
    $isActive = isset($data['is_active']) ? (int)$data['is_active'] : 1;

    if (!$code || $val <= 0) {
        jsonResponse(['success' => false, 'error' => 'Coupon code and discount value are required'], 400);
    }

    $chk = $pdo->prepare("SELECT id FROM coupons WHERE code = ?");
    $chk->execute([$code]);
    if ($chk->fetch()) {
        jsonResponse(['success' => false, 'error' => "Coupon code '$code' already exists"], 400);
    }

    $ins = $pdo->prepare("INSERT INTO coupons (code, discount_type, discount_value, min_order_amount, max_discount_amount, usage_limit, expires_at, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $ins->execute([$code, $type, $val, $minOrd, $maxDisc, $limit, $expires, $isActive]);
    jsonResponse(['success' => true, 'message' => "Coupon '$code' created successfully!"]);
}

if ($action === 'update_coupon') {
    $id = (int)($data['id'] ?? 0);
    $code = strtoupper(trim($data['code'] ?? ''));
    $type = trim($data['discount_type'] ?? 'percentage');
    $val = (float)($data['discount_value'] ?? 0);
    $minOrd = (float)($data['min_order_amount'] ?? 0);
    $maxDisc = (float)($data['max_discount_amount'] ?? 0);
    $limit = (int)($data['usage_limit'] ?? 0);
    $expires = !empty($data['expires_at']) ? trim($data['expires_at']) : null;
    $isActive = isset($data['is_active']) ? (int)$data['is_active'] : 1;

    if ($id <= 0 || !$code || $val <= 0) {
        jsonResponse(['success' => false, 'error' => 'Valid coupon details required'], 400);
    }

    $upd = $pdo->prepare("UPDATE coupons SET code = ?, discount_type = ?, discount_value = ?, min_order_amount = ?, max_discount_amount = ?, usage_limit = ?, expires_at = ?, is_active = ? WHERE id = ?");
    $upd->execute([$code, $type, $val, $minOrd, $maxDisc, $limit, $expires, $isActive, $id]);
    jsonResponse(['success' => true, 'message' => "Coupon updated successfully!"]);
}

if ($action === 'delete_coupon') {
    $id = (int)($data['id'] ?? 0);
    $del = $pdo->prepare("DELETE FROM coupons WHERE id = ?");
    $del->execute([$id]);
    jsonResponse(['success' => true, 'message' => "Coupon deleted successfully!"]);
}

if ($action === 'toggle_coupon_status') {
    $id = (int)($data['id'] ?? 0);
    $stmt = $pdo->prepare("SELECT is_active FROM coupons WHERE id = ?");
    $stmt->execute([$id]);
    $cpn = $stmt->fetch();
    if (!$cpn) {
        jsonResponse(['success' => false, 'error' => 'Coupon not found'], 404);
    }
    $newStatus = $cpn['is_active'] ? 0 : 1;
    $upd = $pdo->prepare("UPDATE coupons SET is_active = ? WHERE id = ?");
    $upd->execute([$newStatus, $id]);
    jsonResponse(['success' => true, 'is_active' => $newStatus, 'message' => "Coupon status toggled"]);
}

// ==========================================
// 12. DOCTOR REVIEWS CRUD
// ==========================================
if ($action === 'get_doctor_reviews') {
    $stmt = $pdo->query("SELECT * FROM doctor_reviews ORDER BY display_order ASC, id ASC");
    jsonResponse(['success' => true, 'reviews' => $stmt->fetchAll()]);
}

if ($action === 'add_doctor_review') {
    $name = trim($data['doctor_name'] ?? '');
    $title = trim($data['doctor_title'] ?? '');
    $hospital = trim($data['hospital_name'] ?? '');
    $avatar = trim($data['avatar_url'] ?? 'https://knyamed.com/cdn/shop/files/456x500px-Dr-Mili-Dogra-Anesthesiology-Resident_ab4edce0-1b04-431e-b09f-678b766e87c7.jpg?v=1683281588&width=380');
    $rating = (int)($data['rating'] ?? 5);
    $worn = trim($data['product_worn'] ?? '');
    $text = trim($data['review_text'] ?? '');
    $badge = trim($data['badge_text'] ?? 'Verified Buyer');
    $tag = trim($data['highlight_tag'] ?? 'Verified Review');
    $order = (int)($data['display_order'] ?? 0);
    $isActive = isset($data['is_active']) ? (int)$data['is_active'] : 1;

    if (!$name || !$text) {
        jsonResponse(['success' => false, 'error' => 'Doctor name and review text are required'], 400);
    }

    $ins = $pdo->prepare("INSERT INTO doctor_reviews (doctor_name, doctor_title, hospital_name, avatar_url, rating, product_worn, review_text, badge_text, highlight_tag, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $ins->execute([$name, $title, $hospital, $avatar, $rating, $worn, $text, $badge, $tag, $order, $isActive]);
    jsonResponse(['success' => true, 'message' => "Review by $name added successfully!"]);
}

if ($action === 'update_doctor_review') {
    $id = (int)($data['id'] ?? 0);
    $name = trim($data['doctor_name'] ?? '');
    $title = trim($data['doctor_title'] ?? '');
    $hospital = trim($data['hospital_name'] ?? '');
    $avatar = trim($data['avatar_url'] ?? '');
    $rating = (int)($data['rating'] ?? 5);
    $worn = trim($data['product_worn'] ?? '');
    $text = trim($data['review_text'] ?? '');
    $badge = trim($data['badge_text'] ?? 'Verified Buyer');
    $tag = trim($data['highlight_tag'] ?? 'Verified Review');
    $order = (int)($data['display_order'] ?? 0);
    $isActive = isset($data['is_active']) ? (int)$data['is_active'] : 1;

    if ($id <= 0 || !$name || !$text) {
        jsonResponse(['success' => false, 'error' => 'Valid doctor review details required'], 400);
    }

    $upd = $pdo->prepare("UPDATE doctor_reviews SET doctor_name = ?, doctor_title = ?, hospital_name = ?, avatar_url = ?, rating = ?, product_worn = ?, review_text = ?, badge_text = ?, highlight_tag = ?, display_order = ?, is_active = ? WHERE id = ?");
    $upd->execute([$name, $title, $hospital, $avatar, $rating, $worn, $text, $badge, $tag, $order, $isActive, $id]);
    jsonResponse(['success' => true, 'message' => "Review updated successfully!"]);
}

if ($action === 'delete_doctor_review') {
    $id = (int)($data['id'] ?? 0);
    $del = $pdo->prepare("DELETE FROM doctor_reviews WHERE id = ?");
    $del->execute([$id]);
    jsonResponse(['success' => true, 'message' => "Review deleted successfully!"]);
}

// ==========================================
// 13. CUSTOMER DIRECTORY
// ==========================================
if ($action === 'get_customers') {
    // Gather customers from users and orders
    $sql = "
        SELECT 
            COALESCE(u.id, 0) as user_id,
            COALESCE(u.name, o.customer_name) as name,
            COALESCE(u.email, o.customer_email) as email,
            COALESCE(u.phone, o.customer_phone) as phone,
            COUNT(o.id) as total_orders,
            COALESCE(SUM(o.total), 0) as total_spent,
            MAX(o.created_at) as last_order_date
        FROM orders o
        LEFT JOIN users u ON u.email = o.customer_email
        GROUP BY COALESCE(u.email, o.customer_email)
        ORDER BY total_spent DESC
    ";
    $stmt = $pdo->query($sql);
    $customers = $stmt->fetchAll();
    jsonResponse(['success' => true, 'customers' => $customers]);
}

jsonResponse(['error' => 'Unknown action'], 400);

