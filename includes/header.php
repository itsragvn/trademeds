<?php
if (!defined('TRADE_MEDS_INIT')) {
    require_once __DIR__ . '/../config.php';
}

$pageTitle = $pageTitle ?? "Buy Scrubs Online, Lab Coats, Doctor's Aprons & Medical Apparel – TRADE MEDS";
$pageDesc = $pageDesc ?? "TRADE MEDS is India's leading medical apparel brand. Buy stylish, comfortable medical scrubs, lab coats, doctor's aprons, and 6sense stethoscopes online.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <meta name="description" content="<?= htmlspecialchars($pageDesc) ?>">
  <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
  <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
  <link rel="shortcut icon" href="favicon.ico">
  
  <!-- Google Fonts: Heebo (Exact font used in reference knyamed.com) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

  <!-- ==========================================================
       1. TOP PROMOTIONAL ANNOUNCEMENT BARS
       ========================================================== -->
  <aside class="top-announcements-wrapper" aria-label="Store Announcements">
    <!-- Top Urgent Stock / Flash Sale Strip -->
    <div class="announcement-bar-flash">
      <div class="container announcement-flash-inner">
        <span class="flash-tag">LIMITED STOCK</span>
        <span class="flash-text">Special Launch Offer: Flat <strong>12% OFF</strong> on all Scrubs &amp; Lab Coats | Code: <strong class="coupon-code">FLASH12</strong></span>
        <a href="#join-club" class="flash-link">Join Medico Club →</a>
      </div>
    </div>

    <!-- Infinite Scrolling Medical USP Strip -->
    <div class="announcement-marquee" aria-hidden="true">
      <div class="marquee-track">
        <span class="marquee-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:-2px;margin-right:6px;"><path d="M12 2l2.4 7.2L22 12l-7.6 2.8L12 22l-2.4-7.2L2 12l7.6-2.8z"/></svg> Free Pan-India Delivery Above ₹1,499</span>
        <span class="marquee-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:-2px;margin-right:6px;"><path d="M12 2l2.4 7.2L22 12l-7.6 2.8L12 22l-2.4-7.2L2 12l7.6-2.8z"/></svg> Over 1,00,000+ Indian Doctors &amp; Surgeons Trust TRADE MEDS</span>
        <span class="marquee-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:-2px;margin-right:6px;"><path d="M12 2l2.4 7.2L22 12l-7.6 2.8L12 22l-2.4-7.2L2 12l7.6-2.8z"/></svg> Custom Doctor Name &amp; Hospital Logo Embroidery</span>
        <span class="marquee-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:-2px;margin-right:6px;"><path d="M12 2l2.4 7.2L22 12l-7.6 2.8L12 22l-2.4-7.2L2 12l7.6-2.8z"/></svg> 7 Days Easy Doorstep Return &amp; Size Exchange</span>
        <span class="marquee-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:-2px;margin-right:6px;"><path d="M12 2l2.4 7.2L22 12l-7.6 2.8L12 22l-2.4-7.2L2 12l7.6-2.8z"/></svg> Made with High-Density Fluid-Barrier &amp; 4-Way Stretch Tech</span>

        <!-- Duplicated for seamless infinite loop -->
        <span class="marquee-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:-2px;margin-right:6px;"><path d="M12 2l2.4 7.2L22 12l-7.6 2.8L12 22l-2.4-7.2L2 12l7.6-2.8z"/></svg> Free Pan-India Delivery Above ₹1,499</span>
        <span class="marquee-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:-2px;margin-right:6px;"><path d="M12 2l2.4 7.2L22 12l-7.6 2.8L12 22l-2.4-7.2L2 12l7.6-2.8z"/></svg> Over 1,00,000+ Indian Doctors &amp; Surgeons Trust TRADE MEDS</span>
        <span class="marquee-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:-2px;margin-right:6px;"><path d="M12 2l2.4 7.2L22 12l-7.6 2.8L12 22l-2.4-7.2L2 12l7.6-2.8z"/></svg> Custom Doctor Name &amp; Hospital Logo Embroidery</span>
        <span class="marquee-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:-2px;margin-right:6px;"><path d="M12 2l2.4 7.2L22 12l-7.6 2.8L12 22l-2.4-7.2L2 12l7.6-2.8z"/></svg> 7 Days Easy Doorstep Return &amp; Size Exchange</span>
        <span class="marquee-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:-2px;margin-right:6px;"><path d="M12 2l2.4 7.2L22 12l-7.6 2.8L12 22l-2.4-7.2L2 12l7.6-2.8z"/></svg> Made with High-Density Fluid-Barrier &amp; 4-Way Stretch Tech</span>
      </div>
    </div>
  </aside>

  <!-- ==========================================================
       2. PRIMARY STICKY BRAND HEADER
       ========================================================== -->
  <header class="site-header" id="site-header">
    <div class="container header-inner">
      <!-- Mobile Hamburger Button -->
      <button type="button" class="mobile-menu-toggle" id="mobile-menu-btn" onclick="window.TM.openMobileMenu()" aria-label="Open Navigation Menu">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
      </button>

      <!-- Brand Identity Logo -->
      <a href="index.php" class="header-logo" title="TRADE MEDS - Engineered For Healers">
        <img src="images/trade-meds-logo/trade-meds.png" alt="TRADE MEDS" class="header-logo-img" style="height:46px;max-height:46px;width:auto;max-width:180px;object-fit:contain;">
      </a>

      <!-- Live Interactive Predictive Search Bar -->
      <div class="header-search" id="header-search-container">
        <form class="search-form" id="search-form" action="category.php" method="GET" onsubmit="return window.TM.handleSearchSubmit(event)">
          <div class="search-input-wrapper">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="11" r="8"></circle>
              <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" name="search" id="live-search-input" class="search-input" 
                   placeholder="Search for '6sense Stethoscope'..." 
                   autocomplete="off" 
                   oninput="window.TM.handleSearchInput(event)"
                   onfocus="window.TM.showSearchSuggestions(true)"
                   aria-label="Search Trade Meds Products">
            <button type="button" class="search-clear-btn" id="search-clear-btn" onclick="window.TM.clearSearch()" style="display:none;" aria-label="Clear Search Input">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
          </div>
        </form>

        <!-- Search Autocomplete Suggestions Popup -->
        <div class="search-results-overlay" id="search-suggestions-box" style="display:none;">
          <div class="search-results-list" id="search-results-list"></div>
        </div>
      </div>

      <!-- Action Icons: Doctor Profile, Wishlist, Slide-Over Cart -->
      <div class="header-actions">
        <!-- Account Trigger -->
        <div class="action-item" id="user-account-action">
          <a href="javascript:void(0)" onclick="window.TM.handleAccountClick()" class="action-btn" title="Doctor Account">
            <div class="action-icon-box">
              <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
            </div>
            <span class="action-label" id="header-user-name">Hi Medico</span>
          </a>
        </div>

        <!-- Wishlist Trigger -->
        <div class="action-item">
          <button type="button" class="action-btn" onclick="window.TM.openWishlistModal()" title="View Wishlist">
            <div class="action-icon-box">
              <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"></path>
              </svg>
              <span class="badge-count" id="wishlist-badge-count">0</span>
            </div>
            <span class="action-label">Wishlist</span>
          </button>
        </div>

        <!-- Bag / Cart Slide-Over Trigger -->
        <div class="action-item">
          <button type="button" class="action-btn" id="header-cart-btn" onclick="window.TM.openCartDrawer()" title="Shopping Bag">
            <div class="action-icon-box">
              <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"></path>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <path d="M16 10a4 4 0 01-8 0"></path>
              </svg>
              <span class="badge-count" id="cart-badge-count">0</span>
            </div>
            <span class="action-label">Bag</span>
          </button>
        </div>
      </div>
    </div>

    <!-- ==========================================================
         3. DESKTOP MAIN NAVIGATION MENU (EXACT KNYAMED REFERENCE CATEGORIES)
         ========================================================== -->
    <nav class="site-nav" aria-label="Main Navigation">
      <div class="container site-nav-container">
        <ul class="nav-list">
          <!-- 1. WOMEN -->
          <li class="nav-item">
            <a href="category.php?gender=Women" class="nav-link">
              Women
              <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 5.5L7 9.5L3 5.5"/></svg>
            </a>
            <div class="mega-menu-wrapper">
              <div class="mega-menu-container">
                <aside class="mega-col-left">
                  <h4 class="mega-heading">Women's Medical Attire</h4>
                  <p>
                    Ergonomically tailored scrubs &amp; coats designed for Indian healthcare heroes.
                  </p>
                  <div class="mega-quick-links">
                    <a href="category.php?gender=Women">View All Women's Scrubs</a>
                    <a href="category.php?cat=ecoflex-scrubs&gender=Women">ecoflex™ 4-Way Stretch</a>
                    <a href="category.php?cat=Classic+Scrubs&gender=Women">Classic Poly-Viscose</a>
                    <a href="category.php?cat=Lab+Coats">Doctor Aprons &amp; Lab Coats</a>
                    <a href="category.php?cat=Underscrubs">Warm-Up Under-Scrubs</a>
                  </div>
                </aside>

                <div class="mega-col-center" style="grid-template-columns: repeat(3, 1fr);">
                  <!-- Col 1: Scrubs -->
                  <div class="category-column">
                    <div class="category-card-media">
                      <img src="https://knyamed.com/cdn/shop/files/1_36_f708815d-e636-4d70-af59-b4c8dbdc1e7d.jpg?v=1739900782&width=832" alt="Scrubs for Women" loading="lazy" style="object-fit:cover;object-position:top center;">
                    </div>
                    <h5 class="category-col-title">Scrubs</h5>
                    <div class="category-col-links">
                      <a href="product.php?id=1">Classic Women Navy V-Neck</a>
                      <a href="product.php?id=3">Classic Women Wine V-Neck</a>
                      <a href="product.php?id=7">ecoflex™ Women Navy</a>
                      <a href="product.php?id=10">ecoflex™ Women Wine</a>
                      <a href="category.php?gender=Women" style="font-weight:700;color:var(--tm-primary);">All Women Scrubs →</a>
                    </div>
                  </div>

                  <!-- Col 2: Lab Coats -->
                  <div class="category-column">
                    <div class="category-card-media">
                      <img src="https://knyamed.com/cdn/shop/files/Lab_Coats_-_Aprons_a3e923c1-fb7c-4288-bf4e-b2faa2e66ef7.png?v=1784716095&width=800" alt="Lab Coats for Women" loading="lazy" style="object-fit:contain;padding:10px 14px;background:#f8fafc;">
                    </div>
                    <h5 class="category-col-title">Lab Coats &amp; Aprons</h5>
                    <div class="category-col-links">
                      <a href="product.php?id=11">Chief Labcoat (Long Sleeves)</a>
                      <a href="product.php?id=12">Focus Labcoat (Full Sleeves)</a>
                      <a href="category.php?cat=Lab+Coats" style="font-weight:700;color:var(--tm-primary);">Explore All Coats →</a>
                    </div>
                  </div>

                  <!-- Col 3: Stethoscopes -->
                  <div class="category-column">
                    <div class="category-card-media">
                      <img src="https://knyamed.com/cdn/shop/files/1_986b919b-9e67-4d3b-9c61-194170fabb2a.png?v=1778146597&width=832" alt="Stethoscopes" loading="lazy" style="object-fit:contain;padding:10px 14px;background:#f8fafc;">
                    </div>
                    <h5 class="category-col-title">Stethoscopes</h5>
                    <div class="category-col-links">
                      <a href="product.php?id=13">6sense All Black Finish</a>
                      <a href="product.php?id=14">6sense Lite Ward Model</a>
                      <a href="product.php?id=15">6sense Paeds Rose Gold</a>
                      <a href="category.php?cat=Stethoscope" style="font-weight:700;color:var(--tm-primary);">View 6sense Lineup →</a>
                    </div>
                  </div>
                </div>

                <div class="mega-col-right">
                  <div class="mega-promo-card">
                    <img src="https://knyamed.com/cdn/shop/files/1a3O1A8835.jpg?v=1739900851&width=832" alt="Women Promo">
                    <div class="mega-promo-overlay">
                      <h4 class="mega-promo-title">Classic Women Scrub</h4>
                      <p class="mega-promo-sub">Engineered with high fluid-barrier poly blend.</p>
                      <a href="product.php?id=1" class="mega-promo-btn">Shop Classic</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </li>

          <!-- 2. MEN -->
          <li class="nav-item">
            <a href="category.php?gender=Men" class="nav-link">
              Men
              <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 5.5L7 9.5L3 5.5"/></svg>
            </a>
            <div class="mega-menu-wrapper">
              <div class="mega-menu-container">
                <aside class="mega-col-left">
                  <h4 class="mega-heading">Men's Medical Attire</h4>
                  <p>
                    Athletic cuts, deep cargo pockets, and fluid repellent tech for surgery shifts.
                  </p>
                  <div class="mega-quick-links">
                    <a href="category.php?gender=Men">View All Men's Scrubs</a>
                    <a href="category.php?cat=ecoflex-scrubs&gender=Men">ecoflex™ 4-Way Stretch</a>
                    <a href="category.php?cat=Classic+Scrubs&gender=Men">Classic Poly-Viscose</a>
                    <a href="category.php?cat=Lab+Coats">Men's Lab Coats</a>
                  </div>
                </aside>

                <div class="mega-col-center" style="grid-template-columns: repeat(3, 1fr);">
                  <!-- Col 1: Men's Scrubs -->
                  <div class="category-column">
                    <div class="category-card-media">
                      <img src="https://knyamed.com/cdn/shop/files/11TH_MAY_KNYA-1595_2.jpg?v=1739900798&width=832" alt="Men Scrubs" loading="lazy" style="object-fit:cover;object-position:top center;">
                    </div>
                    <h5 class="category-col-title">Men's Scrubs</h5>
                    <div class="category-col-links">
                      <a href="product.php?id=2">Classic Men's V-Neck</a>
                      <a href="product.php?id=8">ecoflex™ Men's V-Neck</a>
                      <a href="product.php?id=4">Men's Wine Scrub Top</a>
                      <a href="category.php?gender=Men" style="font-weight:700;color:var(--tm-primary);">All Men's Apparel →</a>
                    </div>
                  </div>

                  <!-- Col 2: Lab Coats & Aprons -->
                  <div class="category-column">
                    <div class="category-card-media">
                      <img src="https://knyamed.com/cdn/shop/files/Lab_Coats_-_Aprons_cce00cd9-d297-44f4-afa4-2372a831f785.png?v=1784715729&width=800" alt="Doctor Lab Coats" loading="lazy" style="object-fit:contain;padding:10px 14px;background:#f8fafc;">
                    </div>
                    <h5 class="category-col-title">Lab Coats &amp; Aprons</h5>
                    <div class="category-col-links">
                      <a href="product.php?id=11">Chief Doctor Apron</a>
                      <a href="product.php?id=12">Focus Consultant Coat</a>
                      <a href="product.php?id=16">Medical Footwear &amp; Clogs</a>
                      <a href="category.php?cat=Lab+Coats" style="font-weight:700;color:var(--tm-primary);">View Lab Coats →</a>
                    </div>
                  </div>

                  <!-- Col 3: Stethoscopes -->
                  <div class="category-column">
                    <div class="category-card-media">
                      <img src="https://knyamed.com/cdn/shop/files/1_986b919b-9e67-4d3b-9c61-194170fabb2a.png?v=1778146597&width=832" alt="Stethoscopes" loading="lazy" style="object-fit:contain;padding:10px 14px;background:#f8fafc;">
                    </div>
                    <h5 class="category-col-title">Stethoscopes</h5>
                    <div class="category-col-links">
                      <a href="product.php?id=13">6sense All Black</a>
                      <a href="product.php?id=14">6sense Lite</a>
                      <a href="product.php?id=15">6sense Paeds</a>
                      <a href="category.php?cat=Stethoscope" style="font-weight:700;color:var(--tm-primary);">Explore All Stethoscopes →</a>
                    </div>
                  </div>
                </div>

                <div class="mega-col-right">
                  <div class="mega-promo-card">
                    <img src="https://knyamed.com/cdn/shop/files/122THDECKANYA-1177a.jpg?v=1739900705&width=832" alt="Men ecoflex Promo">
                    <div class="mega-promo-overlay">
                      <h4 class="mega-promo-title">ecoflex™ Men Scrub</h4>
                      <p class="mega-promo-sub">Engineered for 14-hour orthopedic &amp; surgery shifts.</p>
                      <a href="product.php?id=8" class="mega-promo-btn">Shop ecoflex</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </li>

          <!-- 3. CLASSIC SCRUBS -->
          <li class="nav-item">
            <a href="category.php?cat=Classic+Scrubs" class="nav-link">Classic Scrubs</a>
          </li>

          <!-- 4. ECOFLEX SCRUBS -->
          <li class="nav-item">
            <a href="category.php?cat=ecoflex-scrubs" class="nav-link">
              ecoflex™
            </a>
            <div class="mega-menu-wrapper">
              <div class="mega-menu-container" style="grid-template-columns: 240px 1fr;">
                <aside class="mega-col-left">
                  <h4 class="mega-heading">Why ecoflex™?</h4>
                  <p>
                    Proprietary eco-yarn made from recycled PET bottles. 4-way stretch, ultra-lightweight, and fluid-repellent.
                  </p>
                  <div class="mega-quick-links">
                    <a href="category.php?cat=ecoflex-scrubs&gender=Women">Women's ecoflex™</a>
                    <a href="category.php?cat=ecoflex-scrubs&gender=Men">Men's ecoflex™</a>
                    <a href="category.php?cat=ecoflex-scrubs">All ecoflex™ Scrubs</a>
                  </div>
                </aside>
                <div class="mega-col-center" style="grid-template-columns: repeat(3, 1fr);">
                  <div class="category-column">
                    <div class="category-card-media">
                      <img src="https://knyamed.com/cdn/shop/files/All_Ecoflex_Collection_Page_Banner_Mob_aebe0264-3fe4-46ba-88eb-235a6a61c20c.png?v=1783071490&width=600" alt="ecoflex scrubs" loading="lazy" style="object-fit:cover;object-position:center center;">
                    </div>
                    <h5 class="category-col-title">ecoflex™ Scrubs</h5>
                    <p style="font-size:0.8125rem;color:var(--tm-text-secondary);margin-bottom:0.5rem;">4-Way Stretch • Anti-wrinkle • Fluid-barrier</p>
                    <a href="category.php?cat=ecoflex-scrubs" style="font-weight:700;color:var(--tm-primary);font-size:0.875rem;">Shop Collection →</a>
                  </div>
                  <div class="category-column">
                    <div class="category-card-media">
                      <img src="https://knyamed.com/cdn/shop/files/21st_Oct_Kanya-3116.jpg?v=1739900753&width=832" alt="Women ecoflex" loading="lazy" style="object-fit:cover;object-position:top center;">
                    </div>
                    <h5 class="category-col-title">Women's V-Neck</h5>
                    <p style="font-size:0.8125rem;color:var(--tm-text-secondary);margin-bottom:0.5rem;">Tailored fit with 4 hidden utility pockets</p>
                    <a href="product.php?id=7" style="font-weight:700;color:var(--tm-primary);font-size:0.875rem;">View Product →</a>
                  </div>
                  <div class="category-column">
                    <div class="category-card-media">
                      <img src="https://knyamed.com/cdn/shop/files/11-12392-Recovereda.jpg?v=1739900756&width=832" alt="Men ecoflex" loading="lazy" style="object-fit:cover;object-position:top center;">
                    </div>
                    <h5 class="category-col-title">Men's V-Neck</h5>
                    <p style="font-size:0.8125rem;color:var(--tm-text-secondary);margin-bottom:0.5rem;">Athletic ergonomic stretch design</p>
                    <a href="product.php?id=8" style="font-weight:700;color:var(--tm-primary);font-size:0.875rem;">View Product →</a>
                  </div>
                </div>
              </div>
            </div>
          </li>

          <!-- 5. 6SENSE STETHOSCOPES -->
          <li class="nav-item">
            <a href="category.php?cat=Stethoscope" class="nav-link">
              6sense
            </a>
            <div class="mega-menu-wrapper">
              <div class="mega-menu-container" style="grid-template-columns: 240px 1fr;">
                <aside class="mega-col-left">
                  <h4 class="mega-heading">Acoustic Precision</h4>
                  <p>
                    Brilliant acoustics engineered to auscultate the faintest heart murmurs and pulmonary sounds.
                  </p>
                  <div class="mega-quick-links">
                    <a href="category.php?cat=Stethoscope">30-Day Free Trial</a>
                    <a href="category.php?cat=Stethoscope">5-Year Warranty</a>
                    <a href="category.php?cat=Stethoscope">Free Name Engraving</a>
                  </div>
                </aside>
                <div class="mega-col-center" style="grid-template-columns: repeat(3, 1fr);">
                  <div class="category-column">
                    <div class="category-card-media">
                      <img src="https://knyamed.com/cdn/shop/files/1_986b919b-9e67-4d3b-9c61-194170fabb2a.png?v=1778146597&width=832" alt="6sense (All Black)" loading="lazy" style="object-fit:contain;padding:10px 14px;background:#f8fafc;">
                    </div>
                    <h5 class="category-col-title">6sense (All Black)</h5>
                    <p style="font-size:0.8125rem;color:var(--tm-text-secondary);margin-bottom:0.5rem;">All-Black Electroplated Titanium Finish</p>
                    <a href="product.php?id=13" style="font-weight:700;color:var(--tm-primary);font-size:0.875rem;">Explore • ₹2,599 →</a>
                  </div>
                  <div class="category-column">
                    <div class="category-card-media">
                      <img src="https://knyamed.com/cdn/shop/files/Collection_Banner_Grab_your_6sense_lite_mobile.png?v=1772606209&width=600" alt="6sense lite" loading="lazy" style="object-fit:cover;object-position:center center;">
                    </div>
                    <h5 class="category-col-title">6sense lite</h5>
                    <p style="font-size:0.8125rem;color:var(--tm-text-secondary);margin-bottom:0.5rem;">Featherweight design for non-stop ward wear</p>
                    <a href="product.php?id=14" style="font-weight:700;color:var(--tm-primary);font-size:0.875rem;">Explore • ₹1,899 →</a>
                  </div>
                  <div class="category-column">
                    <div class="category-card-media">
                      <img src="https://knyamed.com/cdn/shop/files/6sense_Rose_Gold_Collection_Page_Banner_All_Collection_Page_Mobile_2_83a61341-7f86-4646-900f-ce49e3a8cf98.png?v=1791872788&width=600" alt="6sense Paeds" loading="lazy" style="object-fit:cover;object-position:center center;">
                    </div>
                    <h5 class="category-col-title">6sense Paeds</h5>
                    <p style="font-size:0.8125rem;color:var(--tm-text-secondary);margin-bottom:0.5rem;">Pediatric &amp; Neonatal Calibrated</p>
                    <a href="product.php?id=15" style="font-weight:700;color:var(--tm-primary);font-size:0.875rem;">Explore • ₹2,599 →</a>
                  </div>
                </div>
              </div>
            </div>
          </li>

          <!-- 6. LAB COATS -->
          <li class="nav-item">
            <a href="category.php?cat=Lab+Coats" class="nav-link">Lab Coats</a>
          </li>

          <!-- 7. FOOTWEAR -->
          <li class="nav-item">
            <a href="category.php?cat=Footwear" class="nav-link">Footwear</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
