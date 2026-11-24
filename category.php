<?php
require_once __DIR__ . '/config.php';
$pdo = getDB();

// Read query filters
$catParam = isset($_GET['cat']) ? trim($_GET['cat']) : '';
$genderParam = isset($_GET['gender']) ? trim($_GET['gender']) : '';
$colorParam = isset($_GET['color']) ? trim($_GET['color']) : '';
$searchParam = isset($_GET['search']) ? trim($_GET['search']) : '';
$sortParam = isset($_GET['sort']) ? trim($_GET['sort']) : 'featured';
$sizeParam = isset($_GET['size']) ? trim($_GET['size']) : '';

// Build SQL Query
$sql = "SELECT * FROM products WHERE status = 'active'";
$params = [];

if (!empty($catParam) && strtolower($catParam) !== 'all') {
    $searchCat = trim(str_replace(['%E2%84%A2', '™', '®', '©', '-'], ' ', $catParam));
    if (stripos($searchCat, 'ecoflex') !== false) {
        $searchCat = 'ecoflex';
    }
    $sql .= " AND (category LIKE ? OR collection LIKE ?)";
    $params[] = "%$searchCat%";
    $params[] = "%$searchCat%";
}

if (!empty($genderParam)) {
    if (strtolower($genderParam) === 'women') {
        $sql .= " AND (gender = 'Women' OR gender = 'Unisex')";
    } elseif (strtolower($genderParam) === 'men') {
        $sql .= " AND (gender = 'Men' OR gender = 'Unisex')";
    } else {
        $sql .= " AND gender = ?";
        $params[] = $genderParam;
    }
}

if (!empty($colorParam)) {
    $sql .= " AND color_family = ?";
    $params[] = $colorParam;
}

if (!empty($searchParam)) {
    $sql .= " AND (title LIKE ? OR category LIKE ? OR color_name LIKE ? OR description LIKE ?)";
    $params[] = "%$searchParam%";
    $params[] = "%$searchParam%";
    $params[] = "%$searchParam%";
    $params[] = "%$searchParam%";
}

// Sorting
switch ($sortParam) {
    case 'price_asc':
        $sql .= " ORDER BY price ASC";
        break;
    case 'price_desc':
        $sql .= " ORDER BY price DESC";
        break;
    case 'rating_desc':
        $sql .= " ORDER BY rating DESC";
        break;
    case 'newest':
        $sql .= " ORDER BY id DESC";
        break;
    case 'featured':
    default:
        $sql .= " ORDER BY id ASC";
        break;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

// Dynamic Titles
$pageHeading = "All Medical Apparel";
$pageSub = "Engineered for doctors, surgeons, and nurses across India with 4-way stretch and fluid barrier protection.";

if (!empty($genderParam)) {
    $pageHeading = "{$genderParam}'s Medical Scrubs &amp; Apparel";
    $pageSub = "Tailored clinical apparel designed specifically for {$genderParam} in healthcare.";
} elseif (!empty($catParam) && strtolower($catParam) !== 'all') {
    $pageHeading = htmlspecialchars($catParam);
    if (stripos($catParam, 'classic') !== false) {
        $pageSub = "Our signature breathable poly-viscose scrub suits trusted by 100,000+ Indian healthcare heroes.";
    } elseif (stripos($catParam, 'ecoflex') !== false) {
        $pageSub = "Proprietary eco-yarn 4-way stretch scrubs with anti-fade dyes and fluid barrier protection.";
    } elseif (stripos($catParam, 'lab') !== false) {
        $pageSub = "Consultant, Chief, and Resident doctor coats tailored with stain-release cotton rich fabric.";
    } elseif (stripos($catParam, 'steth') !== false) {
        $pageSub = "6sense acoustic amplification stethoscopes with 5-year replacement warranty.";
    } elseif (stripos($catParam, 'foot') !== false) {
        $pageSub = "Shock-absorbing medical clogs engineered for 14-hour standing operation room shifts.";
    }
} elseif (!empty($colorParam)) {
    $pageHeading = "{$colorParam} Medical Apparel";
    $pageSub = "Explore scrubs, jackets, and accessories in {$colorParam} shades.";
} elseif (!empty($searchParam)) {
    $pageHeading = "Search Results for \"" . htmlspecialchars($searchParam) . "\"";
    $pageSub = count($products) . " medical products matched your clinical query.";
}

$pageTitle = strip_tags($pageHeading) . " – TRADE MEDS Collections";
$pageDesc = $pageSub;

require_once __DIR__ . '/includes/header.php';
?>

<main class="site-main">
  <!-- Hero Collection Banner -->
  <section class="collection-hero">
    <div class="container">
      <nav class="breadcrumb-nav" style="justify-content:center;color:#94a3b8;margin-bottom:0.75rem;" aria-label="Breadcrumb">
        <a href="index.php" style="color:#94a3b8;">Home</a>
        <span class="breadcrumb-separator"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></span>
        <a href="category.php?cat=all" style="color:#94a3b8;">Collections</a>
        <span class="breadcrumb-separator"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></span>
        <span style="color:#fff;font-weight:700;"><?= $pageHeading ?></span>
      </nav>
      <h1><?= $pageHeading ?></h1>
      <p><?= $pageSub ?></p>
    </div>
  </section>

  <!-- Collection Body: Filters Sidebar + Product Grid -->
  <div class="collection-layout">
    <!-- Filter Sidebar (Desktop & Mobile Drawer) -->
    <aside class="collection-sidebar" id="collection-filter-sidebar">
      <div style="display:flex;justify-content:space-between;align-items:center;padding-bottom:1rem;border-bottom:1.5px solid var(--tm-border-light);">
        <span style="font-size:1rem;font-weight:800;color:var(--tm-primary);display:inline-flex;align-items:center;gap:6px;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
          Filters
        </span>
        <a href="category.php?cat=all" style="font-size:0.75rem;color:var(--tm-accent-blue);font-weight:700;text-decoration:none;">Reset All</a>
      </div>

      <!-- Filter 1: Gender -->
      <div class="filter-group">
        <div class="filter-group-title">Gender</div>
        <div class="filter-list">
          <label class="filter-checkbox-label <?= strtolower($genderParam) === 'women' ? 'active' : '' ?>">
            <input type="radio" name="filter_gender" <?= strtolower($genderParam) === 'women' ? 'checked' : '' ?> onchange="window.location.href='category.php?gender=Women<?= !empty($catParam) ? '&cat=' . urlencode($catParam) : '' ?>'">
            <span>Women (12)</span>
          </label>
          <label class="filter-checkbox-label <?= strtolower($genderParam) === 'men' ? 'active' : '' ?>">
            <input type="radio" name="filter_gender" <?= strtolower($genderParam) === 'men' ? 'checked' : '' ?> onchange="window.location.href='category.php?gender=Men<?= !empty($catParam) ? '&cat=' . urlencode($catParam) : '' ?>'">
            <span>Men (10)</span>
          </label>
          <label class="filter-checkbox-label <?= empty($genderParam) ? 'active' : '' ?>">
            <input type="radio" name="filter_gender" <?= empty($genderParam) ? 'checked' : '' ?> onchange="window.location.href='category.php?cat=<?= urlencode($catParam ?: 'all') ?>'">
            <span>All Genders</span>
          </label>
        </div>
      </div>

      <!-- Filter 2: Category / Collection -->
      <div class="filter-group">
        <div class="filter-group-title">Category</div>
        <div class="filter-list">
          <label class="filter-checkbox-label <?= stripos($catParam, 'classic') !== false ? 'active' : '' ?>">
            <input type="checkbox" <?= stripos($catParam, 'classic') !== false ? 'checked' : '' ?> onchange="window.location.href='category.php?cat=Classic+Scrubs<?= !empty($genderParam) ? '&gender=' . urlencode($genderParam) : '' ?>'">
            <span>Classic Scrubs</span>
          </label>
          <label class="filter-checkbox-label <?= stripos($catParam, 'ecoflex') !== false ? 'active' : '' ?>">
            <input type="checkbox" <?= stripos($catParam, 'ecoflex') !== false ? 'checked' : '' ?> onchange="window.location.href='category.php?cat=ecoflex-scrubs<?= !empty($genderParam) ? '&gender=' . urlencode($genderParam) : '' ?>'">
            <span>ecoflex™ 4-Way Stretch</span>
          </label>
          <label class="filter-checkbox-label <?= stripos($catParam, 'lab') !== false ? 'active' : '' ?>">
            <input type="checkbox" <?= stripos($catParam, 'lab') !== false ? 'checked' : '' ?> onchange="window.location.href='category.php?cat=Lab+Coats'">
            <span>Lab Coats &amp; Aprons</span>
          </label>
          <label class="filter-checkbox-label <?= stripos($catParam, 'steth') !== false ? 'active' : '' ?>">
            <input type="checkbox" <?= stripos($catParam, 'steth') !== false ? 'checked' : '' ?> onchange="window.location.href='category.php?cat=Stethoscope'">
            <span>6sense Stethoscopes</span>
          </label>
          <label class="filter-checkbox-label <?= stripos($catParam, 'foot') !== false ? 'active' : '' ?>">
            <input type="checkbox" <?= stripos($catParam, 'foot') !== false ? 'checked' : '' ?> onchange="window.location.href='category.php?cat=Footwear'">
            <span>Medical Footwear &amp; Clogs</span>
          </label>
          <label class="filter-checkbox-label <?= stripos($catParam, 'under') !== false ? 'active' : '' ?>">
            <input type="checkbox" <?= stripos($catParam, 'under') !== false ? 'checked' : '' ?> onchange="window.location.href='category.php?cat=Underscrubs'">
            <span>Active Underscrubs</span>
          </label>
        </div>
      </div>

      <!-- Filter 3: Color Families -->
      <div class="filter-group">
        <div class="filter-group-title">Color Family</div>
        <div class="filter-list">
          <label class="filter-checkbox-label <?= $colorParam === 'All Blues' ? 'active' : '' ?>">
            <input type="radio" name="filter_color" <?= $colorParam === 'All Blues' ? 'checked' : '' ?> onchange="window.location.href='category.php?color=All+Blues'">
            <span style="display:inline-block;width:12px;height:12px;border-radius:50%;background:#1c2447;"></span>
            <span>All Blues</span>
          </label>
          <label class="filter-checkbox-label <?= $colorParam === 'All Blacks' ? 'active' : '' ?>">
            <input type="radio" name="filter_color" <?= $colorParam === 'All Blacks' ? 'checked' : '' ?> onchange="window.location.href='category.php?color=All+Blacks'">
            <span style="display:inline-block;width:12px;height:12px;border-radius:50%;background:#111827;"></span>
            <span>All Blacks</span>
          </label>
          <label class="filter-checkbox-label <?= $colorParam === 'All Greens' ? 'active' : '' ?>">
            <input type="radio" name="filter_color" <?= $colorParam === 'All Greens' ? 'checked' : '' ?> onchange="window.location.href='category.php?color=All+Greens'">
            <span style="display:inline-block;width:12px;height:12px;border-radius:50%;background:#064e3b;"></span>
            <span>All Greens</span>
          </label>
          <label class="filter-checkbox-label <?= $colorParam === 'All Reds' ? 'active' : '' ?>">
            <input type="radio" name="filter_color" <?= $colorParam === 'All Reds' ? 'checked' : '' ?> onchange="window.location.href='category.php?color=All+Reds'">
            <span style="display:inline-block;width:12px;height:12px;border-radius:50%;background:#631d38;"></span>
            <span>All Reds (Wine)</span>
          </label>
          <label class="filter-checkbox-label <?= $colorParam === 'All Pastels' ? 'active' : '' ?>">
            <input type="radio" name="filter_color" <?= $colorParam === 'All Pastels' ? 'checked' : '' ?> onchange="window.location.href='category.php?color=All+Pastels'">
            <span style="display:inline-block;width:12px;height:12px;border-radius:50%;background:#93c5fd;"></span>
            <span>All Pastels</span>
          </label>
          <label class="filter-checkbox-label <?= $colorParam === 'All Greys' ? 'active' : '' ?>">
            <input type="radio" name="filter_color" <?= $colorParam === 'All Greys' ? 'checked' : '' ?> onchange="window.location.href='category.php?color=All+Greys'">
            <span style="display:inline-block;width:12px;height:12px;border-radius:50%;background:#4b5563;"></span>
            <span>All Greys</span>
          </label>
        </div>
      </div>

      <!-- Quick Size Guide Link -->
      <div style="background:#f8fafc;border:1px solid var(--tm-border-light);border-radius:10px;padding:1rem;text-align:center;">
        <span style="display:block;font-size:0.8125rem;font-weight:700;color:var(--tm-primary);margin-bottom:0.25rem;">Need Sizing Help?</span>
        <button type="button" class="pdp-size-guide-btn" onclick="window.TM.openSizeChart()" style="margin:0 auto;">Open Size Chart →</button>
      </div>
    </aside>

    <!-- Main Content: Toolbar & Product Grid -->
    <section>
      <!-- Toolbar: Items Count & Sort -->
      <div class="collection-toolbar">
        <div>
          <span style="font-size:0.9375rem;font-weight:700;color:var(--tm-primary);">
            Showing <?= count($products) ?> Medical Apparel Products
          </span>
          <?php if (!empty($catParam) || !empty($genderParam) || !empty($colorParam)): ?>
            <div style="display:flex;gap:6px;margin-top:6px;flex-wrap:wrap;">
              <?php if (!empty($catParam)): ?>
                <span style="background:#e0f2fe;color:#0369a1;font-size:0.75rem;font-weight:700;padding:2px 10px;border-radius:12px;display:inline-flex;align-items:center;gap:4px;">
                  <?= htmlspecialchars($catParam) ?>
                  <a href="category.php?cat=all<?= !empty($genderParam) ? '&gender=' . urlencode($genderParam) : '' ?>" style="color:#0369a1;text-decoration:none;">×</a>
                </span>
              <?php endif; ?>
              <?php if (!empty($genderParam)): ?>
                <span style="background:#f0fdf4;color:#166534;font-size:0.75rem;font-weight:700;padding:2px 10px;border-radius:12px;display:inline-flex;align-items:center;gap:4px;">
                  <?= htmlspecialchars($genderParam) ?>
                  <a href="category.php?cat=<?= urlencode($catParam ?: 'all') ?>" style="color:#166534;text-decoration:none;">×</a>
                </span>
              <?php endif; ?>
              <?php if (!empty($colorParam)): ?>
                <span style="background:#fdf2f8;color:#9d174d;font-size:0.75rem;font-weight:700;padding:2px 10px;border-radius:12px;display:inline-flex;align-items:center;gap:4px;">
                  <?= htmlspecialchars($colorParam) ?>
                  <a href="category.php?cat=all" style="color:#9d174d;text-decoration:none;">×</a>
                </span>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>

        <!-- Sort Select -->
        <div style="display:flex;align-items:center;gap:8px;">
          <label style="font-size:0.875rem;font-weight:600;color:var(--tm-text-secondary);">Sort By:</label>
          <select class="collection-sort-select" onchange="window.location.href=this.value">
            <option value="category.php?sort=featured<?= !empty($catParam) ? '&cat=' . urlencode($catParam) : '' ?><?= !empty($genderParam) ? '&gender=' . urlencode($genderParam) : '' ?>" <?= $sortParam === 'featured' ? 'selected' : '' ?>>Featured</option>
            <option value="category.php?sort=price_asc<?= !empty($catParam) ? '&cat=' . urlencode($catParam) : '' ?><?= !empty($genderParam) ? '&gender=' . urlencode($genderParam) : '' ?>" <?= $sortParam === 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
            <option value="category.php?sort=price_desc<?= !empty($catParam) ? '&cat=' . urlencode($catParam) : '' ?><?= !empty($genderParam) ? '&gender=' . urlencode($genderParam) : '' ?>" <?= $sortParam === 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
            <option value="category.php?sort=rating_desc<?= !empty($catParam) ? '&cat=' . urlencode($catParam) : '' ?><?= !empty($genderParam) ? '&gender=' . urlencode($genderParam) : '' ?>" <?= $sortParam === 'rating_desc' ? 'selected' : '' ?>>Customer Rating</option>
            <option value="category.php?sort=newest<?= !empty($catParam) ? '&cat=' . urlencode($catParam) : '' ?><?= !empty($genderParam) ? '&gender=' . urlencode($genderParam) : '' ?>" <?= $sortParam === 'newest' ? 'selected' : '' ?>>Newest First</option>
          </select>
        </div>
      </div>

      <!-- Products Grid -->
      <?php if (empty($products)): ?>
        <div style="text-align:center;padding:5rem 2rem;background:#f8fafc;border-radius:16px;">
          <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--tm-text-light)" stroke-width="1.5" style="margin:0 auto 1rem;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          <h3 style="font-size:1.25rem;font-weight:700;color:var(--tm-primary);margin-bottom:0.5rem;">No products match your selected filters</h3>
          <p style="font-size:0.875rem;color:var(--tm-text-secondary);margin-bottom:1.5rem;">Try resetting your filters or exploring our full medical catalog.</p>
          <a href="category.php?cat=all" class="cart-checkout-btn" style="display:inline-block;padding:10px 24px;text-decoration:none;">View All Medical Scrubs</a>
        </div>
      <?php else: ?>
        <div class="product-grid" style="display:grid;grid-template-columns:repeat(3, 1fr);gap:1.75rem;width:100%;">
          <?php foreach ($products as $p): ?>
            <div class="product-card" data-product-id="<?= $p['id'] ?>">
              <div class="card-media-box">
                <a href="product.php?id=<?= $p['id'] ?>" style="display:block;width:100%;height:100%;">
                  <img src="<?= htmlspecialchars($p['primary_image']) ?>" class="card-img-primary" alt="<?= htmlspecialchars($p['title']) ?>" loading="lazy" onerror="this.onerror=null; this.src='https://knyamed.com/cdn/shop/files/1_70.jpg?v=1739900854&width=832';">
                  <img src="<?= htmlspecialchars($p['hover_image'] ?: $p['primary_image']) ?>" class="card-img-hover" alt="<?= htmlspecialchars($p['title']) ?>" loading="lazy" onerror="this.onerror=null; this.src='https://knyamed.com/cdn/shop/files/1_67.jpg?v=1739900771&width=832';">
                </a>
                <button type="button" class="card-wishlist-btn" onclick="window.TM.toggleWishlist(<?= $p['id'] ?>)" title="Add to Wishlist">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                </button>
                <button type="button" class="card-quickview-btn" onclick="window.TM.openQuickView(<?= $p['id'] ?>)">Quick View</button>
              </div>
              <div class="card-details">
                <div class="card-rating-row">
                  <svg class="star-icon" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                  <span class="rating-value"><?= number_format($p['rating'] ?: 4.8, 1) ?></span>
                  <span>(<?= number_format($p['reviews_count'] ?: 450) ?>)</span>
                </div>
                <a href="product.php?id=<?= $p['id'] ?>" class="card-title"><?= htmlspecialchars($p['title']) ?></a>
                <div class="card-price-row">
                  <span class="sale-price">₹<?= number_format($p['price']) ?></span>
                  <?php if ($p['original_price'] > $p['price']): ?>
                    <span class="mrp-price">₹<?= number_format($p['original_price']) ?></span>
                    <span class="discount-badge"><?= htmlspecialchars($p['discount'] ?: 'SAVE') ?></span>
                  <?php endif; ?>
                </div>

                <div style="display:flex;gap:6px;margin-top:0.85rem;">
                  <button type="button" class="btn-secondary" style="flex:1;height:38px;font-size:0.8125rem;font-weight:700;" onclick="window.TM.addToCart(<?= $p['id'] ?>)">
                    Add to Bag
                  </button>
                  <a href="product.php?id=<?= $p['id'] ?>" class="cart-checkout-btn" style="flex:1;height:38px;font-size:0.8125rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
                    Details
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </section>
  </div>
</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>

