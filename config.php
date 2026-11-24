<?php
/**
 * TRADE MEDS Configuration & Database Initialization
 */

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '0');

// Global defines
define('APP_NAME', 'TRADE MEDS');
define('APP_TAGLINE', 'Health Today... Better Tomorrow');

// Auto-detect base URL (works seamlessly in localhost /Trade-Meds or Hostinger root domain)
if (!defined('BASE_URL')) {
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    $baseUri = ($scriptDir === '/' || $scriptDir === '\\' || $scriptDir === '.' || $scriptDir === '') ? '' : rtrim($scriptDir, '/');
    $baseUri = preg_replace('#/(api|admin|includes)$#i', '', $baseUri);
    define('BASE_URL', $baseUri);
}

$isVercel = isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']);
define('DATA_DIR', __DIR__ . '/data');
define('SESSION_DIR', $isVercel ? '/tmp' : DATA_DIR . '/sessions');
define('UPLOADS_DIR', __DIR__ . '/uploads');

if ($isVercel && !file_exists('/tmp/trademeds.db') && file_exists(DATA_DIR . '/trademeds.db')) {
    @copy(DATA_DIR . '/trademeds.db', '/tmp/trademeds.db');
}
define('DB_FILE', ($isVercel && file_exists('/tmp/trademeds.db')) ? '/tmp/trademeds.db' : DATA_DIR . '/trademeds.db');

// Ensure data and session directories exist
if (!$isVercel) {
    if (!is_dir(DATA_DIR)) {
        @mkdir(DATA_DIR, 0755, true);
    }
    if (!is_dir(SESSION_DIR)) {
        @mkdir(SESSION_DIR, 0755, true);
    }
    if (!is_dir(UPLOADS_DIR)) {
        @mkdir(UPLOADS_DIR, 0755, true);
    }
}

// Set custom session save path
if (is_dir(SESSION_DIR) && is_writable(SESSION_DIR)) {
    @session_save_path(SESSION_DIR);
}

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    @session_start();
}

// Session Cart ID
if (!isset($_SESSION['session_token'])) {
    $_SESSION['session_token'] = bin2hex(random_bytes(16));
}
$sessionToken = $_SESSION['session_token'];

// Database configuration (Hostinger MySQL with automatic SQLite fallback)
define('DB_DRIVER', 'mysql'); // 'mysql' on Hostinger, falls back to 'sqlite' if offline or local
define('DB_HOST', 'localhost');
define('DB_NAME', 'u974680833_trademeds');
define('DB_USER', 'u974680833_trademeds');
define('DB_PASS', 'Trademeds@123');
define('DB_PORT', '3306');

/**
 * Return JSON response helper
 */
function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

/**
 * Get PDO Database Connection (Hostinger MySQL & SQLite Fallback)
 */
function getDB() {
    static $pdo = null;
    if ($pdo === null) {
        // 1. Try MySQL Connection first if configured
        if (defined('DB_DRIVER') && DB_DRIVER === 'mysql' && !empty(DB_NAME)) {
            try {
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';port=' . DB_PORT . ';charset=utf8mb4';
                $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (Throwable $e) {
                // If MySQL is unavailable (e.g. testing locally on XAMPP), seamlessly fallback to SQLite
                $pdo = null;
            }
        }

        // 2. Fallback to SQLite if MySQL is not available
        if ($pdo === null) {
            $pdo = new PDO('sqlite:' . DB_FILE);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }

        initSchema($pdo);
    }
    return $pdo;
}

/**
 * Initialize Tables & Seed Data
 */
function initSchema($pdo) {
    $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);

    // If using MySQL, check if products table exists; if not, import database.sql
    if ($driver === 'mysql') {
        try {
            $check = $pdo->query("SHOW TABLES LIKE 'products'")->fetch();
            if (!$check) {
                $sqlDump = __DIR__ . '/database.sql';
                if (file_exists($sqlDump)) {
                    $sqlContent = file_get_contents($sqlDump);
                    $pdo->exec($sqlContent);
                }
            }
        } catch (Throwable $e) {
            // Tables might already exist
        }
        return;
    }

    // SQLite Schema Initialization
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT UNIQUE,
            phone TEXT,
            password TEXT,
            is_verified INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS email_otps (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            email TEXT NOT NULL,
            otp_code TEXT NOT NULL,
            type TEXT DEFAULT 'login',
            expires_at DATETIME NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS admin_users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            email TEXT UNIQUE NOT NULL,
            password_hash TEXT NOT NULL,
            role TEXT DEFAULT 'admin',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS products (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            slug TEXT UNIQUE NOT NULL,
            category TEXT NOT NULL,
            collection TEXT NOT NULL,
            gender TEXT DEFAULT 'Unisex',
            price REAL NOT NULL,
            original_price REAL NOT NULL,
            discount TEXT,
            stock INTEGER DEFAULT 50,
            rating REAL DEFAULT 4.8,
            reviews_count INTEGER DEFAULT 120,
            badge TEXT,
            color_name TEXT,
            color_hex TEXT,
            color_family TEXT,
            primary_image TEXT NOT NULL,
            hover_image TEXT NOT NULL,
            images_json TEXT,
            sizes_json TEXT,
            swatches_json TEXT,
            description TEXT,
            fabric TEXT,
            pockets TEXT,
            status TEXT DEFAULT 'active',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS cart_items (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            session_token TEXT NOT NULL,
            user_id INTEGER NULL,
            product_id INTEGER NOT NULL,
            product_title TEXT NOT NULL,
            product_price REAL NOT NULL,
            product_image TEXT NOT NULL,
            size TEXT NOT NULL,
            color TEXT NOT NULL,
            color_hex TEXT,
            quantity INTEGER NOT NULL DEFAULT 1,
            embroidery TEXT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS wishlist (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            session_token TEXT NOT NULL,
            user_id INTEGER NULL,
            product_id INTEGER NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            UNIQUE(session_token, product_id)
        );

        CREATE TABLE IF NOT EXISTS orders (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            order_number TEXT UNIQUE NOT NULL,
            user_id INTEGER NULL,
            session_token TEXT NOT NULL,
            customer_name TEXT NOT NULL,
            customer_email TEXT NOT NULL,
            customer_phone TEXT NOT NULL,
            shipping_address TEXT NOT NULL,
            items_json TEXT NOT NULL,
            subtotal REAL NOT NULL,
            discount REAL NOT NULL DEFAULT 0,
            shipping_fee REAL NOT NULL DEFAULT 0,
            total REAL NOT NULL,
            payment_method TEXT DEFAULT 'COD',
            status TEXT DEFAULT 'Processing',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS newsletter (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            email TEXT UNIQUE NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS categories (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            slug TEXT UNIQUE NOT NULL,
            image TEXT,
            description TEXT,
            display_order INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS stock_history (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            product_id INTEGER NOT NULL,
            product_title TEXT,
            change_type TEXT,
            quantity_changed INTEGER,
            stock_before INTEGER,
            stock_after INTEGER,
            notes TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS customer_addresses (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            full_name TEXT NOT NULL,
            phone TEXT NOT NULL,
            address_line TEXT NOT NULL,
            city TEXT,
            state TEXT,
            postal_code TEXT,
            is_default INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS navigation_menus (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            url TEXT NOT NULL DEFAULT '#',
            parent_id INTEGER DEFAULT 0,
            menu_location TEXT DEFAULT 'header',
            badge TEXT DEFAULT '',
            target TEXT DEFAULT '_self',
            display_order INTEGER DEFAULT 0,
            is_active INTEGER DEFAULT 1,
            icon_svg TEXT DEFAULT '',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS coupons (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            code TEXT UNIQUE NOT NULL,
            discount_type TEXT DEFAULT 'percentage',
            discount_value REAL NOT NULL,
            min_order_amount REAL DEFAULT 0,
            max_discount_amount REAL DEFAULT 0,
            usage_limit INTEGER DEFAULT 0,
            times_used INTEGER DEFAULT 0,
            expires_at DATETIME NULL,
            is_active INTEGER DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS doctor_reviews (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            doctor_name TEXT NOT NULL,
            doctor_title TEXT NOT NULL,
            hospital_name TEXT NOT NULL,
            avatar_url TEXT NOT NULL,
            rating INTEGER DEFAULT 5,
            product_worn TEXT DEFAULT '',
            review_text TEXT NOT NULL,
            badge_text TEXT DEFAULT 'Verified Buyer',
            highlight_tag TEXT DEFAULT 'Verified Review',
            display_order INTEGER DEFAULT 0,
            is_active INTEGER DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
    ");

    // Add optional columns if missing
    try {
        $cols = $pdo->query("PRAGMA table_info(products)")->fetchAll(PDO::FETCH_COLUMN, 1);
        if (!in_array('sku', $cols)) {
            $pdo->exec("ALTER TABLE products ADD COLUMN sku TEXT DEFAULT ''");
        }
        if (!in_array('subcategory', $cols)) {
            $pdo->exec("ALTER TABLE products ADD COLUMN subcategory TEXT DEFAULT ''");
        }
        if (!in_array('brand', $cols)) {
            $pdo->exec("ALTER TABLE products ADD COLUMN brand TEXT DEFAULT 'TRADE MEDS'");
        }
        if (!in_array('sale_price', $cols)) {
            $pdo->exec("ALTER TABLE products ADD COLUMN sale_price REAL DEFAULT 0");
        }
    } catch (Exception $e) {}

    // Seed default categories if table is empty
    $catCount = $pdo->query("SELECT COUNT(*) as cnt FROM categories")->fetch()['cnt'];
    if ($catCount == 0) {
        $defaultCats = [
            ['Classic Scrubs', 'classic-scrubs', 'https://knyamed.com/cdn/shop/files/Women_s_Classic_Mandarin_collar_Scrub_Top_Dark_Green_-_1_-_Copy_11e25e83-7d7d-41a6-8e5e-63f5b7218698.jpg', 'Timeless clinical cuts, poly-viscose breathability, stain & fluid resistant.', 1],
            ['ecoflex™ Scrubs', 'ecoflex-scrubs', 'https://knyamed.com/cdn/shop/files/1_2521c811-0428-44fe-8f0a-7b56557cb09b.jpg', 'Ultra 4-way stretch, moisture wicking, antimicrobial odor control for long shifts.', 2],
            ['Lab Coats & Aprons', 'lab-coats', 'https://knyamed.com/cdn/shop/files/Lab_Coat_Men_Front.jpg', 'Consultant & Resident physician lab coats with tablet pockets and notch lapels.', 3],
            ['6sense Stethoscopes', 'stethoscopes', 'https://knyamed.com/cdn/shop/files/Black_Finish_1.jpg', 'High acoustic precision dual-head stethoscopes with stainless steel chestpiece.', 4],
            ['Medical Footwear & Clogs', 'footwear', 'https://knyamed.com/cdn/shop/files/1_a0ea7d0c-f376-4903-8868-dc1d9f485db4.jpg', 'Anti-slip orthopedic clinical footwear designed for 12+ hour surgical rounds.', 5],
            ['Scrub Jackets', 'jackets', 'https://knyamed.com/cdn/shop/files/1_abdaee06-d08b-4a55-bfa7-ff39c71987d3.jpg', 'Fleece-lined temperature regulation jackets for cold surgical theatres.', 6]
        ];
        $insCat = $pdo->prepare("INSERT INTO categories (name, slug, image, description, display_order) VALUES (?, ?, ?, ?, ?)");
        foreach ($defaultCats as $c) {
            $insCat->execute($c);
        }
    }

    // Seed default admin if none exists
    $adminCount = $pdo->query("SELECT COUNT(*) as cnt FROM admin_users")->fetch()['cnt'];
    if ($adminCount == 0) {
        $insAdmin = $pdo->prepare("INSERT INTO admin_users (username, email, password_hash, role) VALUES (?, ?, ?, ?)");
        $insAdmin->execute(['admin', 'admin@trademeds.com', password_hash('admin123', PASSWORD_DEFAULT), 'Super Admin']);
    }

    // Seed default demo doctor user if none exists
    $demoDocCount = $pdo->query("SELECT COUNT(*) as cnt FROM users WHERE email = 'doctor@hospital.com'")->fetch()['cnt'];
    if ($demoDocCount == 0) {
        $insUser = $pdo->prepare("INSERT INTO users (name, email, phone, password, created_at) VALUES (?, ?, ?, ?, datetime('now'))");
        $insUser->execute(['Dr. Aravind Swaminathan', 'doctor@hospital.com', '+91 98765 43210', password_hash('doctor123', PASSWORD_DEFAULT)]);
    }

    // Seed products table from data/products.json if table is empty
    $prodCount = $pdo->query("SELECT COUNT(*) as cnt FROM products")->fetch()['cnt'];
    $jsonFile = DATA_DIR . '/products.json';
    if ($prodCount == 0 && file_exists($jsonFile)) {
        $jsonProds = json_decode(file_get_contents($jsonFile), true);
        if ($jsonProds) {
            $ins = $pdo->prepare("
                INSERT INTO products (
                    id, title, slug, category, collection, gender, price, original_price, discount, stock,
                    rating, reviews_count, badge, color_name, color_hex, color_family, primary_image, hover_image,
                    images_json, sizes_json, swatches_json, description, fabric, pockets, status
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                    ?, ?, ?, ?, ?, ?, ?, ?,
                    ?, ?, ?, ?, ?, ?, 'active'
                )
            ");
            foreach ($jsonProds as $p) {
                $ins->execute([
                    $p['id'],
                    $p['title'],
                    $p['slug'] ?? 'prod-' . $p['id'],
                    $p['category'],
                    $p['collection'],
                    $p['gender'] ?? 'Unisex',
                    $p['price'],
                    $p['originalPrice'],
                    $p['discount'] ?? '30% OFF',
                    rand(25, 120),
                    $p['rating'] ?? 4.8,
                    $p['reviews'] ?? 450,
                    $p['badge'] ?? '',
                    $p['colorName'] ?? 'Navy Blue',
                    $p['colorHex'] ?? '#1c2447',
                    $p['colorFamily'] ?? 'All Blues',
                    $p['primaryImage'],
                    $p['hoverImage'],
                    json_encode($p['images'] ?? [$p['primaryImage']]),
                    json_encode($p['sizes'] ?? ['XS','S','M','L','XL','2XL']),
                    json_encode($p['swatches'] ?? []),
                    $p['description'] ?? '',
                    $p['fabric'] ?? '',
                    $p['pockets'] ?? ''
                ]);
            }
        }
    }

    // Seed dummy demo orders if orders table is empty
    $orderCount = $pdo->query("SELECT COUNT(*) as cnt FROM orders")->fetch()['cnt'];
    if ($orderCount == 0) {
        $sampleItems1 = [
            [
                'product_title' => "Classic Women's V-Neck (Navy) Scrub",
                'product_price' => 1099,
                'quantity' => 2,
                'size' => 'M',
                'color' => 'Navy Blue',
                'embroidery' => 'Dr. Riya Sen (Anesthesiology)'
            ]
        ];
        $sampleItems2 = [
            [
                'product_title' => "6sense (Black), All Black Finish Stethoscope",
                'product_price' => 2599,
                'quantity' => 1,
                'size' => 'Standard Adult',
                'color' => 'Matte Black'
            ],
            [
                'product_title' => "TRADE MEDS Pro Comfort Medical Clogs",
                'product_price' => 1999,
                'quantity' => 1,
                'size' => 'UK 8',
                'color' => 'Midnight Navy'
            ]
        ];

        $insOrd = $pdo->prepare("
            INSERT INTO orders (order_number, session_token, customer_name, customer_email, customer_phone, shipping_address, items_json, subtotal, discount, shipping_fee, total, payment_method, status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, datetime('now', '-2 days'))
        ");
        $insOrd->execute([
            'TM-2026-8910', 'demo-session-1', 'Dr. Riya Sen', 'riya.sen@apollo.com', '+91 98401 23456',
            'Apollo Speciality Hospitals, Greams Road, Thousand Lights, Chennai - 600006',
            json_encode($sampleItems1), 2198, 263.76, 0, 1934.24, 'UPI', 'Delivered'
        ]);

        $insOrd2 = $pdo->prepare("
            INSERT INTO orders (order_number, session_token, customer_name, customer_email, customer_phone, shipping_address, items_json, subtotal, discount, shipping_fee, total, payment_method, status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, datetime('now', '-3 hours'))
        ");
        $insOrd2->execute([
            'TM-2026-9432', 'demo-session-2', 'Dr. Karthik Ramanathan', 'karthik.ortho@aiims.edu', '+91 99402 87654',
            'Resident Quarters, AIIMS Hospital, New Delhi - 110029',
            json_encode($sampleItems2), 4598, 551.76, 0, 4046.24, 'COD', 'Processing'
        ]);
    }

    // Seed default navigation menus if table is empty
    $menuCount = $pdo->query("SELECT COUNT(*) as cnt FROM navigation_menus")->fetch()['cnt'];
    if ($menuCount == 0) {
        $defaultMenus = [
            ['Women', '#classic-scrubs-section', 0, 'header', 'POPULAR', '_self', 1],
            ['Men', '#classic-scrubs-section', 0, 'header', '', '_self', 2],
            ['ecoflex™', '#ecoflex-section', 0, 'header', 'STRETCH', '_self', 3],
            ['6sense', '#stethoscope-section', 0, 'header', 'NEW', '_self', 4],
            ['Footwear', 'javascript:void(0)" onclick="window.TM.openQuickView(16)', 0, 'header', '', '_self', 5],
            ['Lab Coats', '#lab-coats-section', 0, 'header', 'ESSENTIAL', '_self', 6],
            ['Bulk Order', '#bulk-banner', 0, 'header', 'SAVE 25%', '_self', 7],
            ['Track Order', 'javascript:void(0)" onclick="window.TM.promptTrackOrder()', 0, 'header', '', '_self', 8],
            // Footer menus
            ['Our Story', '#about-us', 0, 'footer_company', '', '_self', 1],
            ['Custom Doctor Embroidery', '#bulk-banner', 0, 'footer_company', 'HOT', '_self', 2],
            ['Hospital Group Orders', '#bulk-banner', 0, 'footer_company', '', '_self', 3],
            ['Size & Fit Guide', 'javascript:void(0)" onclick="window.TM.openSizeChart()', 0, 'footer_quick_links', '', '_self', 1],
            ['Returns & Exchanges', '#policy', 0, 'footer_quick_links', '', '_self', 2],
            ['Wash & Autoclave Care', '#care', 0, 'footer_quick_links', '', '_self', 3]
        ];
        $insMenu = $pdo->prepare("INSERT INTO navigation_menus (title, url, parent_id, menu_location, badge, target, display_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
        foreach ($defaultMenus as $m) {
            $insMenu->execute($m);
        }
    }

    // Seed default coupons if table is empty
    $couponCount = $pdo->query("SELECT COUNT(*) as cnt FROM coupons")->fetch()['cnt'];
    if ($couponCount == 0) {
        $defaultCoupons = [
            ['DOCTOR10', 'percentage', 10, 1499, 500, 1000, 34, null, 1],
            ['WELCOME200', 'fixed', 200, 1999, 0, 500, 89, null, 1],
            ['SURGEON15', 'percentage', 15, 2999, 800, 250, 12, null, 1],
            ['FREESHIP', 'fixed', 99, 999, 0, 0, 145, null, 1]
        ];
        $insCpn = $pdo->prepare("INSERT INTO coupons (code, discount_type, discount_value, min_order_amount, max_discount_amount, usage_limit, times_used, expires_at, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($defaultCoupons as $cpn) {
            $insCpn->execute($cpn);
        }
    }

    // Seed default doctor reviews if table is empty
    $revCount = $pdo->query("SELECT COUNT(*) as cnt FROM doctor_reviews")->fetch()['cnt'];
    if ($revCount == 0) {
        $defaultReviews = [
            [
                'Dr. Mili Dogra',
                'Anesthesiology Resident',
                'AIIMS Hospital, New Delhi',
                'https://knyamed.com/cdn/shop/files/456x500px-Dr-Mili-Dogra-Anesthesiology-Resident_ab4edce0-1b04-431e-b09f-678b766e87c7.jpg?v=1683281588&width=380',
                5,
                'Wears: ecoflex™ Scrub Suit (Navy Blue)',
                'The ecoflex™ scrubs are a game changer for 14-hour orthopedic surgery shifts. Zero tightness at the shoulders, and the fabric doesn\'t absorb hospital smells or fluids even after marathon OT sessions.',
                'Verified Buyer',
                '4-Way Stretch Tech',
                1
            ],
            [
                'Dr. Prateek Makwana',
                'Fertility & Embryology Specialist',
                'Vasundhara IVF, Mumbai',
                'https://knyamed.com/cdn/shop/files/250x250px-Dr-Prateek-Makwana-Fertility-Specialist_a197c02e-7b83-4940-9671-8086c30a1ba4.jpg?v=1683282037&width=200',
                5,
                'Uses: 6sense Precision Stethoscope (Matte Black)',
                'I ordered the 6sense Stethoscope in All-Black finish. The acoustic amplification is astonishingly sharp, easily on par with international brands costing three times more. A true clinical masterpiece.',
                'Verified Buyer',
                'Acoustic Clarity',
                2
            ],
            [
                'Dr. Shivani Agarwal',
                'OBGYN Resident',
                'Apollo Speciality Hospitals, Kolkata',
                'https://knyamed.com/cdn/shop/files/250x250px-Dr-Shivani-Agarwal-OBGYN-Resident_b2b80249-328c-4def-8586-69e27aea3814.jpg?v=1683282037&width=200',
                5,
                'Wears: Classic Women\'s Scrub Suit (Wine Red) + Embroidery',
                'Our entire OBGYN department ordered matching wine-red scrubs with custom doctor embroidery. The fabric withstands commercial autoclave washing without fading or shrinking. Five stars!',
                'Verified Buyer',
                'Autoclave-Safe',
                3
            ]
        ];
        $insRev = $pdo->prepare("INSERT INTO doctor_reviews (doctor_name, doctor_title, hospital_name, avatar_url, rating, product_worn, review_text, badge_text, highlight_tag, display_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($defaultReviews as $rev) {
            $insRev->execute($rev);
        }
    }
}

/**
 * Send Email OTP (via PHP mail() + simulated logger for XAMPP)
 */
function sendEmailOTP($email, $type = 'login') {
    $pdo = getDB();
    $otp = sprintf("%06d", mt_rand(100000, 999999));
    $expiresAt = date('Y-m-d H:i:s', time() + 900);

    // Invalidate old OTPs for this email regardless of type
    $del = $pdo->prepare("DELETE FROM email_otps WHERE email = ?");
    $del->execute([$email]);

    // Insert new OTP
    $ins = $pdo->prepare("INSERT INTO email_otps (email, otp_code, type, expires_at, created_at) VALUES (?, ?, ?, ?, datetime('now'))");
    $ins->execute([$email, $otp, $type, $expiresAt]);

    // Send real email if mail() server configured
    $subject = "Your TRADE MEDS Verification OTP: $otp";
    $message = "Dear Healthcare Hero,\n\nYour 6-digit verification code for TRADE MEDS is: $otp\n\nThis OTP is valid for 15 minutes. Please do not share this OTP with anyone.\n\nWarm regards,\nTeam TRADE MEDS\nHealth Today... Better Tomorrow";
    $headers = "From: no-reply@trademeds.com\r\nReply-To: support@trademeds.com\r\nX-Mailer: PHP/" . phpversion();

    @mail($email, $subject, $message, $headers);

    // Also store in session so frontend can display simulated medical inbox alert in XAMPP
    $_SESSION['latest_otp'] = [
        'email' => $email,
        'otp' => $otp,
        'type' => $type,
        'time' => date('h:i A')
    ];

    return $otp;
}
