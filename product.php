<?php
require_once __DIR__ . '/config.php';
$pdo = getDB();

// Determine product by ID or Slug
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$productSlug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

$p = null;
if ($productId > 0) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $p = $stmt->fetch();
} elseif (!empty($productSlug)) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE slug = ?");
    $stmt->execute([$productSlug]);
    $p = $stmt->fetch();
}

// Fallback to first product if not found
if (!$p) {
    $p = $pdo->query("SELECT * FROM products ORDER BY id ASC LIMIT 1")->fetch();
}

// Decode JSON fields
$images = json_decode($p['images_json'] ?: '[]', true);
if (empty($images)) {
    $images = array_filter([$p['primary_image'], $p['hover_image']]);
}
if (empty($images)) {
    $images = ['images/products/classic-womens-wine.jpg'];
}

$sizes = json_decode($p['sizes_json'] ?: '[]', true);
if (empty($sizes)) {
    $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL'];
}

$swatches = json_decode($p['swatches_json'] ?: '[]', true);
if (empty($swatches)) {
    $swatches = [
        ['name' => $p['color_name'] ?: 'Navy Blue', 'hex' => $p['color_hex'] ?: '#1c2447']
    ];
}

// Fetch Verified Reviews for this product
$reviewsStmt = $pdo->prepare("SELECT * FROM doctor_reviews WHERE is_active = 1 ORDER BY id DESC LIMIT 6");
$reviewsStmt->execute();
$doctorReviews = $reviewsStmt->fetchAll();

// Fetch Related Products (same category or collection)
$relatedStmt = $pdo->prepare("SELECT * FROM products WHERE id != ? AND (category = ? OR collection = ?) LIMIT 4");
$relatedStmt->execute([$p['id'], $p['category'], $p['collection']]);
$relatedProducts = $relatedStmt->fetchAll();
if (empty($relatedProducts)) {
    $relatedStmt = $pdo->prepare("SELECT * FROM products WHERE id != ? ORDER BY id ASC LIMIT 4");
    $relatedStmt->execute([$p['id']]);
    $relatedProducts = $relatedStmt->fetchAll();
}

$pageTitle = "{$p['title']} – Buy Online | TRADE MEDS";
$pageDesc = "{$p['title']} – Engineered for healthcare heroes. " . strip_tags($p['description']);

require_once __DIR__ . '/includes/header.php';
?>

<main class="site-main">
  <div class="pdp-container">
    <!-- Breadcrumb Navigation -->
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <a href="index.php">Home</a>
      <span class="breadcrumb-separator">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
      </span>
      <a href="category.php?cat=<?= urlencode($p['category']) ?>"><?= htmlspecialchars($p['category']) ?></a>
      <?php if (!empty($p['gender']) && $p['gender'] !== 'Unisex'): ?>
        <span class="breadcrumb-separator">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </span>
        <a href="category.php?gender=<?= urlencode($p['gender']) ?>"><?= htmlspecialchars($p['gender']) ?></a>
      <?php endif; ?>
      <span class="breadcrumb-separator">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
      </span>
      <span class="breadcrumb-current"><?= htmlspecialchars($p['title']) ?></span>
    </nav>

    <!-- Main Product Detail Grid -->
    <div class="pdp-grid">
      <!-- Left: Interactive Gallery -->
      <div class="pdp-gallery-wrap">
        <div class="pdp-thumb-list">
          <?php foreach ($images as $idx => $imgUrl): ?>
            <div class="pdp-thumb-item <?= $idx === 0 ? 'active' : '' ?>" onclick="window.TM.switchPdpImage('<?= htmlspecialchars($imgUrl) ?>', this)">
              <img src="<?= htmlspecialchars($imgUrl) ?>" alt="<?= htmlspecialchars($p['title']) ?> thumbnail <?= $idx + 1 ?>">
            </div>
          <?php endforeach; ?>
        </div>

        <div class="pdp-main-image-box">
          <img id="pdp-main-img" src="<?= htmlspecialchars($images[0]) ?>" alt="<?= htmlspecialchars($p['title']) ?>" onerror="this.onerror=null; this.src='https://knyamed.com/cdn/shop/files/1_70.jpg?v=1739900854&width=832';">
        </div>
      </div>

      <!-- Right: Buying Details & Personalization -->
      <div class="pdp-info-wrap">
        <div class="pdp-brand-tag">TRADE MEDS CLINICAL • <?= htmlspecialchars($p['collection'] ?: 'PROFESSIONAL') ?></div>
        <h1 class="pdp-title"><?= htmlspecialchars($p['title']) ?></h1>

        <!-- Doctor Rating -->
        <div class="pdp-rating-row">
          <div class="pdp-stars">
            <?php for ($s = 1; $s <= 5; $s++): ?>
              <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            <?php endfor; ?>
          </div>
          <span style="font-weight:700;color:var(--tm-primary);"><?= number_format($p['rating'] ?: 4.8, 1) ?></span>
          <span class="pdp-review-count">(<?= number_format($p['reviews_count'] ?: 1248) ?> Verified Doctor Reviews)</span>
        </div>

        <!-- Pricing Block -->
        <div class="pdp-price-box">
          <span class="pdp-sale-price">₹<?= number_format($p['price']) ?></span>
          <?php if ($p['original_price'] > $p['price']): ?>
            <span class="pdp-mrp-price">₹<?= number_format($p['original_price']) ?></span>
            <span class="pdp-discount-pill"><?= htmlspecialchars($p['discount'] ?: round((($p['original_price'] - $p['price']) / $p['original_price']) * 100) . '% OFF') ?></span>
          <?php endif; ?>
          <span class="pdp-tax-note">Inclusive of all taxes</span>
        </div>

        <!-- Color Selection -->
        <div style="margin-bottom:1.5rem;">
          <div class="pdp-section-label">
            <span>Color: <strong id="pdp-selected-color-name" style="color:var(--tm-accent-blue);"><?= htmlspecialchars($p['color_name'] ?: 'Navy Blue') ?></strong></span>
            <span style="font-size:0.75rem;color:var(--tm-text-secondary);"><?= count($swatches) ?> Shades Available</span>
          </div>
          <div class="pdp-swatches-grid">
            <?php foreach ($swatches as $idx => $sw): ?>
              <div class="pdp-swatch-dot <?= $idx === 0 ? 'active' : '' ?>" 
                   style="background-color: <?= htmlspecialchars($sw['hex']) ?>;" 
                   title="<?= htmlspecialchars($sw['name']) ?>"
                   onclick="window.TM.selectPdpColor('<?= htmlspecialchars($sw['name']) ?>', '<?= htmlspecialchars($sw['hex']) ?>', this)">
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Size Selection -->
        <div style="margin-bottom:1.5rem;">
          <div class="pdp-section-label">
            <span>Select Size: <strong id="pdp-selected-size-name" style="color:var(--tm-primary);">M</strong></span>
            <button type="button" class="pdp-size-guide-btn" onclick="window.TM.openSizeChart()">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.3 8.7l-6-6a1 1 0 0 0-1.4 0l-11 11a1 1 0 0 0 0 1.4l6 6a1 1 0 0 0 1.4 0l11-11a1 1 0 0 0 0-1.4z"></path></svg>
              Size &amp; Fit Guide
            </button>
          </div>
          <div class="pdp-sizes-grid">
            <?php foreach ($sizes as $idx => $sz): ?>
              <button type="button" class="pdp-size-chip <?= $sz === 'M' || ($idx === 0 && !in_array('M', $sizes)) ? 'active' : '' ?>" 
                      onclick="window.TM.selectPdpSize('<?= htmlspecialchars($sz) ?>', this)">
                <?= htmlspecialchars($sz) ?>
              </button>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Custom Doctor Embroidery Personalization -->
        <div class="pdp-embroidery-card">
          <div class="pdp-embroidery-header" onclick="window.TM.togglePdpEmbroidery()">
            <div style="display:flex;align-items:center;gap:10px;">
              <div style="width:34px;height:34px;border-radius:50%;background:#e0f2fe;color:#0284c7;display:flex;align-items:center;justify-content:center;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
              </div>
              <div>
                <span style="font-weight:800;color:var(--tm-primary);font-size:0.875rem;">Custom Doctor Name Embroidery (+₹150)</span>
                <p style="font-size:0.75rem;color:var(--tm-text-secondary);margin:0;">Precision monogramming on chest pocket with hospital-grade silk thread.</p>
              </div>
            </div>
            <span style="font-size:0.8125rem;font-weight:700;color:var(--tm-accent-blue);" id="pdp-emb-toggle-lbl">+ Personalize</span>
          </div>

          <div id="pdp-embroidery-body" class="pdp-embroidery-body" style="display:none;">
            <div>
              <label style="display:block;font-size:0.8125rem;font-weight:700;color:var(--tm-primary);margin-bottom:0.35rem;">Doctor Name / Credentials</label>
              <input type="text" id="pdp-emb-name" class="checkout-input" placeholder="e.g. Dr. Aravind Swaminathan, MD" maxlength="28" style="height:42px;">
            </div>
            <div>
              <label style="display:block;font-size:0.8125rem;font-weight:700;color:var(--tm-primary);margin-bottom:0.35rem;">Hospital / Department (Line 2 - Optional)</label>
              <input type="text" id="pdp-emb-dept" class="checkout-input" placeholder="e.g. Dept of Cardiology" maxlength="28" style="height:42px;">
            </div>
          </div>
        </div>

        <!-- Quantity & Buying CTAs -->
        <div class="pdp-action-row">
          <div class="pdp-qty-stepper">
            <button type="button" class="pdp-qty-btn" onclick="window.TM.updatePdpQty(-1)">−</button>
            <span class="pdp-qty-val" id="pdp-qty-val">1</span>
            <button type="button" class="pdp-qty-btn" onclick="window.TM.updatePdpQty(1)">+</button>
          </div>

          <!-- Add to Bag -->
          <button type="button" class="pdp-btn-add" onclick="window.TM.addPdpToBag(<?= $p['id'] ?>)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
            <span>Add to Bag</span>
          </button>

          <!-- Order Now / Direct Checkout -->
          <button type="button" class="pdp-btn-buy" onclick="window.TM.buyPdpNow(<?= $p['id'] ?>)">
            <span>Order Now • ₹<?= number_format($p['price']) ?></span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
          </button>
        </div>

        <!-- Pincode Delivery SLA Checker -->
        <div class="pdp-pincode-card">
          <div style="display:flex;align-items:center;gap:8px;font-size:0.875rem;font-weight:700;color:var(--tm-primary);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
            <span>Check Estimated Delivery Date</span>
          </div>
          <div class="pdp-pincode-input-row">
            <input type="text" id="pdp-pincode-input" class="checkout-input" placeholder="Enter 6-Digit PIN Code" maxlength="6" style="height:40px;font-size:0.875rem;">
            <button type="button" class="btn-secondary" style="height:40px;padding:0 16px;font-weight:700;" onclick="window.TM.checkPdpPincode()">Check</button>
          </div>
          <div id="pdp-pincode-result" style="font-size:0.8125rem;margin-top:0.5rem;display:none;"></div>
        </div>

        <!-- 4-Card Trust Matrix -->
        <div class="pdp-trust-grid">
          <div class="pdp-trust-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
            <span>Fluid-Barrier Shield</span>
          </div>
          <div class="pdp-trust-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>4-Way Mobility Stretch</span>
          </div>
          <div class="pdp-trust-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon></svg>
            <span>100+ Autoclave Washes</span>
          </div>
          <div class="pdp-trust-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
            <span>7-Day Free Size Swap</span>
          </div>
        </div>

        <!-- Specifications & Medical Details Accordions -->
        <div class="pdp-accordion-box">
          <!-- Accordion 1: Description -->
          <div class="pdp-accordion-item">
            <div class="pdp-accordion-header" onclick="this.nextElementSibling.classList.toggle('hidden')">
              <span>Description &amp; Clinical Tailoring</span>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="pdp-accordion-content">
              <?= nl2br(htmlspecialchars($p['description'] ?: 'Engineered specifically for Indian healthcare heroes. Designed with high-density poly-viscose blend, anti-fade reactive dyes, and reinforced triple-needle stitching across high-stress mobility seams.')) ?>
            </div>
          </div>

          <!-- Accordion 2: Fabric & Care -->
          <div class="pdp-accordion-item">
            <div class="pdp-accordion-header" onclick="this.nextElementSibling.classList.toggle('hidden')">
              <span>Fabric Composition &amp; Autoclave Care</span>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="pdp-accordion-content hidden">
              <p><strong>Fabric:</strong> <?= htmlspecialchars($p['fabric'] ?: '65% Poly, 35% Viscose with Fluid-Repellent Coating') ?></p>
              <p><strong>Care Instructions:</strong> Machine wash cold at 40°C or commercial hospital autoclave without chlorine bleach. Line dry or tumble dry low. Wrinkle-resistant finish requires zero ironing.</p>
            </div>
          </div>

          <!-- Accordion 3: Pocket Configuration -->
          <div class="pdp-accordion-item">
            <div class="pdp-accordion-header" onclick="this.nextElementSibling.classList.toggle('hidden')">
              <span>Pocket Configuration &amp; Ergonomics</span>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="pdp-accordion-content hidden">
              <p><?= htmlspecialchars($p['pockets'] ?: 'Equipped with 3 deep utility pockets: 1 chest pocket with dedicated medical pen slot, plus 2 spacious front slash pockets capable of holding stethoscope, pulse oximeter, and phone.') ?></p>
            </div>
          </div>

          <!-- Accordion 4: Shipping & Exchange -->
          <div class="pdp-accordion-item">
            <div class="pdp-accordion-header" onclick="this.nextElementSibling.classList.toggle('hidden')">
              <span>Shipping &amp; 7-Day Doorstep Exchange</span>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="pdp-accordion-content hidden">
              <p>• <strong>Free Delivery:</strong> All orders above ₹1,499 qualify for Free Expedited Shipping pan-India.</p>
              <p>• <strong>COD Available:</strong> Cash on Delivery available across 19,000+ Indian postal codes.</p>
              <p>• <strong>7-Day Size Exchange:</strong> Seamless 1-click reverse pickup for any size adjustment.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Verified Doctor Reviews Section -->
    <section style="margin-top:4rem;padding-top:3rem;border-top:1.5px solid var(--tm-border-light);">
      <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:2rem;flex-wrap:wrap;gap:1rem;">
        <div>
          <h3 style="font-size:1.75rem;font-weight:800;color:var(--tm-primary);margin:0 0 0.5rem 0;">Verified Healthcare Professional Reviews</h3>
          <p style="font-size:0.875rem;color:var(--tm-text-secondary);margin:0;">Real feedback from doctors, surgeons, residents, and nurses across India.</p>
        </div>
        <div style="display:flex;align-items:center;gap:12px;">
          <div style="text-align:right;">
            <div style="font-size:1.5rem;font-weight:800;color:var(--tm-primary);"><?= number_format($p['rating'] ?: 4.8, 1) ?> / 5.0</div>
            <div style="font-size:0.75rem;color:var(--tm-text-secondary);"><?= number_format($p['reviews_count'] ?: 1248) ?> Ratings</div>
          </div>
        </div>
      </div>

      <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));gap:1.5rem;">
        <?php foreach ($doctorReviews as $rev): ?>
          <div style="background:#fff;border:1.5px solid var(--tm-border-light);border-radius:12px;padding:1.5rem;display:flex;flex-direction:column;justify-content:space-between;">
            <div>
              <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.75rem;">
                <div style="display:flex;color:#f59e0b;gap:2px;">
                  <?php for ($s = 1; $s <= ($rev['rating'] ?: 5); $s++): ?>
                    <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                  <?php endfor; ?>
                </div>
                <span style="font-size:0.75rem;font-weight:700;color:#059669;background:#dcfce7;padding:2px 8px;border-radius:12px;display:inline-flex;align-items:center;gap:4px;">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Verified Buyer
                </span>
              </div>
              <p style="font-size:0.875rem;color:var(--tm-primary);line-height:1.55;font-style:italic;margin-bottom:1rem;">
                "<?= htmlspecialchars($rev['review_text']) ?>"
              </p>
            </div>
            <div style="border-top:1px solid var(--tm-border-light);padding-top:0.75rem;">
              <strong style="display:block;font-size:0.875rem;color:var(--tm-primary);"><?= htmlspecialchars($rev['doctor_name']) ?></strong>
              <span style="font-size:0.75rem;color:var(--tm-text-secondary);"><?= htmlspecialchars(($rev['doctor_title'] ?: 'Medical Professional') . ' • ' . ($rev['hospital_name'] ?: 'Apollo Hospitals')) ?></span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- Related Products: "Complete The Look" -->
    <section style="margin-top:4rem;padding-top:3rem;border-top:1.5px solid var(--tm-border-light);">
      <div style="text-align:center;margin-bottom:2.5rem;">
        <h3 style="font-size:1.85rem;font-weight:800;color:var(--tm-primary);margin:0 0 0.5rem 0;">You May Also Like</h3>
        <p style="font-size:0.9375rem;color:var(--tm-text-secondary);margin:0;">Complementary medical apparel engineered with the same peak performance standard.</p>
      </div>

      <div class="product-grid" style="display:grid;grid-template-columns:repeat(4, 1fr);gap:1.75rem;width:100%;">
        <?php foreach ($relatedProducts as $rel): ?>
          <div class="product-card">
            <div class="card-media-box">
              <a href="product.php?id=<?= $rel['id'] ?>" style="display:block;width:100%;height:100%;">
                <img src="<?= htmlspecialchars($rel['primary_image']) ?>" class="card-img-primary" alt="<?= htmlspecialchars($rel['title']) ?>" loading="lazy" onerror="this.onerror=null; this.src='https://knyamed.com/cdn/shop/files/1_70.jpg?v=1739900854&width=832';">
                <img src="<?= htmlspecialchars($rel['hover_image'] ?: $rel['primary_image']) ?>" class="card-img-hover" alt="<?= htmlspecialchars($rel['title']) ?>" loading="lazy" onerror="this.onerror=null; this.src='https://knyamed.com/cdn/shop/files/1_67.jpg?v=1739900771&width=832';">
              </a>
              <button type="button" class="card-wishlist-btn" onclick="window.TM.toggleWishlist(<?= $rel['id'] ?>)" title="Wishlist">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
              </button>
              <button type="button" class="card-quickview-btn" onclick="window.TM.openQuickView(<?= $rel['id'] ?>)">Quick View</button>
            </div>
            <div class="card-details">
              <div class="card-rating-row">
                <svg class="star-icon" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <span class="rating-value"><?= number_format($rel['rating'] ?: 4.8, 1) ?></span>
                <span>(<?= number_format($rel['reviews_count'] ?: 340) ?>)</span>
              </div>
              <a href="product.php?id=<?= $rel['id'] ?>" class="card-title"><?= htmlspecialchars($rel['title']) ?></a>
              <div class="card-price-row">
                <span class="sale-price">₹<?= number_format($rel['price']) ?></span>
                <?php if ($rel['original_price'] > $rel['price']): ?>
                  <span class="mrp-price">₹<?= number_format($rel['original_price']) ?></span>
                  <span class="discount-badge"><?= htmlspecialchars($rel['discount'] ?: 'SAVE') ?></span>
                <?php endif; ?>
              </div>
              <div style="margin-top:0.75rem;">
                <a href="product.php?id=<?= $rel['id'] ?>" class="btn-secondary" style="width:100%;height:38px;font-size:0.8125rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
                  View Product Details →
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  </div>
</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
