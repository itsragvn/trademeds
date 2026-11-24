<?php
require_once __DIR__ . '/config.php';

$pageTitle = "Buy Scrubs Online, Lab Coats, Doctor's Aprons & Medical Apparel – TRADE MEDS";
$pageDesc = "TRADE MEDS is India's leading medical apparel brand. Buy stylish, comfortable medical scrubs, lab coats, doctor's aprons, and 6sense stethoscopes online.";

require_once __DIR__ . '/includes/header.php';
?>

<!-- ==========================================================
       4. MAIN HERO BANNER SLIDER
       ========================================================== -->
  <section class="hero-slider-section" id="hero-slider">
    <div class="hero-slider-container" id="hero-slider-track">
      <!-- Slide 1 -->
      <div class="hero-slide">
        <picture class="hero-slide-picture">
          <source media="(max-width: 768px)" srcset="https://knyamed.com/cdn/shop/files/Website_Banner_Ready_for_rounds_Mobile_test_2_80e78975-e568-4f4a-b9a8-9fee444e9853.png?v=1783596712&width=600">
          <img src="https://knyamed.com/cdn/shop/files/Banner_Ready_for_rounds_Desktop.png?v=1779091625&width=1500" alt="Ready for Rounds - TRADE MEDS Medical Scrubs">
        </picture>
      </div>

      <!-- Slide 2 -->
      <div class="hero-slide">
        <picture class="hero-slide-picture">
          <source media="(max-width: 768px)" srcset="https://knyamed.com/cdn/shop/files/Scrub_Cap_Website_Asset_Mobile_Banner_New_Launch_688b3473-1464-4b71-aad6-4059ea4ce152.png?v=1794900267&width=600">
          <img src="https://knyamed.com/cdn/shop/files/Scrub_Cap_Website_Asset_Desktop_Banner_Early_access.png?v=1794900284&width=1500" alt="Scrub Cap Early Access - TRADE MEDS">
        </picture>
      </div>

      <!-- Slide 3 -->
      <div class="hero-slide">
        <picture class="hero-slide-picture">
          <source media="(max-width: 768px)" srcset="https://knyamed.com/cdn/shop/files/Clogs_Website_Asset_Mobile_Banner.png?v=1792665260&width=600">
          <img src="https://knyamed.com/cdn/shop/files/Clogs_Website_Asset_Desktop_Banner.png?v=1792665264&width=1500" alt="Comfort Medical Footwear Clogs - TRADE MEDS">
        </picture>
      </div>
    </div>

    <!-- Controls -->
    <button type="button" class="hero-slider-nav prev" id="hero-prev-btn" aria-label="Previous Slide">‹</button>
    <button type="button" class="hero-slider-nav next" id="hero-next-btn" aria-label="Next Slide">›</button>

    <div class="hero-slider-dots">
      <span class="hero-dot active"></span>
      <span class="hero-dot"></span>
      <span class="hero-dot"></span>
    </div>
  </section>

  <!-- ==========================================================
       5. FEATURE HIGHLIGHTS
       ========================================================== -->
  <section class="feature-highlights-section">
    <div class="container">
      <div class="features-grid">
        <div class="feature-item">
          <div class="feature-icon-box">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          </div>
          <div>
            <h4 class="feature-title">Fluid-Barrier Tech</h4>
            <p class="feature-desc">Liquid repellent &amp; anti-fade medical weave</p>
          </div>
        </div>

        <div class="feature-item">
          <div class="feature-icon-box">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
          </div>
          <div>
            <h4 class="feature-title">4-Way Stretch</h4>
            <p class="feature-desc">100% mobility during long surgical shifts</p>
          </div>
        </div>

        <div class="feature-item">
          <div class="feature-icon-box">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7"/></svg>
          </div>
          <div>
            <h4 class="feature-title">Hospital Verified</h4>
            <p class="feature-desc">Over 10,000+ 5-star doctor ratings</p>
          </div>
        </div>

        <div class="feature-item">
          <div class="feature-icon-box">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
          </div>
          <div>
            <h4 class="feature-title">Pan-India Delivery</h4>
            <p class="feature-desc">Express dispatch &amp; Cash on Delivery</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================================
       6. RUNNING TICKER MARQUEE
       ========================================================== -->
  <section class="feature-ticker-section">
    <div class="ticker-track">
      <div class="ticker-item">
        <span>ANTI-DISTRACTION</span><span class="ticker-bullet"></span>
        <span>LAB TESTED</span><span class="ticker-bullet"></span>
        <span>LONG-SHIFT VERIFIED</span><span class="ticker-bullet"></span>
        <span>BACKED BY TECHNOLOGY</span><span class="ticker-bullet"></span>
        <span>TONS OF STORAGE</span><span class="ticker-bullet"></span>
      </div>
      <div class="ticker-item" aria-hidden="true">
        <span>ANTI-DISTRACTION</span><span class="ticker-bullet"></span>
        <span>LAB TESTED</span><span class="ticker-bullet"></span>
        <span>LONG-SHIFT VERIFIED</span><span class="ticker-bullet"></span>
        <span>BACKED BY TECHNOLOGY</span><span class="ticker-bullet"></span>
        <span>TONS OF STORAGE</span><span class="ticker-bullet"></span>
      </div>
    </div>
  </section>

  <!-- ==========================================================
       7. SHOP BY CATEGORIES
       ========================================================== -->
  <section class="section-wrapper" id="categories-section">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Shop By Categories</h2>
        <p class="section-subtitle">Premium medical attire engineered for peak professional performance</p>
      </div>

      <div class="categories-grid">
        <!-- Row 1: Item 1 -->
        <a href="category.php?gender=Women" class="category-chip-card" title="Shop Women's Scrubs &amp; Apparel">
          <div class="category-chip-avatar">
            <img src="https://knyamed.com/cdn/shop/files/Women.png?v=1762154347" alt="Women" loading="lazy">
          </div>
          <span class="category-chip-label">Women</span>
          <span class="category-chip-sub">Scrubs &amp; Lab Coats</span>
        </a>

        <!-- Row 1: Item 2 -->
        <a href="category.php?gender=Men" class="category-chip-card" title="Shop Men's Scrubs &amp; Apparel">
          <div class="category-chip-avatar">
            <img src="https://knyamed.com/cdn/shop/files/Men_3be25934-5489-4198-aa92-a2ddf5d8a6d3.png?v=1769579106" alt="Men" loading="lazy">
          </div>
          <span class="category-chip-label">Men</span>
          <span class="category-chip-sub">Scrubs &amp; Aprons</span>
        </a>

        <!-- Row 1: Item 3 -->
        <a href="category.php?cat=Classic+Scrubs" class="category-chip-card" title="Shop Classic Medical Scrubs">
          <div class="category-chip-avatar">
            <img src="https://knyamed.com/cdn/shop/files/b7e551978c02d1b6d387114becb44701ba6904bb_fced66b8-7213-4d7e-b220-48c6dd53e3be.png?v=1769579237" alt="Classic Scrubs" loading="lazy">
          </div>
          <span class="category-chip-label">Classic Scrubs</span>
          <span class="category-chip-sub">All-Day Comfort</span>
        </a>

        <!-- Row 1: Item 4 -->
        <a href="category.php?cat=ecoflex-scrubs" class="category-chip-card" title="Shop ecoflex 4-Way Stretch Scrubs">
          <div class="category-chip-avatar">
            <img src="https://knyamed.com/cdn/shop/files/Ecoflex_980bfb38-13e2-4371-b56a-c339b939f515_1.png?v=1769579377" alt="ecoflex Scrubs" loading="lazy">
          </div>
          <span class="category-chip-label">ecoflex™ Scrubs</span>
          <span class="category-chip-sub">4-Way Stretch Tech</span>
        </a>

        <!-- Row 1: Item 5 -->
        <a href="category.php?cat=Stethoscope" class="category-chip-card" title="Shop 6sense Precision Stethoscopes">
          <div class="category-chip-avatar">
            <img src="https://knyamed.com/cdn/shop/files/Stethoscope_b67dbfb9-4daa-42f1-b6ff-5acde8386682.png?v=1769579524" alt="Stethoscope" loading="lazy">
          </div>
          <span class="category-chip-label">Stethoscope</span>
          <span class="category-chip-sub">6sense Precision</span>
        </a>

        <!-- Row 2: Item 6 -->
        <a href="category.php?cat=Footwear" class="category-chip-card" title="Shop Medical Footwear &amp; Clogs">
          <div class="category-chip-avatar">
            <img src="https://knyamed.com/cdn/shop/files/Category_Image_1c081ffd-41d9-4779-8f98-721cd95e9913.png?v=1792663079" alt="Footwear" loading="lazy">
          </div>
          <span class="category-chip-label">Footwear New</span>
          <span class="category-chip-sub">Anti-Fatigue Clogs</span>
        </a>

        <!-- Row 2: Item 7 -->
        <a href="category.php?cat=Lab+Coats" class="category-chip-card" title="Shop Doctor Lab Coats &amp; Aprons">
          <div class="category-chip-avatar">
            <img src="https://knyamed.com/cdn/shop/files/Labcoat_eb046422-0767-4374-a73d-97c252f84110.png?v=1769579738" alt="Lab Coats" loading="lazy">
          </div>
          <span class="category-chip-label">Lab Coats</span>
          <span class="category-chip-sub">Classic &amp; Modern</span>
        </a>

        <!-- Row 2: Item 8 -->
        <a href="category.php?cat=Underscrubs" class="category-chip-card" title="Shop Thermal &amp; Seamless Underscrubs">
          <div class="category-chip-avatar">
            <img src="https://knyamed.com/cdn/shop/files/Underscrubs_69e49385-d903-4a7d-9312-b788edec3399.png?v=1769579815" alt="Underscrubs" loading="lazy">
          </div>
          <span class="category-chip-label">Underscrubs</span>
          <span class="category-chip-sub">Seamless Baselayers</span>
        </a>

        <!-- Row 2: Item 9 -->
        <a href="category.php?cat=Accessories" class="category-chip-card" title="Shop Surgical &amp; Scrub Caps">
          <div class="category-chip-avatar">
            <img src="https://knyamed.com/cdn/shop/files/PDP_APP_Assests_Mega_menu_containe.png?v=1792664652&width=800" alt="Scrub Caps" loading="lazy">
          </div>
          <span class="category-chip-label">Scrub Caps</span>
          <span class="category-chip-sub">Breathable Ties</span>
        </a>

        <!-- Row 2: Item 10 -->
        <a href="product.php?id=17" class="category-chip-card" title="Shop Warm-Up Drift Jackets">
          <div class="category-chip-avatar">
            <img src="https://knyamed.com/cdn/shop/files/Everyday_Comfort_0a0f2a36-5daa-466a-abc0-4a53fba204ab.png?v=1782455818&width=800" alt="Drift Jacket" loading="lazy">
          </div>
          <span class="category-chip-label">Drift Jacket</span>
          <span class="category-chip-sub">Clinic Warm-Up</span>
        </a>
      </div>
    </div>
  </section>

  <!-- ==========================================================
       8. SHOP BY COLOURS
       ========================================================== -->
  <section class="shop-by-colours-section">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Shop By Colours</h2>
        <p class="section-subtitle">Click on any shade to filter scrubs &amp; medical apparel instantly</p>
      </div>

      <div class="colours-grid">
        <div class="colour-card" data-color-family="All Blues" onclick="window.TM.filterByColor('All Blues')">
          <div class="colour-card-image">
            <img src="https://knyamed.com/cdn/shop/files/Scrub_Navy_Blue.png?v=1764763059&amp;width=260" alt="All Blues" loading="lazy">
          </div>
          <span class="colour-card-title">All Blues</span>
          <span class="colour-card-sub">Navy, Royal &amp; Ceil</span>
          <div class="colour-palette-dots">
            <span class="colour-dot" style="background:#172554;" title="Navy Blue"></span>
            <span class="colour-dot" style="background:#1d4ed8;" title="Royal Blue"></span>
            <span class="colour-dot" style="background:#60a5fa;" title="Ceil Blue"></span>
          </div>
        </div>

        <div class="colour-card" data-color-family="All Blacks" onclick="window.TM.filterByColor('All Blacks')">
          <div class="colour-card-image">
            <img src="https://knyamed.com/cdn/shop/files/Scrub_Black_2.png?v=1765190163&amp;width=260" alt="All Blacks" loading="lazy">
          </div>
          <span class="colour-card-title">All Blacks</span>
          <span class="colour-card-sub">Matte Onyx &amp; Obsidian</span>
          <div class="colour-palette-dots">
            <span class="colour-dot" style="background:#020617;" title="Pitch Black"></span>
            <span class="colour-dot" style="background:#0f172a;" title="Onyx Black"></span>
            <span class="colour-dot" style="background:#334155;" title="Dark Charcoal"></span>
          </div>
        </div>

        <div class="colour-card" data-color-family="All Greens" onclick="window.TM.filterByColor('All Greens')">
          <div class="colour-card-image">
            <img src="https://knyamed.com/cdn/shop/files/Scrub_Forest_Green.png?v=1764763353&amp;width=260" alt="All Greens" loading="lazy">
          </div>
          <span class="colour-card-title">All Greens</span>
          <span class="colour-card-sub">Hunter, Forest &amp; Sage</span>
          <div class="colour-palette-dots">
            <span class="colour-dot" style="background:#022c22;" title="Hunter Green"></span>
            <span class="colour-dot" style="background:#047857;" title="Forest Green"></span>
            <span class="colour-dot" style="background:#10b981;" title="Hospital Sage"></span>
          </div>
        </div>

        <div class="colour-card" data-color-family="All Reds" onclick="window.TM.filterByColor('All Reds')">
          <div class="colour-card-image">
            <img src="https://knyamed.com/cdn/shop/files/Scrub_Wine.png?v=1764763352&amp;width=260" alt="All Reds" loading="lazy">
          </div>
          <span class="colour-card-title">All Reds</span>
          <span class="colour-card-sub">Wine, Burgundy &amp; Maroon</span>
          <div class="colour-palette-dots">
            <span class="colour-dot" style="background:#4c0519;" title="Burgundy"></span>
            <span class="colour-dot" style="background:#881337;" title="Wine Red"></span>
            <span class="colour-dot" style="background:#b91c1c;" title="Ruby Red"></span>
          </div>
        </div>

        <div class="colour-card" data-color-family="All Pastels" onclick="window.TM.filterByColor('All Pastels')">
          <div class="colour-card-image">
            <img src="https://knyamed.com/cdn/shop/files/Scrub_Pastel_Lilac.png?v=1764763355&amp;width=260" alt="All Pastels" loading="lazy">
          </div>
          <span class="colour-card-title">All Pastels</span>
          <span class="colour-card-sub">Lilac, Rose &amp; Sky</span>
          <div class="colour-palette-dots">
            <span class="colour-dot" style="background:#c084fc;" title="Lilac Purple"></span>
            <span class="colour-dot" style="background:#f472b6;" title="Blush Rose"></span>
            <span class="colour-dot" style="background:#38bdf8;" title="Ice Sky Blue"></span>
          </div>
        </div>

        <div class="colour-card" data-color-family="All Greys" onclick="window.TM.filterByColor('All Greys')">
          <div class="colour-card-image">
            <img src="https://knyamed.com/cdn/shop/files/Scrub_Heather_Grey_892c9f0b-e236-4fcb-ba05-58b75fd70bc5.png?v=1765194527&amp;width=260" alt="All Greys" loading="lazy">
          </div>
          <span class="colour-card-title">All Greys</span>
          <span class="colour-card-sub">Heather, Slate &amp; Pewter</span>
          <div class="colour-palette-dots">
            <span class="colour-dot" style="background:#1e293b;" title="Deep Slate"></span>
            <span class="colour-dot" style="background:#64748b;" title="Heather Grey"></span>
            <span class="colour-dot" style="background:#94a3b8;" title="Light Pewter"></span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================================
       9. FEATURED PRODUCT COLLECTIONS: SHOP CLASSIC SCRUBS
       ========================================================== -->
  <section class="section-wrapper" id="classic-scrubs-section">
    <div class="container">
      <div class="section-header" style="display:flex;justify-content:space-between;align-items:flex-end;text-align:left;">
        <div>
          <h2 class="section-title">Shop Classic Scrubs</h2>
          <p class="section-subtitle">Made to last with breathable &amp; light poly-viscose medical fabric</p>
        </div>
        <a href="category.php?cat=Classic+Scrubs" style="font-weight:700;color:var(--tm-primary);font-size:0.9375rem;text-decoration:underline;">View All Classic Scrubs →</a>
      </div>

      <div class="product-grid" id="classic-products-grid">
        <div class="product-card" data-product-id="1" id="card-prod-1">
          <div class="card-media-box">
            <a href="product.php?id=1" style="display:block;width:100%;height:100%;">
              <img src="https://knyamed.com/cdn/shop/files/1_36_f708815d-e636-4d70-af59-b4c8dbdc1e7d.jpg?v=1739900782&width=832" class="card-img-primary" id="card-img-1" alt="Classic Women's V-Neck (Navy) Scrub" loading="lazy">
              <img src="https://knyamed.com/cdn/shop/files/Fabricdetailsclassic_NavyW_33e2f772-9afa-45ce-b26f-792dfa493b03.png?v=1779693531&width=832" class="card-img-hover" alt="Classic Women's V-Neck (Navy) Scrub" loading="lazy">
            </a>
            <button type="button" class="card-wishlist-btn" data-product-id="1" onclick="window.TM.toggleWishlist(1)" title="Add to Wishlist">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            </button>
            <button type="button" class="card-quickview-btn" onclick="window.TM.openQuickView(1)">Quick View</button>
          </div>
          <div class="card-details">
            <div class="card-rating-row">
              <svg class="star-icon" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              <span class="rating-value">4.8</span>
              <span>(1248)</span>
            </div>
            <a href="product.php?id=1" class="card-title">Classic Women's V-Neck (Navy) Scrub</a>
            <div class="card-price-row">
              <span class="sale-price">₹1,099</span>
              <span class="mrp-price">₹1,599</span>
              <span class="discount-badge">31% OFF</span>
            </div>
            <div class="card-swatches-row">
              <span class="card-swatch-dot" style="background-color:#1c2447;cursor:pointer;" title="Navy Blue" onmouseover="window.TM.previewCardSwatch(1, 'Navy Blue')"></span><span class="card-swatch-dot" style="background-color:#631d38;cursor:pointer;" title="Wine" onmouseover="window.TM.previewCardSwatch(1, 'Wine')"></span><span class="card-swatch-dot" style="background-color:#1a1a1a;cursor:pointer;" title="Black" onmouseover="window.TM.previewCardSwatch(1, 'Black')"></span><span class="card-swatch-dot" style="background-color:#7a8288;cursor:pointer;" title="Heather Grey" onmouseover="window.TM.previewCardSwatch(1, 'Heather Grey')"></span><span class="card-swatch-dot" style="background-color:#1e3d30;cursor:pointer;" title="Forest Green" onmouseover="window.TM.previewCardSwatch(1, 'Forest Green')"></span>
              
            </div>
            <div style="display:flex;gap:6px;margin-top:0.75rem;">
              <button type="button" class="btn-secondary" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;" onclick="window.TM.addToCart(1)">
                Add to Bag
              </button>
              <a href="product.php?id=1" class="cart-checkout-btn" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
                Details
              </a>
            </div>
          </div>
        </div>
        <div class="product-card" data-product-id="2" id="card-prod-2">
          <div class="card-media-box">
            <a href="product.php?id=2" style="display:block;width:100%;height:100%;">
              <img src="https://knyamed.com/cdn/shop/files/11TH_MAY_KNYA-1595_2.jpg?v=1739900798&width=832" class="card-img-primary" id="card-img-2" alt="Classic Men's V-Neck (Navy) Scrub" loading="lazy">
              <img src="https://knyamed.com/cdn/shop/files/Fabricdetailsclassic_NavyM.png?v=1779449658&width=832" class="card-img-hover" alt="Classic Men's V-Neck (Navy) Scrub" loading="lazy">
            </a>
            <button type="button" class="card-wishlist-btn" data-product-id="2" onclick="window.TM.toggleWishlist(2)" title="Add to Wishlist">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            </button>
            <button type="button" class="card-quickview-btn" onclick="window.TM.openQuickView(2)">Quick View</button>
          </div>
          <div class="card-details">
            <div class="card-rating-row">
              <svg class="star-icon" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              <span class="rating-value">4.8</span>
              <span>(984)</span>
            </div>
            <a href="product.php?id=2" class="card-title">Classic Men's V-Neck (Navy) Scrub</a>
            <div class="card-price-row">
              <span class="sale-price">₹1,099</span>
              <span class="mrp-price">₹1,599</span>
              <span class="discount-badge">31% OFF</span>
            </div>
            <div class="card-swatches-row">
              <span class="card-swatch-dot" style="background-color:#1c2447;cursor:pointer;" title="Navy Blue" onmouseover="window.TM.previewCardSwatch(2, 'Navy Blue')"></span><span class="card-swatch-dot" style="background-color:#631d38;cursor:pointer;" title="Wine" onmouseover="window.TM.previewCardSwatch(2, 'Wine')"></span><span class="card-swatch-dot" style="background-color:#1a1a1a;cursor:pointer;" title="Black" onmouseover="window.TM.previewCardSwatch(2, 'Black')"></span><span class="card-swatch-dot" style="background-color:#1e3d30;cursor:pointer;" title="Forest Green" onmouseover="window.TM.previewCardSwatch(2, 'Forest Green')"></span><span class="card-swatch-dot" style="background-color:#7a8288;cursor:pointer;" title="Heather Grey" onmouseover="window.TM.previewCardSwatch(2, 'Heather Grey')"></span>
              
            </div>
            <div style="display:flex;gap:6px;margin-top:0.75rem;">
              <button type="button" class="btn-secondary" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;" onclick="window.TM.addToCart(2)">
                Add to Bag
              </button>
              <a href="product.php?id=2" class="cart-checkout-btn" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
                Details
              </a>
            </div>
          </div>
        </div>
        <div class="product-card" data-product-id="3" id="card-prod-3">
          <div class="card-media-box">
            <a href="product.php?id=3" style="display:block;width:100%;height:100%;">
              <img src="https://knyamed.com/cdn/shop/files/1a3O1A8835.jpg?v=1739900851&width=832" class="card-img-primary" id="card-img-3" alt="Classic Women's V-Neck (Wine) Scrub" loading="lazy">
              <img src="https://knyamed.com/cdn/shop/files/Fabricdetailsclassic_WineW_b18f4677-d474-4230-892b-7e5abdfb6d8b.png?v=1779693298&width=832" class="card-img-hover" alt="Classic Women's V-Neck (Wine) Scrub" loading="lazy">
            </a>
            <button type="button" class="card-wishlist-btn" data-product-id="3" onclick="window.TM.toggleWishlist(3)" title="Add to Wishlist">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            </button>
            <button type="button" class="card-quickview-btn" onclick="window.TM.openQuickView(3)">Quick View</button>
          </div>
          <div class="card-details">
            <div class="card-rating-row">
              <svg class="star-icon" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              <span class="rating-value">4.9</span>
              <span>(1412)</span>
            </div>
            <a href="product.php?id=3" class="card-title">Classic Women's V-Neck (Wine) Scrub</a>
            <div class="card-price-row">
              <span class="sale-price">₹1,099</span>
              <span class="mrp-price">₹1,599</span>
              <span class="discount-badge">31% OFF</span>
            </div>
            <div class="card-swatches-row">
              <span class="card-swatch-dot" style="background-color:#631d38;cursor:pointer;" title="Wine" onmouseover="window.TM.previewCardSwatch(3, 'Wine')"></span><span class="card-swatch-dot" style="background-color:#1c2447;cursor:pointer;" title="Navy Blue" onmouseover="window.TM.previewCardSwatch(3, 'Navy Blue')"></span><span class="card-swatch-dot" style="background-color:#1a1a1a;cursor:pointer;" title="Black" onmouseover="window.TM.previewCardSwatch(3, 'Black')"></span><span class="card-swatch-dot" style="background-color:#b5a3cc;cursor:pointer;" title="Pastel Lilac" onmouseover="window.TM.previewCardSwatch(3, 'Pastel Lilac')"></span>
              
            </div>
            <div style="display:flex;gap:6px;margin-top:0.75rem;">
              <button type="button" class="btn-secondary" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;" onclick="window.TM.addToCart(3)">
                Add to Bag
              </button>
              <a href="product.php?id=3" class="cart-checkout-btn" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
                Details
              </a>
            </div>
          </div>
        </div>
        <div class="product-card" data-product-id="4" id="card-prod-4">
          <div class="card-media-box">
            <a href="product.php?id=4" style="display:block;width:100%;height:100%;">
              <img src="https://knyamed.com/cdn/shop/files/1_50.jpg?v=1739900724&width=832" class="card-img-primary" id="card-img-4" alt="Classic Men's V-Neck (Wine) Scrub" loading="lazy">
              <img src="https://knyamed.com/cdn/shop/files/Fabricdetailsclassic_WineM.png?v=1779449375&width=832" class="card-img-hover" alt="Classic Men's V-Neck (Wine) Scrub" loading="lazy">
            </a>
            <button type="button" class="card-wishlist-btn" data-product-id="4" onclick="window.TM.toggleWishlist(4)" title="Add to Wishlist">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            </button>
            <button type="button" class="card-quickview-btn" onclick="window.TM.openQuickView(4)">Quick View</button>
          </div>
          <div class="card-details">
            <div class="card-rating-row">
              <svg class="star-icon" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              <span class="rating-value">4.8</span>
              <span>(642)</span>
            </div>
            <a href="product.php?id=4" class="card-title">Classic Men's V-Neck (Wine) Scrub</a>
            <div class="card-price-row">
              <span class="sale-price">₹1,299</span>
              <span class="mrp-price">₹1,799</span>
              <span class="discount-badge">28% OFF</span>
            </div>
            <div class="card-swatches-row">
              <span class="card-swatch-dot" style="background-color:#631d38;cursor:pointer;" title="Wine" onmouseover="window.TM.previewCardSwatch(4, 'Wine')"></span><span class="card-swatch-dot" style="background-color:#1c2447;cursor:pointer;" title="Navy Blue" onmouseover="window.TM.previewCardSwatch(4, 'Navy Blue')"></span><span class="card-swatch-dot" style="background-color:#1a1a1a;cursor:pointer;" title="Black" onmouseover="window.TM.previewCardSwatch(4, 'Black')"></span>
              
            </div>
            <div style="display:flex;gap:6px;margin-top:0.75rem;">
              <button type="button" class="btn-secondary" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;" onclick="window.TM.addToCart(4)">
                Add to Bag
              </button>
              <a href="product.php?id=4" class="cart-checkout-btn" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
                Details
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================================
       10. BEST SELLERS: SHOP ECOFLEX™ SCRUBS
       ========================================================== -->
  <section class="section-wrapper" id="ecoflex-section" style="background-color: var(--tm-bg-soft);">
    <div class="container">
      <div class="section-header" style="display:flex;justify-content:space-between;align-items:flex-end;text-align:left;">
        <div>
          <h2 class="section-title">Shop ecoflex™ Scrubs</h2>
          <p class="section-subtitle">Engineered with proprietary 4-way stretch technology made from recycled PET bottles</p>
        </div>
        <a href="category.php?cat=ecoflex-scrubs" style="font-weight:700;color:var(--tm-primary);font-size:0.9375rem;text-decoration:underline;">View All ecoflex™ →</a>
      </div>

      <div class="product-grid" id="ecoflex-products-grid">
        <div class="product-card" data-product-id="7" id="card-prod-7">
          <div class="card-media-box">
            <a href="product.php?id=7" style="display:block;width:100%;height:100%;">
              <img src="https://knyamed.com/cdn/shop/files/21st_Oct_Kanya-3116.jpg?v=1739900753&width=832" class="card-img-primary" id="card-img-7" alt="ecoflex™ Women's V-Neck (Navy) Scrub" loading="lazy">
              <img src="https://knyamed.com/cdn/shop/files/ecoflexfabriccompositionandtech_NavyBlue.png?v=1776248509&width=832" class="card-img-hover" alt="ecoflex™ Women's V-Neck (Navy) Scrub" loading="lazy">
            </a>
            <button type="button" class="card-wishlist-btn" data-product-id="7" onclick="window.TM.toggleWishlist(7)" title="Add to Wishlist">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            </button>
            <button type="button" class="card-quickview-btn" onclick="window.TM.openQuickView(7)">Quick View</button>
          </div>
          <div class="card-details">
            <div class="card-rating-row">
              <svg class="star-icon" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              <span class="rating-value">4.9</span>
              <span>(2180)</span>
            </div>
            <a href="product.php?id=7" class="card-title">ecoflex™ Women's V-Neck (Navy) Scrub</a>
            <div class="card-price-row">
              <span class="sale-price">₹2,499</span>
              <span class="mrp-price">₹3,499</span>
              <span class="discount-badge">29% OFF</span>
            </div>
            <div class="card-swatches-row">
              <span class="card-swatch-dot" style="background-color:#1c2447;cursor:pointer;" title="Navy Blue" onmouseover="window.TM.previewCardSwatch(7, 'Navy Blue')"></span><span class="card-swatch-dot" style="background-color:#631d38;cursor:pointer;" title="Wine" onmouseover="window.TM.previewCardSwatch(7, 'Wine')"></span><span class="card-swatch-dot" style="background-color:#5a636d;cursor:pointer;" title="Steel Grey" onmouseover="window.TM.previewCardSwatch(7, 'Steel Grey')"></span><span class="card-swatch-dot" style="background-color:#946f7f;cursor:pointer;" title="Mauve" onmouseover="window.TM.previewCardSwatch(7, 'Mauve')"></span><span class="card-swatch-dot" style="background-color:#1a1a1a;cursor:pointer;" title="Black" onmouseover="window.TM.previewCardSwatch(7, 'Black')"></span>
              
            </div>
            <div style="display:flex;gap:6px;margin-top:0.75rem;">
              <button type="button" class="btn-secondary" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;" onclick="window.TM.addToCart(7)">
                Add to Bag
              </button>
              <a href="product.php?id=7" class="cart-checkout-btn" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
                Details
              </a>
            </div>
          </div>
        </div>
        <div class="product-card" data-product-id="8" id="card-prod-8">
          <div class="card-media-box">
            <a href="product.php?id=8" style="display:block;width:100%;height:100%;">
              <img src="https://knyamed.com/cdn/shop/files/11-12392-Recovereda.jpg?v=1739900756&width=832" class="card-img-primary" id="card-img-8" alt="ecoflex™ Men's V-Neck (Navy) Scrub" loading="lazy">
              <img src="https://knyamed.com/cdn/shop/files/ecoflexfabriccompositionandtech_NavyBlue.png?v=1776248509&width=832" class="card-img-hover" alt="ecoflex™ Men's V-Neck (Navy) Scrub" loading="lazy">
            </a>
            <button type="button" class="card-wishlist-btn" data-product-id="8" onclick="window.TM.toggleWishlist(8)" title="Add to Wishlist">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            </button>
            <button type="button" class="card-quickview-btn" onclick="window.TM.openQuickView(8)">Quick View</button>
          </div>
          <div class="card-details">
            <div class="card-rating-row">
              <svg class="star-icon" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              <span class="rating-value">4.9</span>
              <span>(1890)</span>
            </div>
            <a href="product.php?id=8" class="card-title">ecoflex™ Men's V-Neck (Navy) Scrub</a>
            <div class="card-price-row">
              <span class="sale-price">₹2,499</span>
              <span class="mrp-price">₹3,499</span>
              <span class="discount-badge">29% OFF</span>
            </div>
            <div class="card-swatches-row">
              <span class="card-swatch-dot" style="background-color:#1c2447;cursor:pointer;" title="Navy Blue" onmouseover="window.TM.previewCardSwatch(8, 'Navy Blue')"></span><span class="card-swatch-dot" style="background-color:#631d38;cursor:pointer;" title="Wine" onmouseover="window.TM.previewCardSwatch(8, 'Wine')"></span><span class="card-swatch-dot" style="background-color:#5a636d;cursor:pointer;" title="Steel Grey" onmouseover="window.TM.previewCardSwatch(8, 'Steel Grey')"></span><span class="card-swatch-dot" style="background-color:#1a1a1a;cursor:pointer;" title="Black" onmouseover="window.TM.previewCardSwatch(8, 'Black')"></span>
              
            </div>
            <div style="display:flex;gap:6px;margin-top:0.75rem;">
              <button type="button" class="btn-secondary" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;" onclick="window.TM.addToCart(8)">
                Add to Bag
              </button>
              <a href="product.php?id=8" class="cart-checkout-btn" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
                Details
              </a>
            </div>
          </div>
        </div>
        <div class="product-card" data-product-id="9" id="card-prod-9">
          <div class="card-media-box">
            <a href="product.php?id=9" style="display:block;width:100%;height:100%;">
              <img src="https://knyamed.com/cdn/shop/files/122THDECKANYA-1177a.jpg?v=1739900705&width=832" class="card-img-primary" id="card-img-9" alt="ecoflex™ Men's V-Neck (Wine) Scrub" loading="lazy">
              <img src="https://knyamed.com/cdn/shop/files/ecoflex_fabric_composition_and_tech_Wine.png?v=1773831010&width=832" class="card-img-hover" alt="ecoflex™ Men's V-Neck (Wine) Scrub" loading="lazy">
            </a>
            <button type="button" class="card-wishlist-btn" data-product-id="9" onclick="window.TM.toggleWishlist(9)" title="Add to Wishlist">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            </button>
            <button type="button" class="card-quickview-btn" onclick="window.TM.openQuickView(9)">Quick View</button>
          </div>
          <div class="card-details">
            <div class="card-rating-row">
              <svg class="star-icon" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              <span class="rating-value">4.8</span>
              <span>(730)</span>
            </div>
            <a href="product.php?id=9" class="card-title">ecoflex™ Men's V-Neck (Wine) Scrub</a>
            <div class="card-price-row">
              <span class="sale-price">₹2,499</span>
              <span class="mrp-price">₹3,499</span>
              <span class="discount-badge">29% OFF</span>
            </div>
            <div class="card-swatches-row">
              <span class="card-swatch-dot" style="background-color:#631d38;cursor:pointer;" title="Wine" onmouseover="window.TM.previewCardSwatch(9, 'Wine')"></span><span class="card-swatch-dot" style="background-color:#1c2447;cursor:pointer;" title="Navy Blue" onmouseover="window.TM.previewCardSwatch(9, 'Navy Blue')"></span><span class="card-swatch-dot" style="background-color:#5a636d;cursor:pointer;" title="Steel Grey" onmouseover="window.TM.previewCardSwatch(9, 'Steel Grey')"></span>
              
            </div>
            <div style="display:flex;gap:6px;margin-top:0.75rem;">
              <button type="button" class="btn-secondary" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;" onclick="window.TM.addToCart(9)">
                Add to Bag
              </button>
              <a href="product.php?id=9" class="cart-checkout-btn" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
                Details
              </a>
            </div>
          </div>
        </div>
        <div class="product-card" data-product-id="10" id="card-prod-10">
          <div class="card-media-box">
            <a href="product.php?id=10" style="display:block;width:100%;height:100%;">
              <img src="https://knyamed.com/cdn/shop/files/117THDECKANYA2022-37757a_c245c457-288a-415d-8677-6c690810c22b.jpg?v=1739900710&width=832" class="card-img-primary" id="card-img-10" alt="ecoflex™ Women's V-Neck (Wine) Scrub" loading="lazy">
              <img src="https://knyamed.com/cdn/shop/files/ecoflex_fabric_composition_and_tech_Wine.png?v=1773831010&width=832" class="card-img-hover" alt="ecoflex™ Women's V-Neck (Wine) Scrub" loading="lazy">
            </a>
            <button type="button" class="card-wishlist-btn" data-product-id="10" onclick="window.TM.toggleWishlist(10)" title="Add to Wishlist">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            </button>
            <button type="button" class="card-quickview-btn" onclick="window.TM.openQuickView(10)">Quick View</button>
          </div>
          <div class="card-details">
            <div class="card-rating-row">
              <svg class="star-icon" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              <span class="rating-value">4.9</span>
              <span>(1105)</span>
            </div>
            <a href="product.php?id=10" class="card-title">ecoflex™ Women's V-Neck (Wine) Scrub</a>
            <div class="card-price-row">
              <span class="sale-price">₹2,499</span>
              <span class="mrp-price">₹3,499</span>
              <span class="discount-badge">29% OFF</span>
            </div>
            <div class="card-swatches-row">
              <span class="card-swatch-dot" style="background-color:#631d38;cursor:pointer;" title="Wine" onmouseover="window.TM.previewCardSwatch(10, 'Wine')"></span><span class="card-swatch-dot" style="background-color:#5a636d;cursor:pointer;" title="Steel Grey" onmouseover="window.TM.previewCardSwatch(10, 'Steel Grey')"></span><span class="card-swatch-dot" style="background-color:#1c2447;cursor:pointer;" title="Navy Blue" onmouseover="window.TM.previewCardSwatch(10, 'Navy Blue')"></span>
              
            </div>
            <div style="display:flex;gap:6px;margin-top:0.75rem;">
              <button type="button" class="btn-secondary" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;" onclick="window.TM.addToCart(10)">
                Add to Bag
              </button>
              <a href="product.php?id=10" class="cart-checkout-btn" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
                Details
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================================
       11. NEW ARRIVALS: STETHOSCOPES & FOOTWEAR
       ========================================================== -->
  <section class="section-wrapper" id="stethoscope-section">
    <div class="container">
      <div class="section-header" style="display:flex;justify-content:space-between;align-items:flex-end;text-align:left;">
        <div>
          <h2 class="section-title">Shop Stethoscope &amp; Footwear</h2>
          <p class="section-subtitle">Brilliant acoustics • Innovative design • 30-Day Free Trial</p>
        </div>
        <a href="category.php?cat=Stethoscope" style="font-weight:700;color:var(--tm-primary);font-size:0.9375rem;text-decoration:underline;">View All Equipment →</a>
      </div>

      <div class="product-grid" id="stethoscope-products-grid">
        <div class="product-card" data-product-id="13" id="card-prod-13">
          <div class="card-media-box">
            <a href="product.php?id=13" style="display:block;width:100%;height:100%;">
              <img src="https://knyamed.com/cdn/shop/files/1_986b919b-9e67-4d3b-9c61-194170fabb2a.png?v=1778146597&width=832" class="card-img-primary" id="card-img-13" alt="6sense (Black), All Black Finish Stethoscope" loading="lazy">
              <img src="https://knyamed.com/cdn/shop/files/2_447810e4-5896-408b-be4f-2f80e10a3f6e.png?v=1778146598&width=832" class="card-img-hover" alt="6sense (Black), All Black Finish Stethoscope" loading="lazy">
            </a>
            <button type="button" class="card-wishlist-btn" data-product-id="13" onclick="window.TM.toggleWishlist(13)" title="Add to Wishlist">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            </button>
            <button type="button" class="card-quickview-btn" onclick="window.TM.openQuickView(13)">Quick View</button>
          </div>
          <div class="card-details">
            <div class="card-rating-row">
              <svg class="star-icon" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              <span class="rating-value">4.9</span>
              <span>(1420)</span>
            </div>
            <a href="product.php?id=13" class="card-title">6sense (Black), All Black Finish Stethoscope</a>
            <div class="card-price-row">
              <span class="sale-price">₹2,599</span>
              <span class="mrp-price">₹3,999</span>
              <span class="discount-badge">35% OFF</span>
            </div>
            <div class="card-swatches-row">
              <span class="card-swatch-dot" style="background-color:#1a1a1a;cursor:pointer;" title="Matte Black" onmouseover="window.TM.previewCardSwatch(13, 'Matte Black')"></span><span class="card-swatch-dot" style="background-color:#1c2447;cursor:pointer;" title="Steel Navy" onmouseover="window.TM.previewCardSwatch(13, 'Steel Navy')"></span><span class="card-swatch-dot" style="background-color:#8a3324;cursor:pointer;" title="Rose Gold Maroon" onmouseover="window.TM.previewCardSwatch(13, 'Rose Gold Maroon')"></span>
              
            </div>
            <div style="display:flex;gap:6px;margin-top:0.75rem;">
              <button type="button" class="btn-secondary" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;" onclick="window.TM.addToCart(13)">
                Add to Bag
              </button>
              <a href="product.php?id=13" class="cart-checkout-btn" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
                Details
              </a>
            </div>
          </div>
        </div>
        <div class="product-card" data-product-id="14" id="card-prod-14">
          <div class="card-media-box">
            <a href="product.php?id=14" style="display:block;width:100%;height:100%;">
              <img src="https://knyamed.com/cdn/shop/files/1_8d8a9e66-cb99-4b6f-be14-739e815ddebe.png?v=1780654325&width=832" class="card-img-primary" id="card-img-14" alt="6sense lite - High Acoustic Stethoscope" loading="lazy">
              <img src="https://knyamed.com/cdn/shop/files/2_babba0b2-ba54-4594-8901-8c357b0850c8.png?v=1780654325&width=832" class="card-img-hover" alt="6sense lite - High Acoustic Stethoscope" loading="lazy">
            </a>
            <button type="button" class="card-wishlist-btn" data-product-id="14" onclick="window.TM.toggleWishlist(14)" title="Add to Wishlist">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            </button>
            <button type="button" class="card-quickview-btn" onclick="window.TM.openQuickView(14)">Quick View</button>
          </div>
          <div class="card-details">
            <div class="card-rating-row">
              <svg class="star-icon" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              <span class="rating-value">4.8</span>
              <span>(950)</span>
            </div>
            <a href="product.php?id=14" class="card-title">6sense lite - High Acoustic Stethoscope</a>
            <div class="card-price-row">
              <span class="sale-price">₹1,899</span>
              <span class="mrp-price">₹2,899</span>
              <span class="discount-badge">34% OFF</span>
            </div>
            <div class="card-swatches-row">
              <span class="card-swatch-dot" style="background-color:#2b2b2b;cursor:pointer;" title="Steel Black" onmouseover="window.TM.previewCardSwatch(14, 'Steel Black')"></span><span class="card-swatch-dot" style="background-color:#1c2447;cursor:pointer;" title="Steel Navy" onmouseover="window.TM.previewCardSwatch(14, 'Steel Navy')"></span>
              
            </div>
            <div style="display:flex;gap:6px;margin-top:0.75rem;">
              <button type="button" class="btn-secondary" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;" onclick="window.TM.addToCart(14)">
                Add to Bag
              </button>
              <a href="product.php?id=14" class="cart-checkout-btn" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
                Details
              </a>
            </div>
          </div>
        </div>
        <div class="product-card" data-product-id="15" id="card-prod-15">
          <div class="card-media-box">
            <a href="product.php?id=15" style="display:block;width:100%;height:100%;">
              <img src="https://knyamed.com/cdn/shop/files/1_701862ab-2972-4a0c-a685-eb651779d3c4.png?v=1778146687&width=832" class="card-img-primary" id="card-img-15" alt="6sense Paeds (Rose Gold Maroon) Pediatric Stethoscope" loading="lazy">
              <img src="https://knyamed.com/cdn/shop/files/2_027b772a-d723-44e5-aee1-49e0c41b83cf.png?v=1778146686&width=832" class="card-img-hover" alt="6sense Paeds (Rose Gold Maroon) Pediatric Stethoscope" loading="lazy">
            </a>
            <button type="button" class="card-wishlist-btn" data-product-id="15" onclick="window.TM.toggleWishlist(15)" title="Add to Wishlist">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            </button>
            <button type="button" class="card-quickview-btn" onclick="window.TM.openQuickView(15)">Quick View</button>
          </div>
          <div class="card-details">
            <div class="card-rating-row">
              <svg class="star-icon" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              <span class="rating-value">4.9</span>
              <span>(780)</span>
            </div>
            <a href="product.php?id=15" class="card-title">6sense Paeds (Rose Gold Maroon) Pediatric Stethoscope</a>
            <div class="card-price-row">
              <span class="sale-price">₹2,599</span>
              <span class="mrp-price">₹3,999</span>
              <span class="discount-badge">35% OFF</span>
            </div>
            <div class="card-swatches-row">
              <span class="card-swatch-dot" style="background-color:#8a3324;cursor:pointer;" title="Rose Gold Maroon" onmouseover="window.TM.previewCardSwatch(15, 'Rose Gold Maroon')"></span>
              
            </div>
            <div style="display:flex;gap:6px;margin-top:0.75rem;">
              <button type="button" class="btn-secondary" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;" onclick="window.TM.addToCart(15)">
                Add to Bag
              </button>
              <a href="product.php?id=15" class="cart-checkout-btn" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
                Details
              </a>
            </div>
          </div>
        </div>
        <div class="product-card" data-product-id="16" id="card-prod-16">
          <div class="card-media-box">
            <a href="product.php?id=16" style="display:block;width:100%;height:100%;">
              <img src="https://knyamed.com/cdn/shop/files/Category_Image_1c081ffd-41d9-4779-8f98-721cd95e9913.png?v=1792663079" class="card-img-primary" id="card-img-16" alt="TRADE MEDS Pro Comfort Medical Clogs" loading="lazy">
              <img src="https://knyamed.com/cdn/shop/files/Clogs_Website_Asset_Desktop_Banner.png?v=1792665264&width=1500" class="card-img-hover" alt="TRADE MEDS Pro Comfort Medical Clogs" loading="lazy">
            </a>
            <button type="button" class="card-wishlist-btn" data-product-id="16" onclick="window.TM.toggleWishlist(16)" title="Add to Wishlist">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            </button>
            <button type="button" class="card-quickview-btn" onclick="window.TM.openQuickView(16)">Quick View</button>
          </div>
          <div class="card-details">
            <div class="card-rating-row">
              <svg class="star-icon" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              <span class="rating-value">4.9</span>
              <span>(830)</span>
            </div>
            <a href="product.php?id=16" class="card-title">TRADE MEDS Pro Comfort Medical Clogs</a>
            <div class="card-price-row">
              <span class="sale-price">₹1,999</span>
              <span class="mrp-price">₹2,799</span>
              <span class="discount-badge">28% OFF</span>
            </div>
            <div class="card-swatches-row">
              <span class="card-swatch-dot" style="background-color:#1c2447;cursor:pointer;" title="Midnight Navy" onmouseover="window.TM.previewCardSwatch(16, 'Midnight Navy')"></span><span class="card-swatch-dot" style="background-color:#ffffff;cursor:pointer;" title="Pure White" onmouseover="window.TM.previewCardSwatch(16, 'Pure White')"></span><span class="card-swatch-dot" style="background-color:#1a1a1a;cursor:pointer;" title="Matte Black" onmouseover="window.TM.previewCardSwatch(16, 'Matte Black')"></span>
              
            </div>
            <div style="display:flex;gap:6px;margin-top:0.75rem;">
              <button type="button" class="btn-secondary" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;" onclick="window.TM.addToCart(16)">
                Add to Bag
              </button>
              <a href="product.php?id=16" class="cart-checkout-btn" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
                Details
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================================
       12. MID-PAGE INSTITUTIONAL / BULK BANNER
       ========================================================== -->
  <section class="container" id="bulk-banner">
    <div class="bulk-order-banner">
      <picture>
        <source media="(max-width: 768px)" srcset="https://knyamed.com/cdn/shop/files/Bulk_Order_Mobile_Banner_32_BIT_3_21e7062b-516d-439c-8f67-d705af117d27.png?v=1754895252&width=600">
        <img src="https://knyamed.com/cdn/shop/files/Bulk_Order_Desktop_Banner_32_BIT_1_211d66de-3a7d-4616-9e2d-0ab3cc10ff21.png?v=1754894435&width=1500" alt="Bulk Orders & Custom Hospital Embroidery - TRADE MEDS">
      </picture>
    </div>
  </section>

  <!-- ==========================================================
       13. BRAND / INSTITUTIONAL PARTNERS CAROUSEL
       ========================================================== -->
  <section class="institutions-section">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Institutions we have served</h2>
        <p class="section-subtitle">We’ve suited up the best healthcare systems across India</p>
      </div>

      <div class="institutions-marquee">
        <div class="institutions-track">
          <div class="institution-logo"><img src="https://knyamed.com/cdn/shop/files/Fortis-Logo_d4cf71d7-2953-4cc3-ab53-c2e07c2e12ce.png?v=1783414487&width=500" alt="Fortis"></div>
          <div class="institution-logo"><img src="https://knyamed.com/cdn/shop/files/apolloLogo.webp?v=1758976511&width=500" alt="Apollo Hospitals"></div>
          <div class="institution-logo"><img src="https://knyamed.com/cdn/shop/files/narayana-logo_cb308ba3-80ad-4d83-b7f8-67310fdf8dd3.png?v=1769582030&width=500" alt="Narayana Health"></div>
          <div class="institution-logo"><img src="https://knyamed.com/cdn/shop/files/Reliance_c2a8f3f3-684e-4783-b65b-f07e845c2bf2.png?v=1783414901&width=500" alt="Reliance Foundation Hospital"></div>
          <div class="institution-logo"><img src="https://knyamed.com/cdn/shop/files/image_25_1_98fd2179-358b-492e-9cca-ba2ce33d970f.png?v=1769582040&width=500" alt="AIIMS"></div>
          <div class="institution-logo"><img src="https://knyamed.com/cdn/shop/files/supertails-logo_1200x_2b246d4b-7c96-4a28-9ca5-a96699ee9b9f.jpg?v=1783414692&width=500" alt="Veterinary Partners"></div>
          
          <!-- Duplicate for seamless loop -->
          <div class="institution-logo"><img src="https://knyamed.com/cdn/shop/files/Fortis-Logo_d4cf71d7-2953-4cc3-ab53-c2e07c2e12ce.png?v=1783414487&width=500" alt="Fortis"></div>
          <div class="institution-logo"><img src="https://knyamed.com/cdn/shop/files/apolloLogo.webp?v=1758976511&width=500" alt="Apollo Hospitals"></div>
          <div class="institution-logo"><img src="https://knyamed.com/cdn/shop/files/narayana-logo_cb308ba3-80ad-4d83-b7f8-67310fdf8dd3.png?v=1769582030&width=500" alt="Narayana Health"></div>
          <div class="institution-logo"><img src="https://knyamed.com/cdn/shop/files/Reliance_c2a8f3f3-684e-4783-b65b-f07e845c2bf2.png?v=1783414901&width=500" alt="Reliance Foundation Hospital"></div>
          <div class="institution-logo"><img src="https://knyamed.com/cdn/shop/files/image_25_1_98fd2179-358b-492e-9cca-ba2ce33d970f.png?v=1769582040&width=500" alt="AIIMS"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================================
       14. IN THE NEWS / MEDIA SECTION
       ========================================================== -->
  <section class="news-section">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">In the news</h2>
        <p class="section-subtitle">How TRADE MEDS is transforming medical apparel across the healthcare ecosystem</p>
      </div>

      <div class="news-grid">
        <div class="news-card">
          <div class="news-card-logo">
            <img src="https://knyamed.com/cdn/shop/files/In-the-news_-section-icon-1-TOI_300x120_08c4a138-c257-4c5c-bbe8-a71bf5a25d9a.png?v=1685962653&width=200" alt="Times of India">
          </div>
          <p class="news-quote">"How technology and specialized high-performance fabrics are democratising healthcare apparel in India."</p>
          <a href="https://timesofindia.indiatimes.com" target="_blank" class="news-read-more">Read More →</a>
        </div>

        <div class="news-card">
          <div class="news-card-logo">
            <img src="https://knyamed.com/cdn/shop/files/Forbes_India_Logo_200200_1.png?v=1712127276&width=200" alt="Forbes India">
          </div>
          <p class="news-quote">"Featured in Forbes India 30 Under 30 for revolutionary work in functional doctor scrubs and hospital wear."</p>
          <a href="https://www.forbesindia.com" target="_blank" class="news-read-more">Read More →</a>
        </div>

        <div class="news-card">
          <div class="news-card-logo">
            <img src="https://knyamed.com/cdn/shop/files/In-the-news_-section-icon-5-economic-times_300x120_29509605-a446-46a0-8f1a-49e3248d66ec.png?v=1685962654&width=200" alt="The Economic Times">
          </div>
          <p class="news-quote">"The evolution of medical apparel in India: Moving from ill-fitting cotton scrubs to high-grade technical textiles."</p>
          <a href="https://economictimes.indiatimes.com" target="_blank" class="news-read-more">Read More →</a>
        </div>

        <div class="news-card">
          <div class="news-card-logo">
            <img src="https://knyamed.com/cdn/shop/files/In-the-news_-section-icon-2-the-better-india_300x120_d172dba0-dc1c-492f-bda1-e9b8b1e0ddd7.png?v=1685962654&width=200" alt="The Better India">
          </div>
          <p class="news-quote">"Duo makes eco-friendly, durable scrubs for doctors and nurses using recycled plastic bottles."</p>
          <a href="https://www.thebetterindia.com" target="_blank" class="news-read-more">Read More →</a>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================================
       15. JOIN TRADE MEDS CLUB (LOYALTY PROGRAM)
       ========================================================== -->
  <section class="join-club-section" id="join-club">
    <div class="club-inner">
      <div>
        <h2 class="club-title">Join the TRADE MEDS Club</h2>
        <p class="club-desc">Earn points every time you shop. Unlock free name embroidery, priority hospital delivery, and exclusive early access to new color launches.</p>
        <div class="club-perks-row">
          <div class="club-perk-item">
            <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span>Earn 5% Back in Store Credits</span>
          </div>
          <div class="club-perk-item">
            <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span>Free Name &amp; Dept Embroidery</span>
          </div>
          <div class="club-perk-item">
            <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span>Invites to Vitals Medico Summit</span>
          </div>
        </div>
      </div>
      <div>
        <button type="button" class="club-cta-btn" onclick="window.TM.openModal('auth-modal')">Join Now • It's Free</button>
      </div>
    </div>
  </section>

  <!-- ==========================================================
       16. CUSTOMER TESTIMONIALS & REVIEWS
       ========================================================== -->
  <section class="testimonials-section">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Verified Doctor Reviews</h2>
        <p class="section-subtitle">Real experiences from healthcare professionals in operating rooms and ICUs</p>
      </div>

      <!-- Trust Social Proof Bar -->
      <div class="reviews-trust-bar">
        <div class="trust-stat">
          <span class="trust-score">4.9</span>
          <div class="trust-stars-box">
            <div class="review-stars" style="display:inline-flex;gap:2px;color:#f59e0b;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <div class="trust-caption">Over 10,000+ 5-Star Doctor Ratings</div>
          </div>
        </div>
        <div class="trust-divider"></div>
        <div class="trust-tag-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
          <span>AIIMS, Apollo, Fortis &amp; Manipal Doctors</span>
        </div>
        <div class="trust-divider"></div>
        <div class="trust-tag-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
          <span>100% Medically Verified Purchases</span>
        </div>
      </div>

      <div class="reviews-grid">
        <!-- Review Card 1 -->
        <div class="review-card">
          <div class="review-doctor-header">
            <div class="doctor-avatar-box">
              <img src="https://knyamed.com/cdn/shop/files/456x500px-Dr-Mili-Dogra-Anesthesiology-Resident_ab4edce0-1b04-431e-b09f-678b766e87c7.jpg?v=1683281588&amp;width=380" alt="Dr. Mili Dogra" loading="lazy">
              <div class="doctor-avatar-badge" title="Verified Medical Practitioner">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
              </div>
            </div>
            <div class="doctor-meta-info">
              <div class="reviewer-name">Dr. Mili Dogra</div>
              <div class="reviewer-specialty">Anesthesiology Resident</div>
              <div class="reviewer-hospital">AIIMS Hospital, New Delhi</div>
            </div>
          </div>

          <div class="review-rating-row">
            <div class="review-stars" style="display:inline-flex;gap:2px;color:#f59e0b;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <span class="review-verified-badge"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:-1px;margin-right:3px;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>Verified Buyer</span>
          </div>

          <div class="review-product-tag">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
            <span>Wears: ecoflex™ Scrub Suit (Navy Blue)</span>
          </div>

          <p class="review-text">"The ecoflex™ scrubs are a game changer for 14-hour orthopedic surgery shifts. Zero tightness at the shoulders, and the fabric doesn't absorb hospital smells or fluids even after marathon OT sessions."</p>

          <div class="review-card-footer">
            <span class="review-highlight-pill"><svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:-1px;margin-right:2px;"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>4-Way Stretch Tech</span>
            <span>Reviewed 2 days ago</span>
          </div>
        </div>

        <!-- Review Card 2 -->
        <div class="review-card">
          <div class="review-doctor-header">
            <div class="doctor-avatar-box">
              <img src="https://knyamed.com/cdn/shop/files/250x250px-Dr-Prateek-Makwana-Fertility-Specialist_a197c02e-7b83-4940-9671-8086c30a1ba4.jpg?v=1683282037&amp;width=200" alt="Dr. Prateek Makwana" loading="lazy">
              <div class="doctor-avatar-badge" title="Verified Medical Practitioner">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
              </div>
            </div>
            <div class="doctor-meta-info">
              <div class="reviewer-name">Dr. Prateek Makwana</div>
              <div class="reviewer-specialty">Fertility &amp; Embryology Specialist</div>
              <div class="reviewer-hospital">Vasundhara IVF, Mumbai</div>
            </div>
          </div>

          <div class="review-rating-row">
            <div class="review-stars" style="display:inline-flex;gap:2px;color:#f59e0b;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <span class="review-verified-badge"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:-1px;margin-right:3px;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>Verified Buyer</span>
          </div>

          <div class="review-product-tag">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4.5 3v5a4.5 4.5 0 0 0 9 0V3M18 10a4 4 0 0 1-4 4h-.5a4.5 4.5 0 0 1-4.5-4.5V3M20 10a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/></svg>
            <span>Uses: 6sense Precision Stethoscope (Matte Black)</span>
          </div>

          <p class="review-text">"I ordered the 6sense Stethoscope in All-Black finish. The acoustic amplification is astonishingly sharp, easily on par with international brands costing three times more. A true clinical masterpiece."</p>

          <div class="review-card-footer">
            <span class="review-highlight-pill"><svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:-1px;margin-right:2px;"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>Acoustic Clarity</span>
            <span>Reviewed 1 week ago</span>
          </div>
        </div>

        <!-- Review Card 3 -->
        <div class="review-card">
          <div class="review-doctor-header">
            <div class="doctor-avatar-box">
              <img src="https://knyamed.com/cdn/shop/files/250x250px-Dr-Shivani-Agarwal-OBGYN-Resident_b2b80249-328c-4def-8586-69e27aea3814.jpg?v=1683282037&amp;width=200" alt="Dr. Shivani Agarwal" loading="lazy">
              <div class="doctor-avatar-badge" title="Verified Medical Practitioner">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
              </div>
            </div>
            <div class="doctor-meta-info">
              <div class="reviewer-name">Dr. Shivani Agarwal</div>
              <div class="reviewer-specialty">OBGYN Resident</div>
              <div class="reviewer-hospital">Apollo Speciality Hospitals, Kolkata</div>
            </div>
          </div>

          <div class="review-rating-row">
            <div class="review-stars" style="display:inline-flex;gap:2px;color:#f59e0b;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <span class="review-verified-badge"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:-1px;margin-right:3px;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>Verified Buyer</span>
          </div>

          <div class="review-product-tag">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
            <span>Wears: Classic Women's Scrub Suit (Wine Red) + Embroidery</span>
          </div>

          <p class="review-text">"Our entire OBGYN department ordered matching wine-red scrubs with custom doctor embroidery. The fabric withstands commercial autoclave washing without fading or shrinking. Five stars!"</p>

          <div class="review-card-footer">
            <span class="review-highlight-pill"><svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:-1px;margin-right:2px;"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>Autoclave-Safe</span>
            <span>Reviewed 3 weeks ago</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================================
       17. SEEN IN TRADE MEDS SOCIAL MEDIA GALLERY
       ========================================================== -->
  <section class="seen-in-section">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Seen in TRADE MEDS</h2>
        <p class="section-subtitle">Over 10,000+ 5-star reviews and counting • Tag @TradeMedsOfficial on Instagram</p>
      </div>

      <div class="seen-in-grid">
        <div class="social-card">
          <img src="https://knyamed.com/cdn/shop/files/456x500px-Dr-Mili-Dogra-Anesthesiology-Resident_ab4edce0-1b04-431e-b09f-678b766e87c7.jpg?v=1683281588&width=380" alt="Dr Mili Dogra" loading="lazy">
          <div class="social-card-overlay">
            <span class="social-card-name">Dr. Mili Dogra</span>
            <span class="social-card-role">Anesthesiology</span>
          </div>
        </div>

        <div class="social-card">
          <img src="https://knyamed.com/cdn/shop/files/250x250px-Dr-Shivani-Agarwal-OBGYN-Resident_b2b80249-328c-4def-8586-69e27aea3814.jpg?v=1683282037&width=200" alt="Dr Shivani Agarwal" loading="lazy">
          <div class="social-card-overlay">
            <span class="social-card-name">Dr. Shivani Agarwal</span>
            <span class="social-card-role">OBGYN Resident</span>
          </div>
        </div>

        <div class="social-card">
          <img src="https://knyamed.com/cdn/shop/files/250x250px-Dr-Prateek-Makwana-Fertility-Specialist_a197c02e-7b83-4940-9671-8086c30a1ba4.jpg?v=1683282037&width=200" alt="Dr Prateek Makwana" loading="lazy">
          <div class="social-card-overlay">
            <span class="social-card-name">Dr. Prateek Makwana</span>
            <span class="social-card-role">Fertility Specialist</span>
          </div>
        </div>

        <div class="social-card">
          <img src="https://knyamed.com/cdn/shop/files/456x500px--Himanshu-Sharma-Anesthesia-student_b22c703a-6fe1-4719-849a-95b3dafbb119.jpg?v=1683281588&width=380" alt="Himanshu Sharma" loading="lazy">
          <div class="social-card-overlay">
            <span class="social-card-name">Himanshu Sharma</span>
            <span class="social-card-role">Anesthesia Student</span>
          </div>
        </div>

        <div class="social-card">
          <img src="https://knyamed.com/cdn/shop/files/250x250px-Hema-Rawat-RN-_Registered-Nurse_3b45a6ee-e518-4fa4-9d0b-5e78859cdbef.jpg?v=1683282106&width=200" alt="Hema Rawat" loading="lazy">
          <div class="social-card-overlay">
            <span class="social-card-name">Hema Rawat</span>
            <span class="social-card-role">Registered Nurse</span>
          </div>
        </div>

        <div class="social-card">
          <img src="https://knyamed.com/cdn/shop/files/250x250px-mitali-sharma-Medical-student_41a67f1f-bf98-4982-ab7e-04c79049b88d.jpg?v=1683282106&width=200" alt="Mitali Sharma" loading="lazy">
          <div class="social-card-overlay">
            <span class="social-card-name">Mitali Sharma</span>
            <span class="social-card-role">Medical Student</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================================
       18. SEO CONTENT ACCORDION SECTION
       ========================================================== -->
  <section class="seo-content-section">
    <div class="container">
      <div class="seo-card">
        <h2>TRADE MEDS: Stylish &amp; Functional Medical Scrubs, Lab Coats, and Stethoscopes for Men &amp; Women!</h2>
        
        <div id="seo-collapsed-content" class="seo-text-collapsed">
          <h3>Introduction:</h3>
          <p>TRADE MEDS is your premier destination for top-quality medical scrubs, consultant lab coats, and underscrubs for healthcare professionals across India. We believe every doctor, surgeon, nurse, and medical student deserves comfortable, flexible, and breathable medical apparel that also projects an impeccably professional clinical image.</p>

          <h3>Medical Scrub Suits for Men and Women</h3>
          <p>Experience the perfect fusion of functionality and contemporary medical fashion. Crafted from our signature polyester-viscose and ecoflex™ blends, our scrubs offer superior comfort, fluid-barrier protection, and practical utility for high-stress hospital routines.</p>

          <h3>Types of Scrubs for Healthcare Heroes:</h3>
          <ul>
            <li><strong>V-Neck Scrubs:</strong> Clean, modern, flattering V-neck cut tailored with reinforced stitching and pen pockets.</li>
            <li><strong>Mandarin Collar Scrubs:</strong> Sophisticated standing collar scrubs for senior consultants and clinical directors.</li>
            <li><strong>ecoflex™ 4-Way Stretch Scrubs:</strong> Created from recycled PET bottles with moisture-wicking and fluid-repellent finish.</li>
            <li><strong>Full-Sleeve Scrubs:</strong> Maximum coverage and barrier protection for critical ICU and infectious disease wards.</li>
          </ul>

          <h3>Lab Coat Aprons for Doctors and Consultants</h3>
          <p>Our lab coats blend distinguished authority with practical storage. Made from high-density stain-resistant poly-cotton twill with dedicated iPad pockets, interior phone holders, and stethoscope loops.</p>

          <h3>TRADE MEDS 6sense Stethoscopes</h3>
          <p>Building on our mission to provide complete solutions for medical professionals, the 6sense Stethoscope features aerospace-grade acoustic diaphragms for exceptional auscultation clarity, backed by a 30-day trial and 5-year replacement warranty.</p>
        </div>

        <button type="button" id="seo-toggle-btn" class="seo-toggle-btn">Read More ▼</button>
      </div>
    </div>
  </section>

  <!-- ==========================================================
       19. NEWSLETTER SUBSCRIPTION SECTION
       ========================================================== -->
  <section class="newsletter-section">
    <div class="container">
      <div class="newsletter-box">
        <h2 class="newsletter-title">Subscribe to the TRADE MEDS Letter</h2>
        <p class="newsletter-sub">Get early access to limited edition scrub colors, clinical style guides, and an instant <strong>12% OFF coupon</strong> on your first order.</p>

        <form class="newsletter-form">
          <input type="email" class="newsletter-input" placeholder="Enter your hospital or personal email..." required>
          <button type="submit" class="newsletter-btn">Claim 12% Off</button>
        </form>
        <span style="font-size:0.75rem;color:var(--tm-text-secondary);">We respect your privacy. Zero spam, unsubscribe at any time.</span>
      </div>
    </div>
  </section>

  <!-- ==========================================================
       20. COMPLETE ENHANCED MEDICAL FOOTER
       ========================================================== -->

<?php
require_once __DIR__ . '/includes/footer.php';
?>
