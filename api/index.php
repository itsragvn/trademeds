<?php
/**
 * Vercel Serverless Router for Trade Meds
 */
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$path = trim($uri, '/');

// 1. Root & Home Page
if ($path === '' || $path === 'index.php') {
    require_once __DIR__ . '/../index.php';
    exit;
}

// 2. Category Page
if ($path === 'category.php') {
    require_once __DIR__ . '/../category.php';
    exit;
}

// 3. Product Page
if ($path === 'product.php') {
    require_once __DIR__ . '/../product.php';
    exit;
}

// 4. Admin Panel Pages
if (strpos($path, 'admin') === 0) {
    if ($path === 'admin' || $path === 'admin/' || $path === 'admin/index.php') {
        require_once __DIR__ . '/../admin/index.php';
        exit;
    }
    if ($path === 'admin/login.php') {
        require_once __DIR__ . '/../admin/login.php';
        exit;
    }
    if ($path === 'admin/logout.php') {
        require_once __DIR__ . '/../admin/logout.php';
        exit;
    }
    if ($path === 'admin/api.php') {
        require_once __DIR__ . '/../admin/api.php';
        exit;
    }
}

// 5. Check if requested PHP file exists
$candidate = realpath(__DIR__ . '/../' . $path);
if ($candidate && file_exists($candidate) && is_file($candidate) && substr($candidate, -4) === '.php') {
    require_once $candidate;
    exit;
}

// Default to Home
require_once __DIR__ . '/../index.php';
