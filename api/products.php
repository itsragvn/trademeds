<?php
require_once __DIR__ . '/../config.php';

$pdo = getDB();

// Handle Single Product Lookup
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $p = $stmt->fetch();
    if ($p) {
        $p['images'] = json_decode($p['images_json'] ?: '[]', true);
        $p['sizes'] = json_decode($p['sizes_json'] ?: '[]', true);
        $p['swatches'] = json_decode($p['swatches_json'] ?: '[]', true);
        $p['price'] = (float)$p['price'];
        $p['originalPrice'] = (float)$p['original_price'];
        $p['stock'] = (int)$p['stock'];
        $p['primaryImage'] = $p['primary_image'];
        $p['hoverImage'] = $p['hover_image'];
        $p['colorName'] = $p['color_name'];
        $p['colorHex'] = $p['color_hex'];
        $p['colorFamily'] = $p['color_family'];
        jsonResponse(['success' => true, 'product' => $p]);
    } else {
        jsonResponse(['error' => 'Product not found'], 404);
    }
}

// Search and Filters
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$gender = isset($_GET['gender']) ? trim($_GET['gender']) : '';
$colorFamily = isset($_GET['color']) ? trim($_GET['color']) : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort = isset($_GET['sort']) ? trim($_GET['sort']) : '';

$sql = "SELECT * FROM products WHERE status = 'active'";
$params = [];

if ($category) {
    $sql .= " AND (category LIKE ? OR collection LIKE ?)";
    $params[] = "%$category%";
    $params[] = "%$category%";
}
if ($gender) {
    $sql .= " AND (gender = ? OR gender = 'Unisex')";
    $params[] = $gender;
}
if ($colorFamily) {
    $sql .= " AND color_family = ?";
    $params[] = $colorFamily;
}
if ($search) {
    $sql .= " AND (title LIKE ? OR category LIKE ? OR color_name LIKE ? OR description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

// Sorting
if ($sort === 'price_asc') {
    $sql .= " ORDER BY price ASC";
} elseif ($sort === 'price_desc') {
    $sql .= " ORDER BY price DESC";
} elseif ($sort === 'rating') {
    $sql .= " ORDER BY rating DESC";
} elseif ($sort === 'popular') {
    $sql .= " ORDER BY reviews_count DESC";
} else {
    $sql .= " ORDER BY id ASC";
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();

$formatted = [];
foreach ($rows as $p) {
    $p['images'] = json_decode($p['images_json'] ?: '[]', true);
    $p['sizes'] = json_decode($p['sizes_json'] ?: '[]', true);
    $p['swatches'] = json_decode($p['swatches_json'] ?: '[]', true);
    $p['price'] = (float)$p['price'];
    $p['originalPrice'] = (float)$p['original_price'];
    $p['stock'] = (int)$p['stock'];
    $p['primaryImage'] = $p['primary_image'];
    $p['hoverImage'] = $p['hover_image'];
    $p['colorName'] = $p['color_name'];
    $p['colorHex'] = $p['color_hex'];
    $p['colorFamily'] = $p['color_family'];
    $formatted[] = $p;
}

jsonResponse([
    'success' => true,
    'count' => count($formatted),
    'products' => $formatted
]);
