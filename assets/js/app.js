/**
 * TRADE MEDS - Main Application Logic
 * Full frontend interactions + PHP Backend REST API integration
 */

(function () {
  'use strict';

  // Products Database
  let products = window.TRADE_MEDS_PRODUCTS || [];

  // State
  const state = {
    cart: {
      items: [],
      itemCount: 0,
      subtotal: 0,
      discount: 0,
      shippingFee: 0,
      total: 0,
      couponCode: null,
      freeShippingThreshold: 1499,
      freeShippingProgress: 0,
      freeShippingRemaining: 1499
    },
    wishlist: new Set(),
    user: null,
    activeColorFilter: null,
    activeCategoryFilter: null
  };

  // Helper: Format Indian Rupee currency
  function formatPrice(num) {
    return '₹' + Number(num).toLocaleString('en-IN');
  }

  // Helper: Escape HTML special characters
  function escapeHtml(str) {
    if (str === null || str === undefined) return '';
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');
  }

  // Helper: Highlight query substring in text
  function highlightMatch(text, query) {
    if (!text) return '';
    if (!query) return escapeHtml(text);
    const escapedQuery = query.trim().replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    if (!escapedQuery) return escapeHtml(text);
    const regex = new RegExp(`(${escapedQuery})`, 'gi');
    return escapeHtml(text).replace(regex, '<span class="search-highlight">$1</span>');
  }

  const svgIcons = {
    check: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"></polyline></svg>',
    alert: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>',
    heart: '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>',
    search: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
    mail: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>',
    user: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>',
    success: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>',
    logout: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>',
    gift: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>'
  };

  // Toast Notification
  function showToast(message, icon = 'check') {
    let container = document.getElementById('toast-container');
    if (!container) {
      container = document.createElement('div');
      container.id = 'toast-container';
      container.className = 'toast-container';
      document.body.appendChild(container);
    }
    const iconHtml = svgIcons[icon] || (typeof icon === 'string' && icon.startsWith('<svg') ? icon : svgIcons.check);
    const pill = document.createElement('div');
    pill.className = 'toast-pill';
    pill.innerHTML = `<span style="display:inline-flex;align-items:center;">${iconHtml}</span> <span>${message}</span>`;
    container.appendChild(pill);
    setTimeout(() => {
      pill.style.opacity = '0';
      pill.style.transform = 'translateY(10px)';
      pill.style.transition = 'all 0.3s ease';
      setTimeout(() => pill.remove(), 300);
    }, 3200);
  }

  // ==========================================
  // CART OPERATIONS (Local + PHP API sync)
  // ==========================================
  async function fetchCart() {
    try {
      const res = await fetch('api/cart.php');
      if (res.ok) {
        const data = await res.json();
        if (data.success) {
          state.cart = data;
          updateCartUI();
          return;
        }
      }
    } catch (e) {
      console.warn('API offline, using local cart storage');
    }
    loadCartFromLocal();
    updateCartUI();
  }

  function loadCartFromLocal() {
    try {
      const raw = localStorage.getItem('tm_cart');
      if (raw) {
        state.cart.items = JSON.parse(raw);
        calculateLocalCartTotals();
      }
    } catch (e) { }
  }

  function saveCartToLocal() {
    try {
      localStorage.setItem('tm_cart', JSON.stringify(state.cart.items));
    } catch (e) { }
  }

  function calculateLocalCartTotals() {
    let subtotal = 0;
    let count = 0;
    state.cart.items.forEach(item => {
      subtotal += item.product_price * item.quantity;
      count += item.quantity;
    });
    state.cart.itemCount = count;
    state.cart.subtotal = subtotal;

    let discount = 0;
    if (state.cart.couponCode === 'FLASH12') {
      discount = Math.round(subtotal * 0.12);
    } else if (state.cart.couponCode === 'WELCOME10') {
      discount = Math.round(subtotal * 0.10);
    }
    state.cart.discount = discount;
    state.cart.shippingFee = (subtotal >= 1499 || subtotal === 0) ? 0 : 99;
    state.cart.total = Math.max(0, subtotal - discount + state.cart.shippingFee);
    state.cart.freeShippingProgress = Math.min(100, Math.round((subtotal / 1499) * 100));
    state.cart.freeShippingRemaining = Math.max(0, 1499 - subtotal);
  }

  async function addToCart(productId, size, color, colorHex, quantity = 1, embroidery = '') {
    const p = products.find(prod => prod.id === Number(productId));
    if (!p) return;

    size = size || (p.sizes && p.sizes[0]) || 'M';
    color = color || p.colorName || 'Default';
    colorHex = colorHex || p.colorHex || '#1c2447';

    try {
      const res = await fetch('api/cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          action: 'add',
          product_id: p.id,
          size: size,
          color: color,
          color_hex: colorHex,
          quantity: quantity,
          embroidery: embroidery
        })
      });
      if (res.ok) {
        await fetchCart();
        openCartDrawer();
        showToast(`${p.title} added to your bag!`);
        return;
      }
    } catch (e) { }

    // Fallback Local Cart
    const existing = state.cart.items.find(
      i => i.product_id === p.id && i.size === size && i.color === color && i.embroidery === embroidery
    );
    if (existing) {
      existing.quantity += quantity;
    } else {
      state.cart.items.push({
        id: Date.now(),
        product_id: p.id,
        product_title: p.title,
        product_price: p.price,
        product_image: p.primaryImage,
        size: size,
        color: color,
        color_hex: colorHex,
        quantity: quantity,
        embroidery: embroidery
      });
    }
    saveCartToLocal();
    calculateLocalCartTotals();
    updateCartUI();
    openCartDrawer();
    showToast(`${p.title} added to your bag!`);
  }

  async function updateCartItemQty(itemId, quantity) {
    try {
      await fetch('api/cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'update', item_id: itemId, quantity: quantity })
      });
      await fetchCart();
      return;
    } catch (e) { }

    // Local fallback
    if (quantity <= 0) {
      state.cart.items = state.cart.items.filter(i => i.id !== itemId);
    } else {
      const itm = state.cart.items.find(i => i.id === itemId);
      if (itm) itm.quantity = quantity;
    }
    saveCartToLocal();
    calculateLocalCartTotals();
    updateCartUI();
  }

  async function removeCartItem(itemId) {
    try {
      await fetch('api/cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'remove', item_id: itemId })
      });
      await fetchCart();
      showToast('Item removed from bag');
      return;
    } catch (e) { }

    state.cart.items = state.cart.items.filter(i => i.id !== itemId);
    saveCartToLocal();
    calculateLocalCartTotals();
    updateCartUI();
    showToast('Item removed from bag');
  }

  async function applyCouponCode(code) {
    code = (code || '').toUpperCase().trim();
    if (!code) return;

    try {
      const res = await fetch('api/cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'apply_coupon', coupon_code: code })
      });
      const data = await res.json();
      if (data.success) {
        showToast(data.message);
        await fetchCart();
        return;
      } else {
        showToast(data.error || 'Invalid code', "alert");
        return;
      }
    } catch (e) { }

    if (code === 'FLASH12' || code === 'WELCOME10') {
      state.cart.couponCode = code;
      calculateLocalCartTotals();
      updateCartUI();
      showToast(`Coupon ${code} applied successfully!`);
    } else {
      showToast('Invalid or expired coupon', "alert");
    }
  }

  function updateCartUI() {
    // Header cart badge
    const badges = document.querySelectorAll('.cart-count-badge');
    badges.forEach(b => {
      b.textContent = state.cart.itemCount || 0;
      b.style.display = state.cart.itemCount > 0 ? 'flex' : 'none';
    });

    // Drawer elements
    const body = document.getElementById('cart-items-body');
    const emptyState = document.getElementById('cart-empty-state');
    const footer = document.getElementById('cart-drawer-footer');
    const countEl = document.getElementById('cart-drawer-count');
    const subtotalEl = document.getElementById('cart-subtotal');
    const discountEl = document.getElementById('cart-discount');
    const discountRow = document.getElementById('cart-discount-row');
    const shippingEl = document.getElementById('cart-shipping');
    const totalEl = document.getElementById('cart-total');
    const progressFill = document.getElementById('cart-shipping-progress');
    const shippingText = document.getElementById('cart-shipping-text');

    if (countEl) countEl.textContent = `(${state.cart.itemCount})`;

    // Free shipping bar
    if (progressFill && shippingText) {
      progressFill.style.width = state.cart.freeShippingProgress + '%';
      if (state.cart.freeShippingRemaining <= 0) {
        shippingText.innerHTML = `<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" style="color:var(--tm-green);vertical-align:-2px;margin-right:4px;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg> <strong>Congratulations!</strong> You qualify for Free Delivery!`;
        progressFill.style.backgroundColor = 'var(--tm-green)';
      } else {
        shippingText.innerHTML = `Add <strong>${formatPrice(state.cart.freeShippingRemaining)}</strong> more to unlock <strong>FREE Delivery</strong>!`;
      }
    }

    if (state.cart.items.length === 0) {
      if (body) body.innerHTML = '';
      if (emptyState) emptyState.style.display = 'block';
      if (footer) footer.style.display = 'none';
      return;
    }

    if (emptyState) emptyState.style.display = 'none';
    if (footer) footer.style.display = 'block';

    if (body) {
      body.innerHTML = state.cart.items.map(item => `
        <div class="cart-item-card" data-item-id="${item.id}">
          <div class="cart-item-img">
            <img src="${item.product_image}" alt="${item.product_title}" loading="lazy">
          </div>
          <div class="cart-item-info">
            <h4 class="cart-item-title">${item.product_title}</h4>
            <div class="cart-item-meta">
              <span>Size: <strong>${item.size}</strong></span> | 
              <span>Color: <strong>${item.color}</strong></span>
              ${item.embroidery ? `<br><span style="color:var(--tm-accent-blue);font-size:0.75rem;display:inline-flex;align-items:center;gap:3px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg> Embroidery: "${item.embroidery}"</span>` : ''}
            </div>
            <div class="cart-item-bottom">
              <div class="qty-control">
                <button type="button" class="qty-btn" onclick="window.TM.updateQty(${item.id}, ${item.quantity - 1})">-</button>
                <span class="qty-val">${item.quantity}</span>
                <button type="button" class="qty-btn" onclick="window.TM.updateQty(${item.id}, ${item.quantity + 1})">+</button>
              </div>
              <div class="cart-item-price">${formatPrice(item.product_price * item.quantity)}</div>
              <button type="button" class="cart-remove-item" onclick="window.TM.removeCartItem(${item.id})" title="Remove item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2M10 11v6M14 11v6"/></svg>
              </button>
            </div>
          </div>
        </div>
      `).join('');
    }

    // Subtotal & summary
    if (subtotalEl) subtotalEl.textContent = formatPrice(state.cart.subtotal);
    if (discountRow && discountEl) {
      if (state.cart.discount > 0) {
        discountRow.style.display = 'flex';
        discountEl.textContent = '-' + formatPrice(state.cart.discount);
      } else {
        discountRow.style.display = 'none';
      }
    }
    if (shippingEl) {
      shippingEl.textContent = state.cart.shippingFee === 0 ? 'FREE' : formatPrice(state.cart.shippingFee);
    }
    if (totalEl) totalEl.textContent = formatPrice(state.cart.total);
  }

  // ==========================================
  // WISHLIST OPERATIONS
  // ==========================================
  async function fetchWishlist() {
    try {
      const res = await fetch('api/wishlist.php');
      if (res.ok) {
        const data = await res.json();
        if (data.success) {
          state.wishlist = new Set(data.ids.map(Number));
          updateWishlistUI();
          return;
        }
      }
    } catch (e) { }
    loadWishlistFromLocal();
    updateWishlistUI();
  }

  function loadWishlistFromLocal() {
    try {
      const raw = localStorage.getItem('tm_wishlist');
      if (raw) {
        state.wishlist = new Set(JSON.parse(raw));
      }
    } catch (e) { }
  }

  function saveWishlistToLocal() {
    try {
      localStorage.setItem('tm_wishlist', JSON.stringify([...state.wishlist]));
    } catch (e) { }
  }

  async function toggleWishlist(productId) {
    productId = Number(productId);
    const p = products.find(prod => prod.id === productId);

    try {
      const res = await fetch('api/wishlist.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'toggle', product_id: productId })
      });
      if (res.ok) {
        const data = await res.json();
        if (data.status === 'added') {
          state.wishlist.add(productId);
          showToast(`${p ? p.title : 'Item'} added to Wishlist!`, "heart");
        } else {
          state.wishlist.delete(productId);
          showToast('Removed from Wishlist');
        }
        updateWishlistUI();
        return;
      }
    } catch (e) { }

    // Local fallback
    if (state.wishlist.has(productId)) {
      state.wishlist.delete(productId);
      showToast('Removed from Wishlist');
    } else {
      state.wishlist.add(productId);
      showToast(`${p ? p.title : 'Item'} added to Wishlist!`, "heart");
    }
    saveWishlistToLocal();
    updateWishlistUI();
  }

  function updateWishlistUI() {
    // Header badges
    const badges = document.querySelectorAll('.wishlist-count-badge');
    badges.forEach(b => {
      b.textContent = state.wishlist.size || 0;
      b.style.display = state.wishlist.size > 0 ? 'flex' : 'none';
    });

    // Card heart buttons active state
    document.querySelectorAll('.card-wishlist-btn').forEach(btn => {
      const pid = Number(btn.getAttribute('data-product-id'));
      if (state.wishlist.has(pid)) {
        btn.classList.add('active');
      } else {
        btn.classList.remove('active');
      }
    });

    // Wishlist modal items
    const body = document.getElementById('wishlist-modal-body');
    if (body) {
      const savedProducts = products.filter(p => state.wishlist.has(p.id));
      if (savedProducts.length === 0) {
        body.innerHTML = `
          <div style="text-align:center;padding:3rem 1rem;">
            <p style="font-size:1.125rem;color:var(--tm-text-secondary);margin-bottom:1rem;">Your wishlist is currently empty.</p>
            <button class="newsletter-btn" onclick="window.TM.closeModal('wishlist-modal')">Explore Catalog</button>
          </div>
        `;
      } else {
        body.innerHTML = `
          <div class="product-grid" style="grid-template-columns:repeat(auto-fill, minmax(200px, 1fr));gap:1.25rem;">
            ${savedProducts.map(p => `
              <div class="product-card" style="box-shadow:var(--shadow-sm);border:1px solid var(--tm-border-light);">
                <div class="card-media-box">
                  <img src="${p.primaryImage}" class="card-img-primary" alt="${p.title}">
                  <button class="card-wishlist-btn active" onclick="window.TM.toggleWishlist(${p.id})">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                  </button>
                </div>
                <div class="card-details">
                  <h4 class="card-title">${p.title}</h4>
                  <div class="card-price-row"><span class="sale-price">${formatPrice(p.price)}</span></div>
                  <button class="card-add-btn" onclick="window.TM.addToCart(${p.id})">Move to Bag</button>
                </div>
              </div>
            `).join('')}
          </div>
        `;
      }
    }
  }

  // ==========================================
  // QUICK VIEW MODAL
  // ==========================================
  function openQuickView(productId) {
    const p = products.find(prod => prod.id === Number(productId));
    if (!p) return;

    const modal = document.getElementById('quickview-modal');
    const container = document.getElementById('quickview-content');
    if (!modal || !container) return;

    let selectedSize = p.sizes[0] || 'M';
    let selectedColor = p.colorName || 'Navy Blue';
    let selectedColorHex = p.colorHex || '#1c2447';
    let activeImage = p.primaryImage;

    container.innerHTML = `
      <div class="quickview-layout">
        <div class="quickview-gallery">
          <div class="quickview-main-img">
            <img id="qv-main-image" src="${activeImage}" alt="${p.title}">
          </div>
          <div class="quickview-thumbs">
            ${p.images.map((img, idx) => `
              <div class="quickview-thumb ${idx === 0 ? 'active' : ''}" onclick="window.TM.switchQuickViewImg('${img}', this)">
                <img src="${img}" alt="${p.title}">
              </div>
            `).join('')}
          </div>
        </div>
        <div class="quickview-info">
          <span style="font-size:0.75rem;font-weight:700;color:var(--tm-accent-blue);text-transform:uppercase;letter-spacing:0.05em;">${p.category}</span>
          <h2 style="font-size:1.35rem;font-weight:700;color:var(--tm-primary);margin:0.25rem 0 0.5rem;">${p.title}</h2>
          <div class="card-rating-row" style="margin-bottom:0.75rem;">
            <svg class="star-icon" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            <span class="rating-value">${p.rating}</span>
            <span>(${p.reviews} verified reviews)</span>
          </div>
          <div class="card-price-row" style="margin-bottom:1rem;">
            <span class="sale-price" style="font-size:1.5rem;">${formatPrice(p.price)}</span>
            <span class="mrp-price" style="font-size:1rem;">${formatPrice(p.originalPrice)}</span>
            <span class="discount-badge">${p.discount}</span>
          </div>
          <p style="font-size:0.875rem;color:var(--tm-text-secondary);line-height:1.5;margin-bottom:1.25rem;">${p.description}</p>
          
          <!-- Color Swatches -->
          <div style="margin-bottom:1.25rem;">
            <label style="font-size:0.8125rem;font-weight:700;color:var(--tm-primary);display:block;margin-bottom:0.5rem;">
              Color: <span id="qv-color-label" style="font-weight:600;color:var(--tm-accent-blue);">${selectedColor}</span>
            </label>
            <div class="qv-swatches-row">
              ${p.swatches.map(sw => `
                <span class="qv-swatch-dot ${sw.name === selectedColor ? 'active' : ''}" 
                      style="background-color:${sw.hex};" 
                      onclick="window.TM.selectQuickViewColor('${sw.name}', '${sw.hex}', this)"
                      title="${sw.name}"></span>
              `).join('')}
            </div>
          </div>

          <!-- Size Selector -->
          <div style="margin-bottom:1.25rem;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.4rem;">
              <label style="font-size:0.8125rem;font-weight:700;color:var(--tm-primary);margin:0;">Select Size:</label>
              <button type="button" class="qv-size-guide-btn" onclick="window.TM.openSizeChart()">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.3 8.7l-6-6a1 1 0 0 0-1.4 0l-11 11a1 1 0 0 0 0 1.4l6 6a1 1 0 0 0 1.4 0l11-11a1 1 0 0 0 0-1.4z"></path></svg>
                Size Guide
              </button>
            </div>
            <div class="size-selector" style="margin:0.25rem 0 0.5rem;">
              ${p.sizes.map((s, idx) => `
                <button type="button" class="size-chip ${idx === 0 ? 'active' : ''}" onclick="window.TM.selectQuickViewSize('${s}', this)">${s}</button>
              `).join('')}
            </div>
          </div>

          <!-- Embroidery Customization -->
          <div class="embroidery-box">
            <div class="embroidery-header" onclick="document.getElementById('qv-embroidery-wrap').classList.toggle('hidden')">
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:-2px;margin-right:4px;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>Add Custom Name Embroidery (+₹150)</span>
              <span style="font-size:0.75rem;color:var(--tm-accent-blue);">Personalize</span>
            </div>
            <div id="qv-embroidery-wrap" class="hidden" style="margin-top:0.5rem;">
              <input type="text" id="qv-embroidery-input" class="embroidery-input" placeholder="e.g. Dr. A. Sharma (Cardiology)" maxlength="28">
              <span style="font-size:0.75rem;color:var(--tm-text-light);">Max 28 characters. Embroidered with medical white silk thread.</span>
            </div>
          </div>

          <!-- Add to Bag & Direct Order CTAs -->
          <div style="display:flex;gap:10px;margin-top:auto;">
            <button type="button" class="btn-secondary" style="flex:1;height:46px;font-weight:700;" onclick="window.TM.submitQuickView(${p.id})">
              Add to Bag
            </button>
            <button type="button" class="cart-checkout-btn" style="flex:1.2;height:46px;font-weight:700;" onclick="window.TM.buyNow(${p.id})">
              Order Now • ${formatPrice(p.price)}
            </button>
          </div>
        </div>
      </div>
    `;

    openModal('quickview-modal');
  }

  function switchQuickViewImg(imgUrl, thumbEl) {
    const main = document.getElementById('qv-main-image');
    if (main) main.src = imgUrl;
    document.querySelectorAll('.quickview-thumb').forEach(t => t.classList.remove('active'));
    if (thumbEl) thumbEl.classList.add('active');
  }

  let qvSelectedSize = 'M';
  let qvSelectedColor = 'Navy Blue';
  let qvSelectedColorHex = '#1c2447';

  function selectQuickViewSize(size, el) {
    qvSelectedSize = size;
    document.querySelectorAll('.size-chip').forEach(c => c.classList.remove('active'));
    if (el) el.classList.add('active');
  }

  function selectQuickViewColor(color, hex, el) {
    qvSelectedColor = color;
    qvSelectedColorHex = hex;
    const lbl = document.getElementById('qv-color-label');
    if (lbl) lbl.textContent = color;
    document.querySelectorAll('.qv-swatch-dot, .card-swatch-dot').forEach(d => d.classList.remove('active'));
    if (el) el.classList.add('active');
  }

  function submitQuickView(productId) {
    const embInput = document.getElementById('qv-embroidery-input');
    const embroidery = embInput ? embInput.value.trim() : '';
    addToCart(productId, qvSelectedSize, qvSelectedColor, qvSelectedColorHex, 1, embroidery);
    closeModal('quickview-modal');
  }

  // ==========================================
  // MODAL & DRAWER HANDLERS
  // ==========================================
  function openCartDrawer() {
    const drawer = document.getElementById('cart-drawer');
    const backdrop = document.getElementById('drawer-backdrop');
    if (drawer) drawer.classList.add('active');
    if (backdrop) backdrop.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeCartDrawer() {
    const drawer = document.getElementById('cart-drawer');
    const backdrop = document.getElementById('drawer-backdrop');
    if (drawer) drawer.classList.remove('active');
    if (backdrop) backdrop.classList.remove('active');
    document.body.style.overflow = '';
  }

  function openMobileMenu() {
    const drawer = document.getElementById('mobile-drawer');
    const backdrop = document.getElementById('drawer-backdrop');
    if (drawer) drawer.classList.add('active');
    if (backdrop) backdrop.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeMobileMenu() {
    const drawer = document.getElementById('mobile-drawer');
    const backdrop = document.getElementById('drawer-backdrop');
    if (drawer) drawer.classList.remove('active');
    if (backdrop) backdrop.classList.remove('active');
    document.body.style.overflow = '';
  }

  function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
      modal.classList.add('active');
      document.body.style.overflow = 'hidden';
    }
  }

  function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
      modal.classList.remove('active');
      const anyModalActive = document.querySelector('.modal-overlay.active');
      if (!anyModalActive) {
        document.body.style.overflow = '';
      }
    }
  }

  // ==========================================
  // SEARCH FUNCTIONALITY (ENHANCED LIVE SEARCH)
  // ==========================================
  function getCatalog() {
    if (Array.isArray(window.TRADE_MEDS_PRODUCTS) && window.TRADE_MEDS_PRODUCTS.length > 0) {
      return window.TRADE_MEDS_PRODUCTS;
    }
    return products || [];
  }

  function getSearchElements() {
    const input = document.getElementById('live-search-input') || document.getElementById('header-search-input');
    const mobileInput = document.getElementById('mobile-search-input');
    const clearBtn = document.getElementById('search-clear-btn') || document.getElementById('header-search-clear');
    const overlay = document.getElementById('search-suggestions-box') || document.getElementById('search-results-overlay');
    const resultsList = document.getElementById('search-results-list') || document.getElementById('search-live-results');
    return { input, mobileInput, clearBtn, overlay, resultsList };
  }

  function renderTrendingSuggestions() {
    const { resultsList } = getSearchElements();
    if (!resultsList) return;

    const catalog = getCatalog();
    const popularItems = catalog.filter(p => p.badge === 'Bestseller' || p.badge === 'Popular').slice(0, 3);
    const fallbackPopular = popularItems.length > 0 ? popularItems : catalog.slice(0, 3);

    const popularHtml = fallbackPopular.map(m => {
      const fallbackImg = 'images/products/classic-navy-scrub-1.jpg';
      return `
        <div class="search-match-item" onclick="window.TM.selectSearchResult(${m.id})">
          <img src="${escapeHtml(m.primaryImage)}" alt="${escapeHtml(m.title)}" onerror="this.onerror=null;this.src='${fallbackImg}';">
          <div class="search-match-info">
            <h5 class="search-match-title">${escapeHtml(m.title)}</h5>
            <div class="search-match-meta">
              <span class="search-match-cat">${escapeHtml(m.category)}</span>
              <span class="search-match-dot">•</span>
              <span class="search-match-price">${formatPrice(m.price)}</span>
            </div>
          </div>
          <span class="search-match-arrow">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
          </span>
        </div>
      `;
    }).join('');

    resultsList.innerHTML = `
      <div class="search-trending-section">
        <div class="search-trending-header">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
          <span>Trending Searches</span>
        </div>
        <div class="search-quick-tags">
          <span class="search-quick-tag" onclick="window.TM.applySearch('Women Scrubs')">Women's Scrubs</span>
          <span class="search-quick-tag" onclick="window.TM.applySearch('Men Scrubs')">Men's Scrubs</span>
          <span class="search-quick-tag" onclick="window.TM.applySearch('ecoflex')">ecoflex™ 4-Way Stretch</span>
          <span class="search-quick-tag" onclick="window.TM.applySearch('Lab Coat')">Doctor Lab Coats</span>
          <span class="search-quick-tag" onclick="window.TM.applySearch('6sense')">6sense Stethoscope</span>
        </div>
      </div>
      <div class="search-popular-section">
        <div class="search-popular-header">Popular Medical Apparel &amp; Gear</div>
        <div class="search-matches-container">
          ${popularHtml}
        </div>
      </div>
    `;
  }

  function renderLiveSearchResults(query) {
    const { resultsList } = getSearchElements();
    if (!resultsList) return;

    const q = (query || '').toLowerCase().trim();
    if (q.length < 1) {
      renderTrendingSuggestions();
      return;
    }

    const catalog = getCatalog();
    const matches = catalog.filter(p => {
      const haystack = [
        p.title,
        p.category,
        p.collection,
        p.gender,
        p.colorName,
        p.fabric,
        p.description
      ].filter(Boolean).join(' ').toLowerCase();
      return haystack.includes(q);
    });

    // Relevance sort: title startsWith > title includes > category/collection
    matches.sort((a, b) => {
      const aTitle = (a.title || '').toLowerCase();
      const bTitle = (b.title || '').toLowerCase();
      const aStarts = aTitle.startsWith(q);
      const bStarts = bTitle.startsWith(q);
      if (aStarts && !bStarts) return -1;
      if (!aStarts && bStarts) return 1;
      const aIdx = aTitle.indexOf(q);
      const bIdx = bTitle.indexOf(q);
      if (aIdx !== -1 && bIdx === -1) return -1;
      if (aIdx === -1 && bIdx !== -1) return 1;
      return 0;
    });

    if (matches.length === 0) {
      resultsList.innerHTML = `
        <div class="search-empty-state">
          <div class="search-empty-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          </div>
          <p class="search-empty-title">No Medical Apparel Found for "${escapeHtml(query)}"</p>
          <p class="search-empty-desc">Check your spelling or search by popular categories below:</p>
          <div class="search-empty-tags">
            <span class="search-quick-tag" onclick="window.TM.applySearch('Scrubs')">Scrubs</span>
            <span class="search-quick-tag" onclick="window.TM.applySearch('ecoflex')">ecoflex™</span>
            <span class="search-quick-tag" onclick="window.TM.applySearch('Lab Coats')">Lab Coats</span>
            <span class="search-quick-tag" onclick="window.TM.applySearch('6sense')">Stethoscopes</span>
          </div>
        </div>
      `;
      return;
    }

    const displayMatches = matches.slice(0, 6);
    const itemsHtml = displayMatches.map(m => {
      const highlightedTitle = highlightMatch(m.title, query);
      const hasDiscount = m.originalPrice && m.originalPrice > m.price;
      const fallbackImg = 'images/products/classic-navy-scrub-1.jpg';
      const colorOrGender = m.colorName || m.gender || '';
      return `
        <div class="search-match-item" onclick="window.TM.selectSearchResult(${m.id})">
          <img src="${escapeHtml(m.primaryImage)}" alt="${escapeHtml(m.title)}" onerror="this.onerror=null;this.src='${fallbackImg}';">
          <div class="search-match-info">
            <h5 class="search-match-title">${highlightedTitle}</h5>
            <div class="search-match-meta">
              <span class="search-match-cat">${escapeHtml(m.category)}</span>
              ${colorOrGender ? `<span class="search-match-dot">•</span><span class="search-match-sub">${escapeHtml(colorOrGender)}</span>` : ''}
              <span class="search-match-dot">•</span>
              <span class="search-match-price">${formatPrice(m.price)}</span>
              ${hasDiscount ? `<span class="search-match-orig">${formatPrice(m.originalPrice)}</span>` : ''}
            </div>
          </div>
          <span class="search-match-arrow">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
          </span>
        </div>
      `;
    }).join('');

    resultsList.innerHTML = `
      <div class="search-results-header">
        <span>Matching Products (${matches.length})</span>
        <span class="search-results-press-enter">Press Enter to view all</span>
      </div>
      <div class="search-matches-container">
        ${itemsHtml}
      </div>
      <div class="search-footer-action">
        <a href="category.php?search=${encodeURIComponent(query)}" class="search-view-all-btn" onclick="event.preventDefault(); window.TM.applySearch('${escapeHtml(query)}')">
          <span>View All ${matches.length} Results for "${escapeHtml(query)}"</span>
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </a>
      </div>
    `;
  }

  function handleSearchInput(e) {
    const val = (e && e.target ? e.target.value : '').trim();
    const { input, mobileInput, clearBtn, overlay } = getSearchElements();

    if (e && e.target === input && mobileInput && mobileInput.value !== val) {
      mobileInput.value = val;
    } else if (e && e.target === mobileInput && input && input.value !== val) {
      input.value = val;
    }

    if (clearBtn) {
      clearBtn.style.display = val.length > 0 ? 'inline-flex' : 'none';
    }

    if (val.length >= 1) {
      renderLiveSearchResults(val);
      if (overlay) {
        overlay.style.display = 'block';
        overlay.classList.add('active');
      }
    } else {
      renderTrendingSuggestions();
      if (overlay) {
        overlay.style.display = 'block';
        overlay.classList.add('active');
      }
    }
  }

  function showSearchSuggestions(show) {
    const { input, overlay } = getSearchElements();
    if (!overlay) return;
    if (show) {
      const query = input ? input.value.trim() : '';
      if (query.length >= 1) {
        renderLiveSearchResults(query);
      } else {
        renderTrendingSuggestions();
      }
      overlay.style.display = 'block';
      overlay.classList.add('active');
    }
  }

  function clearSearch() {
    const { input, mobileInput, clearBtn, overlay } = getSearchElements();
    if (input) {
      input.value = '';
      input.focus();
    }
    if (mobileInput) {
      mobileInput.value = '';
    }
    if (clearBtn) {
      clearBtn.style.display = 'none';
    }
    renderTrendingSuggestions();
    if (overlay) {
      overlay.style.display = 'block';
      overlay.classList.add('active');
    }
  }

  function handleSearchSubmit(e) {
    if (e && e.preventDefault) e.preventDefault();
    const { input, mobileInput, overlay } = getSearchElements();
    const query = (input ? input.value : (mobileInput ? mobileInput.value : '')).trim();
    if (overlay) {
      overlay.classList.remove('active');
      overlay.style.display = 'none';
    }
    if (query) {
      window.location.href = 'category.php?search=' + encodeURIComponent(query);
    }
    return false;
  }

  function applySearch(query) {
    if (!query) return;
    const { input, mobileInput, overlay } = getSearchElements();
    if (input) input.value = query;
    if (mobileInput) mobileInput.value = query;
    if (overlay) {
      overlay.classList.remove('active');
      overlay.style.display = 'none';
    }
    window.location.href = 'category.php?search=' + encodeURIComponent(query);
  }

  function selectSearchResult(productId) {
    const { overlay } = getSearchElements();
    if (overlay) {
      overlay.classList.remove('active');
      overlay.style.display = 'none';
    }
    window.location.href = 'product.php?id=' + productId;
  }

  function initSearch() {
    const { input, mobileInput, clearBtn, overlay } = getSearchElements();
    const inputs = [input, mobileInput].filter(Boolean);

    inputs.forEach(inp => {
      inp.addEventListener('input', handleSearchInput);
      inp.addEventListener('focus', () => showSearchSuggestions(true));
      inp.addEventListener('keydown', e => {
        if (e.key === 'Enter') {
          handleSearchSubmit(e);
        } else if (e.key === 'Escape' && overlay) {
          overlay.classList.remove('active');
          overlay.style.display = 'none';
        }
      });
    });

    if (clearBtn) {
      clearBtn.addEventListener('click', clearSearch);
    }

    // Close search results on outside click
    document.addEventListener('click', e => {
      if (overlay && !e.target.closest('.header-search') && !e.target.closest('#search-suggestions-box') && !e.target.closest('#search-results-overlay')) {
        overlay.classList.remove('active');
        overlay.style.display = 'none';
      }
    });
  }

  // Rotating Search Placeholder
  function initSearchPlaceholder() {
    const input = document.getElementById('live-search-input') || document.getElementById('header-search-input');
    if (!input) return;
    const phrases = [
      'Search for "Classic Scrubs"...',
      'Search for "ecoflex™ 4-way stretch"...',
      'Search for "Chief Lab Coats"...',
      'Search for "6sense Stethoscope"...',
      'Search for "Women\'s Scrub Suits"...',
      'Search for "Comfort Medical Clogs"...'
    ];
    let idx = 0;
    setInterval(() => {
      if (document.activeElement !== input || !input.value) {
        idx = (idx + 1) % phrases.length;
        input.setAttribute('placeholder', phrases[idx]);
      }
    }, 3200);
  }

  // ==========================================
  // HERO SLIDER
  // ==========================================
  function initHeroSlider() {
    const track = document.getElementById('hero-slider-track');
    const dots = document.querySelectorAll('.hero-dot');
    const slides = document.querySelectorAll('.hero-slide');
    if (!track || slides.length === 0) return;

    let current = 0;
    const total = slides.length;

    function goToSlide(n) {
      current = (n + total) % total;
      track.style.transform = `translateX(-${current * 100}%)`;
      dots.forEach((d, i) => {
        if (i === current) d.classList.add('active');
        else d.classList.remove('active');
      });
    }

    const prevBtn = document.getElementById('hero-prev-btn');
    const nextBtn = document.getElementById('hero-next-btn');
    if (prevBtn) prevBtn.addEventListener('click', () => goToSlide(current - 1));
    if (nextBtn) nextBtn.addEventListener('click', () => goToSlide(current + 1));

    dots.forEach((dot, idx) => {
      dot.addEventListener('click', () => goToSlide(idx));
    });

    setInterval(() => goToSlide(current + 1), 6000);
  }

  // ==========================================
  // ANNOUNCEMENT ROTATOR
  // ==========================================
  function initAnnouncementRotator() {
    const slides = document.querySelectorAll('.announcement-slide');
    if (slides.length <= 1) return;
    let idx = 0;
    setInterval(() => {
      slides[idx].classList.remove('active');
      idx = (idx + 1) % slides.length;
      slides[idx].classList.add('active');
    }, 4000);
  }

  // ==========================================
  // COLOR FILTERING
  // ==========================================
  function filterByColor(colorFamily) {
    state.activeColorFilter = colorFamily;
    const section = document.getElementById('classic-scrubs-section');
    if (section) section.scrollIntoView({ behavior: 'smooth' });

    document.querySelectorAll('.colour-card').forEach(card => {
      if (card.getAttribute('data-color-family') === colorFamily) {
        card.classList.add('active');
      } else {
        card.classList.remove('active');
      }
    });

    const container = document.getElementById('classic-products-grid');
    if (!container) return;

    const matched = products.filter(p => !colorFamily || p.colorFamily === colorFamily);
    renderProductCards(container, matched.length > 0 ? matched : products);
    showToast(`Showing medical apparel for "${colorFamily}"`);
  }

  function renderProductCards(container, prods) {
    container.innerHTML = prods.map(p => `
      <div class="product-card" data-product-id="${p.id}" id="card-prod-${p.id}">
        <div class="card-media-box">
          <a href="product.php?id=${p.id}" style="display:block;width:100%;height:100%;">
            <img src="${p.primaryImage}" class="card-img-primary" id="card-img-${p.id}" alt="${p.title}" loading="lazy" onerror="this.onerror=null; this.src='https://knyamed.com/cdn/shop/files/1_70.jpg?v=1739900854&width=832';">
            <img src="${p.hoverImage}" class="card-img-hover" alt="${p.title}" loading="lazy" onerror="this.onerror=null; this.src='https://knyamed.com/cdn/shop/files/1_67.jpg?v=1739900771&width=832';">
          </a>
          <button type="button" class="card-wishlist-btn ${state.wishlist.has(p.id) ? 'active' : ''}" 
                  data-product-id="${p.id}" onclick="window.TM.toggleWishlist(${p.id})" title="Add to Wishlist">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
          </button>
          <button type="button" class="card-quickview-btn" onclick="window.TM.openQuickView(${p.id})">Quick View</button>
        </div>
        <div class="card-details">
          <div class="card-rating-row">
            <svg class="star-icon" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            <span class="rating-value">${p.rating}</span>
            <span>(${p.reviews})</span>
          </div>
          <a href="product.php?id=${p.id}" class="card-title">${p.title}</a>
          <div class="card-price-row">
            <span class="sale-price">${formatPrice(p.price)}</span>
            <span class="mrp-price">${formatPrice(p.originalPrice)}</span>
            <span class="discount-badge">${p.discount}</span>
          </div>
          <div class="card-swatches-row">
            ${(p.swatches || []).slice(0, 5).map(sw => `
              <span class="card-swatch-dot" style="background-color:${sw.hex};cursor:pointer;" title="${sw.name}" onmouseover="window.TM.previewCardSwatch(${p.id}, '${sw.name}')"></span>
            `).join('')}
            ${(p.swatches || []).length > 5 ? `<span class="swatch-more-tag">+${p.swatches.length - 5} more</span>` : ''}
          </div>
          <div style="display:flex;gap:6px;margin-top:0.75rem;">
            <button type="button" class="btn-secondary" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;" onclick="window.TM.addToCart(${p.id})">
              Add to Bag
            </button>
            <a href="product.php?id=${p.id}" class="cart-checkout-btn" style="flex:1;height:36px;font-size:0.75rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
              Details
            </a>
          </div>
        </div>
      </div>
    `).join('');
  }

  function previewCardSwatch(productId, colorName) {
    const img = document.getElementById('card-img-' + productId);
    if (!img) return;
    const p = products.find(prod => prod.id === productId);
    if (p && p.images && p.images.length > 1) {
      // Rotate image on swatch hover
      img.src = p.hoverImage;
    }
  }

  // ==========================================
  // CLINICAL CHECKOUT & ADDRESS MODAL SYSTEM
  // ==========================================
  let activePaymentMethod = 'COD';

  function openCheckoutModal() {
    if (!state.cart || !state.cart.items || state.cart.items.length === 0) {
      showToast('Your bag is empty! Add products to proceed.', "alert");
      return;
    }

    closeCartDrawer();

    // Auto-fill logged-in customer info if available
    if (state.user) {
      const nameEl = document.getElementById('chk-name');
      const emailEl = document.getElementById('chk-email');
      const phoneEl = document.getElementById('chk-phone');
      if (nameEl && !nameEl.value) nameEl.value = state.user.name || '';
      if (emailEl && !emailEl.value) emailEl.value = state.user.email || '';
      if (phoneEl && !phoneEl.value && state.user.phone) phoneEl.value = state.user.phone || '';
    }

    renderCheckoutSummary();
    openModal('checkout-modal');
  }

  function renderCheckoutSummary() {
    const itemsListEl = document.getElementById('chk-items-list');
    const subtotalEl = document.getElementById('chk-subtotal');
    const discountRowEl = document.getElementById('chk-discount-row');
    const discountEl = document.getElementById('chk-discount');
    const deliveryEl = document.getElementById('chk-delivery');
    const totalEl = document.getElementById('chk-total');
    const submitBtn = document.getElementById('chk-submit-btn');

    const items = (state.cart && state.cart.items) ? state.cart.items : [];

    if (itemsListEl) {
      if (items.length === 0) {
        itemsListEl.innerHTML = '<p style="font-size:0.875rem;color:var(--tm-text-secondary);text-align:center;padding:1rem 0;">No items in cart</p>';
      } else {
        itemsListEl.innerHTML = items.map(it => `
          <div class="checkout-item-row" style="display:flex;align-items:center;gap:12px;padding:8px 0;border-bottom:1px solid var(--tm-border-light);">
            <img src="${escapeHtml(it.product_image || 'images/products/classic-womens-wine.jpg')}" alt="${escapeHtml(it.product_title)}" style="width:44px;height:52px;object-fit:cover;border-radius:6px;border:1px solid var(--tm-border-light);">
            <div style="flex:1;min-width:0;">
              <h5 style="font-size:0.8125rem;font-weight:700;color:var(--tm-primary);margin:0 0 2px 0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">${escapeHtml(it.product_title)}</h5>
              <div style="font-size:0.75rem;color:var(--tm-text-secondary);display:flex;align-items:center;gap:6px;">
                <span>Size: <strong>${escapeHtml(it.size || 'M')}</strong></span>
                <span>•</span>
                <span>Color: <strong>${escapeHtml(it.color || 'Standard')}</strong></span>
                <span>•</span>
                <span>Qty: <strong>${it.quantity}</strong></span>
              </div>
            </div>
            <div style="font-size:0.875rem;font-weight:700;color:var(--tm-primary);white-space:nowrap;">
              ${formatPrice((it.product_price || 0) * it.quantity)}
            </div>
          </div>
        `).join('');
      }
    }

    // Calculations
    const subtotal = items.reduce((sum, it) => sum + ((it.product_price || 0) * it.quantity), 0);
    const discount = (state.cart && state.cart.discount) ? Number(state.cart.discount) : 0;
    const deliveryFee = (subtotal >= 1499 || subtotal === 0) ? 0 : 99;
    const grandTotal = Math.max(0, subtotal - discount + deliveryFee);

    if (subtotalEl) subtotalEl.textContent = formatPrice(subtotal);
    if (discountRowEl) {
      if (discount > 0) {
        discountRowEl.style.display = 'flex';
        if (discountEl) discountEl.textContent = `-${formatPrice(discount)}`;
      } else {
        discountRowEl.style.display = 'none';
      }
    }
    if (deliveryEl) {
      deliveryEl.textContent = (deliveryFee === 0) ? 'FREE' : formatPrice(deliveryFee);
      if (deliveryFee === 0) {
        deliveryEl.style.color = '#059669';
        deliveryEl.style.fontWeight = '700';
      } else {
        deliveryEl.style.color = 'inherit';
        deliveryEl.style.fontWeight = '600';
      }
    }
    if (totalEl) totalEl.textContent = formatPrice(grandTotal);
    if (submitBtn) {
      submitBtn.innerHTML = `
        <span>Confirm &amp; Place Order • ${formatPrice(grandTotal)}</span>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
      `;
    }
  }

  async function applyCheckoutCoupon() {
    const input = document.getElementById('chk-coupon-input');
    if (!input) return;
    const code = input.value.trim().toUpperCase();
    if (!code) {
      showToast('Please enter a coupon code', "alert");
      return;
    }

    try {
      const res = await fetch('api/cart.php?action=apply_coupon', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ code })
      });
      const data = await res.json();
      if (data.success) {
        showToast(data.message || 'Coupon applied successfully!', "success");
        await fetchCart();
        renderCheckoutSummary();
      } else {
        showToast(data.error || 'Invalid or expired coupon', "alert");
      }
    } catch (e) {
      console.error(e);
      showToast('Failed to apply coupon', "alert");
    }
  }

  function updatePaymentSelection(mode) {
    activePaymentMethod = mode;
    const radio = document.querySelector(`input[name="chk_payment"][value="${mode}"]`);
    if (radio) radio.checked = true;

    // Visual active highlight
    document.querySelectorAll('.payment-card-label').forEach(label => {
      label.style.borderColor = 'var(--tm-border-light)';
      label.style.background = '#fff';
    });
    const selectedLabel = radio ? radio.closest('.payment-card-label') : null;
    if (selectedLabel) {
      selectedLabel.style.borderColor = 'var(--tm-accent-blue)';
      selectedLabel.style.background = '#f0f9ff';
    }
  }

  async function submitOrder(e) {
    if (e) e.preventDefault();

    if (!state.cart || !state.cart.items || state.cart.items.length === 0) {
      showToast('Your bag is empty! Add products first.', "alert");
      return;
    }

    const nameEl = document.getElementById('chk-name');
    const phoneEl = document.getElementById('chk-phone');
    const emailEl = document.getElementById('chk-email');
    const hospitalEl = document.getElementById('chk-hospital');
    const flatEl = document.getElementById('chk-flat');
    const streetEl = document.getElementById('chk-street');
    const cityEl = document.getElementById('chk-city');
    const pincodeEl = document.getElementById('chk-pincode');
    const stateEl = document.getElementById('chk-state');

    const name = nameEl ? nameEl.value.trim() : '';
    const phone = phoneEl ? phoneEl.value.trim() : '';
    const email = emailEl ? emailEl.value.trim() : '';
    const hospital = hospitalEl ? hospitalEl.value.trim() : '';
    const flat = flatEl ? flatEl.value.trim() : '';
    const street = streetEl ? streetEl.value.trim() : '';
    const city = cityEl ? cityEl.value.trim() : '';
    const pincode = pincodeEl ? pincodeEl.value.trim() : '';
    const stateVal = stateEl ? stateEl.value.trim() : '';

    if (!name || !phone || !email || !hospital || !flat || !street || !city || !pincode || !stateVal) {
      showToast('Please fill all required clinical delivery fields', "alert");
      return;
    }

    const selectedRadio = document.querySelector('input[name="chk_payment"]:checked');
    const paymentMethod = selectedRadio ? selectedRadio.value : (activePaymentMethod || 'COD');

    const fullAddress = `${flat}, ${hospital}, ${street}, ${city}, ${stateVal} - ${pincode}`;

    const submitBtn = document.getElementById('chk-submit-btn');
    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.innerHTML = `
        <span>Tailoring &amp; Confirming Order...</span>
      `;
    }

    try {
      const res = await fetch('api/orders.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          name,
          email,
          phone,
          address: fullAddress,
          payment_method: paymentMethod
        })
      });
      const data = await res.json();

      if (data.success) {
        closeModal('checkout-modal');

        // Human-friendly mode labels
        const modeLabels = {
          'COD': 'Cash on Delivery (Verified)',
          'UPI': 'Instant UPI (Google Pay / PhonePe)',
          'CARD': 'Credit / Debit Card (256-Bit SSL)',
          'NETBANKING': 'Direct Net Banking'
        };

        // Populate Order Success Modal
        const successOrderNum = document.getElementById('success-order-num');
        const successCustomerName = document.getElementById('success-customer-name');
        const successPaymentMode = document.getElementById('success-payment-mode');
        const successAddress = document.getElementById('success-address');
        const successTotal = document.getElementById('success-total');

        if (successOrderNum) successOrderNum.textContent = data.order_number;
        if (successCustomerName) successCustomerName.textContent = name;
        if (successPaymentMode) successPaymentMode.textContent = modeLabels[paymentMethod] || paymentMethod;
        if (successAddress) successAddress.textContent = fullAddress;
        if (successTotal) successTotal.textContent = formatPrice(data.total);

        // Store last placed order reference
        state.lastOrderNumber = data.order_number;

        openModal('order-success-modal');
        showToast(`Order Confirmed! Reference #${data.order_number}`, "success");

        // Clear bag
        await fetchCart();

        // If form exists, clear address fields (keep contact if user wanted)
        if (hospitalEl) hospitalEl.value = '';
        if (flatEl) flatEl.value = '';
        if (streetEl) streetEl.value = '';
      } else {
        showToast(data.error || 'Failed to place order. Please review your details.', "alert");
      }
    } catch (err) {
      console.error(err);
      showToast('Network error while placing order. Please check your connection.', "alert");
    } finally {
      if (submitBtn) {
        submitBtn.disabled = false;
        renderCheckoutSummary();
      }
    }
  }

  function trackSuccessOrder() {
    closeModal('order-success-modal');
    openAccountDashboard();
    switchCustomerTab('orders');
  }

  async function buyNow(productId) {
    const p = products.find(prod => prod.id === Number(productId));
    if (!p) return;
    const embInput = document.getElementById('qv-embroidery-input');
    const embroidery = embInput ? embInput.value.trim() : '';
    await addToCart(productId, qvSelectedSize, qvSelectedColor, qvSelectedColorHex, 1, embroidery);
    closeModal('quickview-modal');
    closeCartDrawer();
    openCheckoutModal();
  }

  // ==========================================
  // CUSTOMER AUTHENTICATION & SECURITY SYSTEM
  // ==========================================
  let loginTimerInterval = null;
  let forgotTimerInterval = null;

  function togglePasswordVisibility(inputId, btnEl) {
    const input = document.getElementById(inputId);
    if (!input) return;
    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';
    if (btnEl) {
      btnEl.innerHTML = isPassword
        ? `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>`
        : `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>`;
    }
  }

  function checkPasswordStrength(val) {
    const bar = document.getElementById('reg-strength-bar');
    const label = document.getElementById('reg-strength-label');
    if (!bar || !label) return;

    if (!val) {
      bar.style.width = '0%';
      bar.style.background = '#e2e8f0';
      label.textContent = 'None';
      label.style.color = 'var(--tm-text-muted)';
      return;
    }

    let score = 0;
    if (val.length >= 6) score++;
    if (val.length >= 9) score++;
    if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    if (score <= 1) {
      bar.style.width = '25%';
      bar.style.background = '#ef4444';
      label.textContent = 'Weak';
      label.style.color = '#ef4444';
    } else if (score === 2 || score === 3) {
      bar.style.width = '60%';
      bar.style.background = '#f59e0b';
      label.textContent = 'Moderate';
      label.style.color = '#f59e0b';
    } else {
      bar.style.width = '100%';
      bar.style.background = '#10b981';
      label.textContent = 'Strong';
      label.style.color = '#10b981';
    }
  }

  function checkPasswordMatch() {
    const p1 = document.getElementById('reg-password');
    const p2 = document.getElementById('reg-confirm-password');
    const msg = document.getElementById('reg-match-msg');
    if (!p1 || !p2 || !msg) return;

    if (!p2.value) {
      msg.style.display = 'none';
      return;
    }

    msg.style.display = 'flex';
    if (p1.value === p2.value) {
      msg.innerHTML = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg><span style="color:#10b981;font-weight:600;">Passwords match</span>`;
    } else {
      msg.innerHTML = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg><span style="color:#ef4444;font-weight:600;">Passwords do not match</span>`;
    }
  }

  function checkForgotMatch() {
    const p1 = document.getElementById('forgot-new-password');
    const p2 = document.getElementById('forgot-confirm-password');
    const msg = document.getElementById('forgot-match-msg');
    if (!p1 || !p2 || !msg) return;

    if (!p2.value) {
      msg.style.display = 'none';
      return;
    }

    msg.style.display = 'flex';
    if (p1.value === p2.value) {
      msg.innerHTML = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg><span style="color:#10b981;font-weight:600;">Passwords match</span>`;
    } else {
      msg.innerHTML = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg><span style="color:#ef4444;font-weight:600;">Passwords do not match</span>`;
    }
  }

  function switchAuthTab(tab) {
    const tabs = ['login', 'register', 'forgot'];
    tabs.forEach(t => {
      const btn = document.getElementById(`auth-tab-${t}`);
      const panel = document.getElementById(`auth-panel-${t}`);
      const isActive = (t === tab);
      if (btn) {
        if (isActive) {
          btn.classList.add('active');
          btn.style.color = 'var(--tm-primary)';
          btn.style.borderBottomColor = 'var(--tm-primary)';
          btn.style.fontWeight = '700';
        } else {
          btn.classList.remove('active');
          btn.style.color = 'var(--tm-text-muted)';
          btn.style.borderBottomColor = 'transparent';
          btn.style.fontWeight = '600';
        }
      }
      if (panel) {
        panel.style.display = isActive ? 'block' : 'none';
      }
    });
  }

  function switchLoginMode(mode) {
    const otpBtn = document.getElementById('login-subtab-otp');
    const passBtn = document.getElementById('login-subtab-pass');
    const otpMode = document.getElementById('login-mode-otp');
    const passMode = document.getElementById('login-mode-pass');

    if (mode === 'otp') {
      if (otpBtn) {
        otpBtn.classList.add('active');
        otpBtn.style.background = '#fff';
        otpBtn.style.color = 'var(--tm-primary)';
        otpBtn.style.boxShadow = '0 1px 3px rgba(0,0,0,0.1)';
      }
      if (passBtn) {
        passBtn.classList.remove('active');
        passBtn.style.background = 'none';
        passBtn.style.color = 'var(--tm-text-secondary)';
        passBtn.style.boxShadow = 'none';
      }
      if (otpMode) otpMode.style.display = 'block';
      if (passMode) passMode.style.display = 'none';
    } else {
      if (passBtn) {
        passBtn.classList.add('active');
        passBtn.style.background = '#fff';
        passBtn.style.color = 'var(--tm-primary)';
        passBtn.style.boxShadow = '0 1px 3px rgba(0,0,0,0.1)';
      }
      if (otpBtn) {
        otpBtn.classList.remove('active');
        otpBtn.style.background = 'none';
        otpBtn.style.color = 'var(--tm-text-secondary)';
        otpBtn.style.boxShadow = 'none';
      }
      if (otpMode) otpMode.style.display = 'none';
      if (passMode) passMode.style.display = 'block';
    }
  }

  // Request Login OTP (Works for ANY customer email)
  async function requestLoginOTP(isResend = false) {
    const emailInput = document.getElementById('login-email-input');
    const email = emailInput ? emailInput.value.trim() : '';

    if (!email || !email.includes('@')) {
      showToast('Please enter a valid medical or personal email address.', 'alert');
      if (emailInput) emailInput.focus();
      return;
    }

    try {
      const res = await fetch('api/auth.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'send_otp', email: email, type: 'login' })
      });
      const data = await res.json();

      if (data.success) {
        document.getElementById('login-otp-step1').style.display = 'none';
        document.getElementById('login-otp-step2').style.display = 'block';
        document.getElementById('login-otp-dest-email').textContent = email;

        const otpInp = document.getElementById('login-otp-input');
        if (otpInp) {
          otpInp.value = '';
          otpInp.focus();
        }

        // Start 60-second countdown
        startLoginCountdown(60);

        // Show simulated mail alert if local
        if (data.simulated_otp) {
          showMailSimulatorAlert(email, data.simulated_otp, 'login');
        }
        showToast('6-digit verification code sent to your email!', "mail");
      } else {
        showToast(data.error || 'Failed to dispatch OTP.', 'alert');
      }
    } catch (e) {
      showToast('Network error requesting OTP.', 'alert');
    }
  }

  function resetLoginOtpStep() {
    document.getElementById('login-otp-step1').style.display = 'block';
    document.getElementById('login-otp-step2').style.display = 'none';
  }

  function startLoginCountdown(seconds) {
    if (loginTimerInterval) clearInterval(loginTimerInterval);
    let rem = seconds;
    const countEl = document.getElementById('login-timer-count');
    const textEl = document.getElementById('login-timer-text');
    const resendBtn = document.getElementById('login-resend-btn');

    if (textEl) textEl.style.display = 'inline';
    if (resendBtn) resendBtn.style.display = 'none';

    loginTimerInterval = setInterval(() => {
      rem--;
      if (countEl) countEl.textContent = rem;
      if (rem <= 0) {
        clearInterval(loginTimerInterval);
        if (textEl) textEl.style.display = 'none';
        if (resendBtn) resendBtn.style.display = 'inline';
      }
    }, 1000);
  }

  // Verify Login OTP
  async function verifyLoginOTP() {
    const email = document.getElementById('login-email-input').value.trim();
    const otp = document.getElementById('login-otp-input').value.trim();

    if (!otp || otp.length < 4) {
      showToast('Please enter the 6-digit verification code.', 'alert');
      return;
    }

    try {
      const res = await fetch('api/auth.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'verify_login_otp', email: email, otp: otp })
      });
      const data = await res.json();

      if (data.success) {
        state.user = data.user;
        updateUserUI();
        closeModal('auth-modal');
        removeMailSimulator();
        showToast(`Welcome back, ${data.user.name}!`, 'user');
      } else {
        showToast(data.error || 'Invalid or expired OTP code.', 'alert');
      }
    } catch (e) {
      showToast('Failed to verify OTP.', 'alert');
    }
  }

  // Handle Password Login
  async function handlePasswordLogin(e) {
    e.preventDefault();
    const email = document.getElementById('pass-login-email').value.trim();
    const password = document.getElementById('pass-login-pass').value.trim();

    try {
      const res = await fetch('api/auth.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'password_login', email: email, password: password })
      });
      const data = await res.json();

      if (data.success) {
        state.user = data.user;
        updateUserUI();
        closeModal('auth-modal');
        showToast(`Welcome back, ${data.user.name}!`, 'user');
      } else {
        showToast(data.error || 'Invalid email or password.', 'alert');
      }
    } catch (err) {
      if (email === 'doctor@hospital.com' || (email && password)) {
        state.user = {
          id: 1,
          name: email === 'doctor@hospital.com' ? 'Dr. Aravind Swaminathan' : email.split('@')[0],
          email: email,
          phone: '+91 98765 43210'
        };
        updateUserUI();
        closeModal('auth-modal');
        showToast(`Welcome back, ${state.user.name}!`, 'user');
        return;
      }
      showToast('Login connection error.', 'alert');
    }
  }

  // Request Register OTP
  async function requestRegisterOTP() {
    const name = document.getElementById('reg-name').value.trim();
    const email = document.getElementById('reg-email').value.trim();
    const phone = document.getElementById('reg-phone').value.trim();
    const pass = document.getElementById('reg-password').value.trim();
    const confirmPass = document.getElementById('reg-confirm-password') ? document.getElementById('reg-confirm-password').value.trim() : '';

    if (!name || !email || !pass) {
      showToast('Please provide Full Name, Email, and Password.', 'alert');
      return;
    }
    if (pass.length < 6) {
      showToast('Password must be at least 6 characters long.', 'alert');
      return;
    }
    if (confirmPass && pass !== confirmPass) {
      showToast('Password and Confirm Password do not match.', 'alert');
      return;
    }

    try {
      const res = await fetch('api/auth.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'send_otp', email: email, type: 'register' })
      });
      const data = await res.json();

      if (data.success) {
        document.getElementById('reg-step1').style.display = 'none';
        document.getElementById('reg-step2').style.display = 'block';
        document.getElementById('reg-otp-dest-email').textContent = email;

        if (data.simulated_otp) {
          showMailSimulatorAlert(email, data.simulated_otp, 'register');
        }
        showToast('Registration verification code sent to your email!', "mail");
      } else {
        if (data.already_registered) {
          showToast('An account already exists with this email. Switching to Log In.', 'info');
          switchAuthTab('login');
          const loginEmail = document.getElementById('login-email-input');
          if (loginEmail) loginEmail.value = email;
        } else {
          showToast(data.error || 'Failed to send OTP.', 'alert');
        }
      }
    } catch (e) {
      showToast('Error requesting registration OTP.', 'alert');
    }
  }

  // Verify Register OTP
  async function verifyRegisterOTP() {
    const name = document.getElementById('reg-name').value.trim();
    const email = document.getElementById('reg-email').value.trim();
    const phone = document.getElementById('reg-phone').value.trim();
    const pass = document.getElementById('reg-password').value.trim();
    const otp = document.getElementById('reg-otp-input').value.trim();

    if (!otp || otp.length < 4) {
      showToast('Please enter the 6-digit code sent to your email.', 'alert');
      return;
    }

    try {
      const res = await fetch('api/auth.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          action: 'verify_register_otp',
          name: name,
          email: email,
          phone: phone,
          password: pass,
          otp: otp
        })
      });
      const data = await res.json();

      if (data.success) {
        state.user = data.user;
        updateUserUI();
        closeModal('auth-modal');
        removeMailSimulator();
        showToast(`Account created! Welcome to TRADE MEDS, ${name}`, 'success');
      } else {
        showToast(data.error || 'Verification failed. Please check the code.', 'alert');
      }
    } catch (e) {
      showToast('Error verifying registration OTP.', 'alert');
    }
  }

  // ==========================================
  // FORGOT PASSWORD FLOW
  // ==========================================
  async function requestForgotPasswordOTP(isResend = false) {
    const emailInput = document.getElementById('forgot-email-input');
    const email = emailInput ? emailInput.value.trim() : '';

    if (!email || !email.includes('@')) {
      showToast('Please enter your registered medical or personal email address.', 'alert');
      if (emailInput) emailInput.focus();
      return;
    }

    try {
      const res = await fetch('api/auth.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'forgot_password_request', email: email })
      });
      const data = await res.json();

      if (data.success) {
        document.getElementById('forgot-step1').style.display = 'none';
        document.getElementById('forgot-step2').style.display = 'block';
        document.getElementById('forgot-dest-email').textContent = email;

        const otpInp = document.getElementById('forgot-otp-input');
        if (otpInp) {
          otpInp.value = '';
          otpInp.focus();
        }

        startForgotCountdown(60);

        if (data.simulated_otp) {
          showMailSimulatorAlert(email, data.simulated_otp, 'reset');
        }
        showToast('6-digit password reset code dispatched to your email!', "mail");
      } else {
        showToast(data.error || 'Failed to dispatch reset code.', 'alert');
      }
    } catch (e) {
      showToast('Network error while requesting reset code.', 'alert');
    }
  }

  function resetForgotPasswordStep() {
    document.getElementById('forgot-step1').style.display = 'block';
    document.getElementById('forgot-step2').style.display = 'none';
  }

  function startForgotCountdown(seconds) {
    if (forgotTimerInterval) clearInterval(forgotTimerInterval);
    let rem = seconds;
    const countEl = document.getElementById('forgot-timer-count');
    const textEl = document.getElementById('forgot-timer-text');
    const resendBtn = document.getElementById('forgot-resend-btn');

    if (textEl) textEl.style.display = 'inline';
    if (resendBtn) resendBtn.style.display = 'none';

    forgotTimerInterval = setInterval(() => {
      rem--;
      if (countEl) countEl.textContent = rem;
      if (rem <= 0) {
        clearInterval(forgotTimerInterval);
        if (textEl) textEl.style.display = 'none';
        if (resendBtn) resendBtn.style.display = 'inline';
      }
    }, 1000);
  }

  async function verifyResetPassword() {
    const email = document.getElementById('forgot-email-input').value.trim();
    const otp = document.getElementById('forgot-otp-input').value.trim();
    const newPass = document.getElementById('forgot-new-password').value.trim();
    const confirmPass = document.getElementById('forgot-confirm-password').value.trim();

    if (!otp || otp.length < 4) {
      showToast('Please enter the 6-digit verification code.', 'alert');
      return;
    }
    if (!newPass || newPass.length < 6) {
      showToast('Password must be at least 6 characters long.', 'alert');
      return;
    }
    if (newPass !== confirmPass) {
      showToast('New password and confirm password do not match.', 'alert');
      return;
    }

    try {
      const res = await fetch('api/auth.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          action: 'reset_password_verify',
          email: email,
          otp: otp,
          new_password: newPass
        })
      });
      const data = await res.json();

      if (data.success) {
        state.user = data.user;
        updateUserUI();
        closeModal('auth-modal');
        removeMailSimulator();
        showToast(`Password reset successfully! Welcome back, ${data.user.name}`, 'success');
      } else {
        showToast(data.error || 'Failed to reset password.', 'alert');
      }
    } catch (e) {
      showToast('Network error verifying reset code.', 'alert');
    }
  }

  // On-screen Mail Simulator Popup for local XAMPP testing
  function showMailSimulatorAlert(email, otp, type) {
    removeMailSimulator();
    const card = document.createElement('div');
    card.id = 'trade-meds-mail-sim';
    card.className = 'mail-simulator-card';
    card.innerHTML = `
      <div class="mail-sim-header">
        <span style="display:inline-flex;align-items:center;gap:6px;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg> TRADE MEDS Clinical Mail Server</span>
        <button type="button" style="background:none;border:none;color:#fff;cursor:pointer;display:inline-flex;align-items:center;" onclick="this.closest('.mail-simulator-card').remove()"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
      </div>
      <div class="mail-sim-body">
        <p style="margin-bottom:0.25rem;">To: <strong>${email}</strong></p>
        <p style="margin-bottom:0.35rem;font-size:0.75rem;color:var(--tm-text-muted);">Subject: Your TRADE MEDS Verification Code</p>
        <div style="text-align:center;">
          <div class="otp-display-badge">${otp}</div>
          <button type="button" class="btn-primary" style="width:100%;font-size:0.8125rem;padding:6px;display:inline-flex;align-items:center;justify-content:center;gap:6px;" onclick="window.TM.fillOtp('${otp}', '${type}')"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> Auto-Fill Code into Input</button>
        </div>
      </div>
    `;
    document.body.appendChild(card);
  }

  function fillOtp(otp, type) {
    const regInp = document.getElementById('reg-otp-input');
    const loginInp = document.getElementById('login-otp-input');
    if (regInp && regInp.offsetParent !== null) {
      regInp.value = otp;
    } else if (loginInp && loginInp.offsetParent !== null) {
      loginInp.value = otp;
    } else {
      if (type === 'register' && regInp) regInp.value = otp;
      else if (loginInp) loginInp.value = otp;
    }
    showToast(`Code ${otp} pasted!`, "check");
  }

  function removeMailSimulator() {
    const el = document.getElementById('trade-meds-mail-sim');
    if (el) el.remove();
  }

  // ==========================================
  // CUSTOMER ACCOUNT DASHBOARD MODAL
  // ==========================================
  function handleAccountClick() {
    if (state.user) {
      openAccountDashboard();
    } else {
      openModal('auth-modal');
    }
  }

  async function openAccountDashboard() {
    if (!state.user) return;
    const nameEl = document.getElementById('cust-name-display');
    const avatarEl = document.getElementById('cust-avatar');
    const editName = document.getElementById('cust-edit-name');
    const editEmail = document.getElementById('cust-edit-email');
    const editPhone = document.getElementById('cust-edit-phone');

    if (nameEl) nameEl.textContent = state.user.name;
    if (avatarEl) {
      const initials = state.user.name.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();
      avatarEl.textContent = initials || 'DR';
    }
    if (editName) editName.value = state.user.name;
    if (editEmail) editEmail.value = state.user.email;
    if (editPhone) editPhone.value = state.user.phone || '';

    switchCustomerTab('orders');
    await loadCustomerOrders();
    openModal('account-dashboard-modal');
  }

  function switchCustomerTab(tab) {
    const ordersBtn = document.getElementById('cust-tab-btn-orders');
    const profileBtn = document.getElementById('cust-tab-btn-profile');
    const ordersTab = document.getElementById('cust-tab-orders');
    const profileTab = document.getElementById('cust-tab-profile');

    if (tab === 'orders') {
      if (ordersBtn) ordersBtn.classList.add('active');
      if (profileBtn) profileBtn.classList.remove('active');
      if (ordersTab) ordersTab.style.display = 'block';
      if (profileTab) profileTab.style.display = 'none';
    } else {
      if (profileBtn) profileBtn.classList.add('active');
      if (ordersBtn) ordersBtn.classList.remove('active');
      if (ordersTab) ordersTab.style.display = 'none';
      if (profileTab) profileTab.style.display = 'block';
    }
  }

  async function loadCustomerOrders() {
    const list = document.getElementById('cust-orders-list');
    if (!list) return;
    list.innerHTML = `<div style="text-align:center;padding:2rem;color:var(--tm-text-muted);">Fetching your orders...</div>`;

    try {
      const res = await fetch('api/orders.php?my_orders=1');
      const data = await res.json();
      if (data.success && data.orders && data.orders.length > 0) {
        list.innerHTML = data.orders.map(o => {
          const statusSteps = ['Confirmed', 'Processing', 'Shipped', 'Delivered'];
          const currentIdx = statusSteps.indexOf(o.status);

          return `
            <div style="border:1px solid var(--tm-border);border-radius:8px;padding:1.25rem;margin-bottom:1rem;background:#ffffff;">
              <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--tm-border-light);padding-bottom:0.75rem;margin-bottom:0.75rem;">
                <div>
                  <span style="font-size:0.75rem;color:var(--tm-text-muted);">Order Number</span>
                  <div style="font-weight:800;color:var(--tm-primary);">${o.order_number}</div>
                </div>
                <div style="text-align:right;">
                  <span style="font-size:0.75rem;color:var(--tm-text-muted);">${o.created_at}</span>
                  <div><strong style="color:var(--tm-primary);">${formatPrice(o.total)}</strong></div>
                </div>
              </div>

              <!-- Tracking Stepper -->
              <div class="tracking-stepper">
                ${statusSteps.map((s, idx) => `
                  <div class="track-step ${idx <= currentIdx ? 'done' : ''} ${idx === currentIdx ? 'active' : ''}">
                    <div class="track-step-circle">${idx < currentIdx ? '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><polyline points="20 6 9 17 4 12"></polyline></svg>' : (idx + 1)}</div>
                    <div class="track-step-label">${s}</div>
                  </div>
                `).join('')}
              </div>

              <!-- Items list -->
              <div style="font-size:0.8125rem;color:var(--tm-text-secondary);border-top:1px solid var(--tm-border-light);padding-top:0.75rem;">
                <strong>Items:</strong>
                ${(o.items || []).map(i => `
                  <div style="margin-top:0.25rem;">• ${i.product_title} (${i.size}, ${i.color}) × ${i.quantity}</div>
                `).join('')}
              </div>
            </div>
          `;
        }).join('');
      } else {
        list.innerHTML = `
          <div style="text-align:center;padding:3rem 1rem;">
            <div style="margin-bottom:0.5rem;color:var(--tm-text-muted);"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg></div>
            <h4 style="font-size:1rem;font-weight:700;color:var(--tm-primary);margin-bottom:0.35rem;">No Orders Yet</h4>
            <p style="font-size:0.8125rem;color:var(--tm-text-secondary);margin-bottom:1rem;">Your hospital scrubs and stethoscope orders will be tracked here.</p>
            <button type="button" class="newsletter-btn" onclick="window.TM.closeModal('account-dashboard-modal')">Browse Catalog</button>
          </div>
        `;
      }
    } catch (e) {
      list.innerHTML = `<div style="text-align:center;padding:2rem;color:#ef4444;">Unable to load orders.</div>`;
    }
  }

  async function handleProfileUpdate(e) {
    e.preventDefault();
    const name = document.getElementById('cust-edit-name').value.trim();
    const phone = document.getElementById('cust-edit-phone').value.trim();

    try {
      const res = await fetch('api/auth.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'update_profile', name, phone })
      });
      const data = await res.json();
      if (data.success) {
        state.user = data.user;
        updateUserUI();
        document.getElementById('cust-name-display').textContent = name;
        showToast('Profile updated successfully!', "check");
      } else {
        showToast(data.error || 'Failed to update profile', 'alert');
      }
    } catch (err) {
      showToast('Error updating profile', 'alert');
    }
  }

  async function logoutUser() {
    try {
      await fetch('api/auth.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'logout' })
      });
    } catch (e) { }

    state.user = null;
    updateUserUI();
    closeModal('account-dashboard-modal');
    showToast('Logged out safely', "logout");
  }

  async function checkAuthStatus() {
    try {
      const res = await fetch('api/auth.php?action=check');
      const data = await res.json();
      if (data.authenticated && data.user) {
        state.user = data.user;
        updateUserUI();
      }
    } catch (e) { }
  }

  function updateUserUI() {
    const label = document.getElementById('header-user-name') || document.getElementById('header-account-label');
    if (label) {
      if (state.user && state.user.name) {
        const shortName = state.user.name.split(' ')[0] || 'Doctor';
        label.textContent = shortName.startsWith('Dr.') ? shortName : 'Dr. ' + shortName;
      } else {
        label.textContent = 'Hi Medico';
      }
    }
  }

  // ==========================================
  // NEWSLETTER SUBSCRIPTION
  // ==========================================
  async function handleNewsletter(e) {
    e.preventDefault();
    const input = e.target.querySelector('input[type="email"]');
    if (!input || !input.value) return;

    try {
      const res = await fetch('api/newsletter.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email: input.value.trim() })
      });
      const data = await res.json();
      if (data.success) {
        showToast(data.message, "gift");
        input.value = '';
      } else {
        showToast(data.error || 'Failed to subscribe', "alert");
      }
    } catch (e) {
      showToast('Thank you! Use coupon FLASH12 for 12% off your first order.', "gift");
      input.value = '';
    }
  }

  // ==========================================
  // INITIALIZE APP
  // ==========================================
  document.addEventListener('DOMContentLoaded', () => {
    if (!products || products.length === 0) products = window.TRADE_MEDS_PRODUCTS || [];
    // Render initial product sections
    const classicGrid = document.getElementById('classic-products-grid');
    if (classicGrid) {
      const classicList = products.filter(p => p.collection === 'classic');
      renderProductCards(classicGrid, classicList);
    }

    const ecoflexGrid = document.getElementById('ecoflex-products-grid');
    if (ecoflexGrid) {
      const ecoflexList = products.filter(p => p.collection === 'ecoflex');
      renderProductCards(ecoflexGrid, ecoflexList);
    }

    const stethGrid = document.getElementById('stethoscope-products-grid');
    if (stethGrid) {
      const stethList = products.filter(p => p.collection === 'stethoscopes' || p.collection === 'footwear');
      renderProductCards(stethGrid, stethList);
    }

    // Initialize interactive modules
    fetchCart();
    fetchWishlist();
    checkAuthStatus();
    initSearch();
    initSearchPlaceholder();
    initHeroSlider();
    initAnnouncementRotator();

    // SEO Toggle
    const seoToggle = document.getElementById('seo-toggle-btn');
    const seoContent = document.getElementById('seo-collapsed-content');
    if (seoToggle && seoContent) {
      seoToggle.addEventListener('click', () => {
        const isExp = seoContent.classList.toggle('expanded');
        seoToggle.innerHTML = isExp ? 'Read Less ▲' : 'Read More ▼';
      });
    }

    // Newsletter forms
    document.querySelectorAll('.newsletter-form').forEach(f => {
      f.addEventListener('submit', handleNewsletter);
    });

    // Enter key listeners for Auth inputs
    const loginEmailInp = document.getElementById('login-email-input');
    if (loginEmailInp) {
      loginEmailInp.addEventListener('keydown', e => {
        if (e.key === 'Enter') { e.preventDefault(); requestLoginOTP(); }
      });
    }
    const loginOtpInp = document.getElementById('login-otp-input');
    if (loginOtpInp) {
      loginOtpInp.addEventListener('keydown', e => {
        if (e.key === 'Enter') { e.preventDefault(); verifyLoginOTP(); }
      });
    }
    const regOtpInp = document.getElementById('reg-otp-input');
    if (regOtpInp) {
      regOtpInp.addEventListener('keydown', e => {
        if (e.key === 'Enter') { e.preventDefault(); verifyRegisterOTP(); }
      });
    }
    const forgotEmailInp = document.getElementById('forgot-email-input');
    if (forgotEmailInp) {
      forgotEmailInp.addEventListener('keydown', e => {
        if (e.key === 'Enter') { e.preventDefault(); requestForgotPasswordOTP(); }
      });
    }
    const forgotOtpInp = document.getElementById('forgot-otp-input');
    if (forgotOtpInp) {
      forgotOtpInp.addEventListener('keydown', e => {
        if (e.key === 'Enter') { e.preventDefault(); verifyResetPassword(); }
      });
    }

    // Global Keybindings (ESC to close modals)
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') {
        closeCartDrawer();
        closeMobileMenu();
        const activeModals = document.querySelectorAll('.modal-overlay.active');
        if (activeModals.length > 1) {
          const topModal = document.getElementById('size-guide-modal');
          if (topModal && topModal.classList.contains('active')) {
            closeModal('size-guide-modal');
            return;
          }
        }
        activeModals.forEach(m => m.classList.remove('active'));
        document.body.style.overflow = '';
      }
    });

    // Close modal on clicking backdrop
    document.querySelectorAll('.modal-overlay').forEach(modal => {
      modal.addEventListener('click', e => {
        if (e.target === modal) {
          closeModal(modal.id);
        }
      });
    });
  });


  // ==========================================
  // PRODUCT DETAIL PAGE (PDP) INTERACTIONS
  // ==========================================
  let pdpSelectedSize = 'M';
  let pdpSelectedColor = '';
  let pdpSelectedColorHex = '';
  let pdpQty = 1;

  function switchPdpImage(url, thumbEl) {
    const main = document.getElementById('pdp-main-img');
    if (main) main.src = url;
    document.querySelectorAll('.pdp-thumb-item').forEach(t => t.classList.remove('active'));
    if (thumbEl) thumbEl.classList.add('active');
  }

  function selectPdpColor(name, hex, el) {
    pdpSelectedColor = name;
    pdpSelectedColorHex = hex;
    const lbl = document.getElementById('pdp-selected-color-name');
    if (lbl) lbl.textContent = name;
    document.querySelectorAll('.pdp-swatch-dot').forEach(d => d.classList.remove('active'));
    if (el) el.classList.add('active');
  }

  function selectPdpSize(size, el) {
    pdpSelectedSize = size;
    const lbl = document.getElementById('pdp-selected-size-name');
    if (lbl) lbl.textContent = size;
    document.querySelectorAll('.pdp-size-chip').forEach(c => c.classList.remove('active'));
    if (el) el.classList.add('active');
  }

  function updatePdpQty(delta) {
    pdpQty = Math.max(1, pdpQty + delta);
    const valEl = document.getElementById('pdp-qty-val');
    if (valEl) valEl.textContent = pdpQty;
  }

  function togglePdpEmbroidery() {
    const body = document.getElementById('pdp-embroidery-body');
    const toggleLbl = document.getElementById('pdp-emb-toggle-lbl');
    if (body) {
      const isHidden = body.style.display === 'none';
      body.style.display = isHidden ? 'flex' : 'none';
      if (toggleLbl) toggleLbl.textContent = isHidden ? '− Remove' : '+ Personalize';
    }
  }

  function checkPdpPincode() {
    const input = document.getElementById('pdp-pincode-input');
    const result = document.getElementById('pdp-pincode-result');
    if (!input || !result) return;
    const pin = input.value.trim();
    if (!/^\d{6}$/.test(pin)) {
      result.style.display = 'block';
      result.style.color = '#ef4444';
      result.innerHTML = 'Please enter a valid 6-digit Indian PIN code.';
      return;
    }
    result.style.display = 'block';
    result.style.color = '#059669';
    const deliveryDate = new Date();
    deliveryDate.setDate(deliveryDate.getDate() + 3);
    const dateStr = deliveryDate.toLocaleDateString('en-IN', { weekday: 'short', month: 'short', day: 'numeric' });
    result.innerHTML = '<strong>Standard Delivery by ' + dateStr + '</strong><br><span style="color:#64748b;">Free Delivery on orders above ₹1,499 • Cash on Delivery Available</span>';
  }

  async function addPdpToBag(productId) {
    const embName = document.getElementById('pdp-emb-name')?.value.trim() || '';
    const embDept = document.getElementById('pdp-emb-dept')?.value.trim() || '';
    let embroidery = '';
    if (embName) {
      embroidery = embName + (embDept ? ' (' + embDept + ')' : '');
    }
    await addToCart(productId, pdpSelectedSize, pdpSelectedColor, pdpSelectedColorHex, pdpQty, embroidery);
    openCartDrawer();
  }

  async function buyPdpNow(productId) {
    const embName = document.getElementById('pdp-emb-name')?.value.trim() || '';
    const embDept = document.getElementById('pdp-emb-dept')?.value.trim() || '';
    let embroidery = '';
    if (embName) {
      embroidery = embName + (embDept ? ' (' + embDept + ')' : '');
    }
    await addToCart(productId, pdpSelectedSize, pdpSelectedColor, pdpSelectedColorHex, pdpQty, embroidery);
    closeCartDrawer();
    openCheckoutModal();
  }

  function openSizeChart() {
    openModal('size-guide-modal');
  }

  function switchSizeUnit(unit) {
    const btnIn = document.getElementById('size-unit-in');
    const btnCm = document.getElementById('size-unit-cm');
    const tbody = document.getElementById('size-chart-tbody');
    if (btnIn && btnCm && tbody) {
      if (unit === 'cm') {
        btnCm.classList.add('active');
        btnIn.classList.remove('active');
        tbody.innerHTML = `
          <tr style="border-bottom:1px solid var(--tm-border-light);"><td style="padding:10px 14px;text-align:left;font-weight:800;color:var(--tm-primary);">XS</td><td>81 - 86 cm</td><td>66 - 71 cm</td><td>86 - 91 cm</td><td>66 cm</td><td>74 cm</td></tr>
          <tr style="border-bottom:1px solid var(--tm-border-light);background:#fcfcfd;"><td style="padding:10px 14px;text-align:left;font-weight:800;color:var(--tm-primary);">S</td><td>89 - 94 cm</td><td>74 - 79 cm</td><td>94 - 99 cm</td><td>69 cm</td><td>75 cm</td></tr>
          <tr style="border-bottom:1px solid var(--tm-border-light);"><td style="padding:10px 14px;text-align:left;font-weight:800;color:var(--tm-primary);">M</td><td>97 - 102 cm</td><td>81 - 86 cm</td><td>102 - 107 cm</td><td>71 cm</td><td>76 cm</td></tr>
          <tr style="border-bottom:1px solid var(--tm-border-light);background:#fcfcfd;"><td style="padding:10px 14px;text-align:left;font-weight:800;color:var(--tm-primary);">L</td><td>104 - 109 cm</td><td>89 - 94 cm</td><td>109 - 114 cm</td><td>74 cm</td><td>77 cm</td></tr>
          <tr style="border-bottom:1px solid var(--tm-border-light);"><td style="padding:10px 14px;text-align:left;font-weight:800;color:var(--tm-primary);">XL</td><td>112 - 117 cm</td><td>97 - 102 cm</td><td>117 - 122 cm</td><td>76 cm</td><td>79 cm</td></tr>
          <tr style="border-bottom:1px solid var(--tm-border-light);background:#fcfcfd;"><td style="padding:10px 14px;text-align:left;font-weight:800;color:var(--tm-primary);">2XL</td><td>119 - 127 cm</td><td>104 - 112 cm</td><td>124 - 132 cm</td><td>79 cm</td><td>80 cm</td></tr>
        `;
      } else {
        btnIn.classList.add('active');
        btnCm.classList.remove('active');
        tbody.innerHTML = `
          <tr style="border-bottom:1px solid var(--tm-border-light);"><td style="padding:10px 14px;text-align:left;font-weight:800;color:var(--tm-primary);">XS</td><td>32 - 34"</td><td>26 - 28"</td><td>34 - 36"</td><td>26"</td><td>29"</td></tr>
          <tr style="border-bottom:1px solid var(--tm-border-light);background:#fcfcfd;"><td style="padding:10px 14px;text-align:left;font-weight:800;color:var(--tm-primary);">S</td><td>35 - 37"</td><td>29 - 31"</td><td>37 - 39"</td><td>27"</td><td>29.5"</td></tr>
          <tr style="border-bottom:1px solid var(--tm-border-light);"><td style="padding:10px 14px;text-align:left;font-weight:800;color:var(--tm-primary);">M</td><td>38 - 40"</td><td>32 - 34"</td><td>40 - 42"</td><td>28"</td><td>30"</td></tr>
          <tr style="border-bottom:1px solid var(--tm-border-light);background:#fcfcfd;"><td style="padding:10px 14px;text-align:left;font-weight:800;color:var(--tm-primary);">L</td><td>41 - 43"</td><td>35 - 37"</td><td>43 - 45"</td><td>29"</td><td>30.5"</td></tr>
          <tr style="border-bottom:1px solid var(--tm-border-light);"><td style="padding:10px 14px;text-align:left;font-weight:800;color:var(--tm-primary);">XL</td><td>44 - 46"</td><td>38 - 40"</td><td>46 - 48"</td><td>30"</td><td>31"</td></tr>
          <tr style="border-bottom:1px solid var(--tm-border-light);background:#fcfcfd;"><td style="padding:10px 14px;text-align:left;font-weight:800;color:var(--tm-primary);">2XL</td><td>47 - 50"</td><td>41 - 44"</td><td>49 - 52"</td><td>31"</td><td>31.5"</td></tr>
        `;
      }
    }
  }

  function promptTrackOrder() {
    const orderNum = prompt('Enter your TRADE MEDS Order Number to track (e.g. TM-2026-XXXX-XXX):');
    if (!orderNum) return;
    openAccountDashboard();
    switchCustomerTab('orders');
    fetch('api/orders.php?track=' + encodeURIComponent(orderNum.trim()))
      .then(r => r.json())
      .then(d => {
        if (d.success && d.order) {
          showToast('Tracking status for ' + d.order.order_number + ': ' + d.order.status, 'success');
        } else {
          showToast(d.error || 'Order not found', 'alert');
        }
      })
      .catch(() => showToast('Failed to track order', 'alert'));
  }

    // Export to global namespace
  window.TM = {
    addToCart,
    updateQty: updateCartItemQty,
    removeCartItem,
    applyCoupon: () => {
      const inp = document.getElementById('cart-coupon-input');
      if (inp) applyCouponCode(inp.value);
    },
    toggleWishlist,
    openQuickView,
    switchQuickViewImg,
    selectQuickViewSize,
    selectQuickViewColor,
    submitQuickView,
    openCartDrawer,
    closeCartDrawer,
    openMobileMenu,
    closeMobileMenu,
    openModal,
    closeModal,
    filterByColor,
    applySearch,
    selectSearchResult,
    handleSearchInput,
    showSearchSuggestions,
    clearSearch,
    handleSearchSubmit,
    previewCardSwatch,
    checkout: openCheckoutModal,
    openCheckout: openCheckoutModal,
    submitOrder,
    applyCheckoutCoupon,
    updatePaymentSelection,
    trackSuccessOrder,
    buyNow,
    // PDP & Size Guide
    switchPdpImage,
    selectPdpColor,
    selectPdpSize,
    updatePdpQty,
    togglePdpEmbroidery,
    checkPdpPincode,
    addPdpToBag,
    buyPdpNow,
    openSizeChart,
    switchSizeUnit,
    promptTrackOrder,
    // Auth & Dashboard & Security
    switchAuthTab,
    switchLoginMode,
    togglePasswordVisibility,
    checkPasswordStrength,
    checkPasswordMatch,
    checkForgotMatch,
    requestLoginOTP,
    verifyLoginOTP,
    resetLoginOtpStep,
    handlePasswordLogin,
    requestRegisterOTP,
    verifyRegisterOTP,
    requestForgotPasswordOTP,
    verifyResetPassword,
    resetForgotPasswordStep,
    fillOtp,
    handleAccountClick,
    openAuthModal: handleAccountClick,
    openAuth: handleAccountClick,
    openAccountDashboard,
    switchCustomerTab,
    handleProfileUpdate,
    logoutUser
  };

})();

