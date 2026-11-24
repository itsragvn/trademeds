<?php
require_once __DIR__ . '/auth_check.php';
$pdo = getDB();

// Quick PHP metrics
$metrics = [
    'revenue' => (float)$pdo->query("SELECT COALESCE(SUM(total), 0) FROM orders")->fetchColumn(),
    'orders' => (int)$pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
    'products' => (int)$pdo->query("SELECT COUNT(*) FROM products WHERE status = 'active'")->fetchColumn(),
    'low_stock' => (int)$pdo->query("SELECT COUNT(*) FROM products WHERE stock < 20")->fetchColumn()
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard – TRADE MEDS Operations</title>
  <link rel="icon" type="image/png" sizes="32x32" href="../images/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon-16x16.png">
  <link rel="apple-touch-icon" sizes="180x180" href="../images/apple-touch-icon.png">
  <link rel="shortcut icon" href="../favicon.ico">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg-dark: #011c42;
      --sidebar-bg: #011c42;
      --card-bg: #ffffff;
      --border-color: #e2e8f0;
      --primary: #012a63;
      --accent: #04780c;
      --accent-light: #ecfdf5;
      --cyan: #0284c7;
      --success: #04780c;
      --warning: #f59e0b;
      --danger: #ef4444;
      --text-main: #0f172a;
      --text-muted: #64748b;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Heebo', sans-serif;
      background-color: #f8fafc;
      color: var(--text-main);
      display: flex;
      min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
      width: 260px;
      background-color: var(--sidebar-bg);
      color: #ffffff;
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      z-index: 50;
      transition: transform 0.3s ease;
      box-shadow: 2px 0 12px rgba(1, 28, 66, 0.15);
    }
    .sidebar-header {
      padding: 1.5rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      display: flex;
      align-items: center;
      gap: 0.75rem;
      background: #ffffff;
    }
    .sidebar-header img {
      height: 38px;
    }
    .sidebar-menu {
      padding: 1.25rem 0.75rem;
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 0.35rem;
    }
    .menu-item {
      display: flex;
      align-items: center;
      gap: 0.85rem;
      padding: 0.75rem 1rem;
      color: #94a3b8;
      text-decoration: none;
      font-size: 0.9375rem;
      font-weight: 500;
      border-radius: 8px;
      transition: all 0.2s;
      cursor: pointer;
    }
    .menu-item:hover, .menu-item.active {
      color: #ffffff;
      background: rgba(4, 120, 12, 0.22);
      border-left: 3px solid var(--accent);
    }
    .sidebar-footer {
      padding: 1.25rem;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    .admin-pill {
      display: flex;
      align-items: center;
      justify-content: space-between;
      color: #cbd5e1;
      font-size: 0.8125rem;
    }

    /* Main Container */
    .main-wrapper {
      margin-left: 260px;
      flex: 1;
      display: flex;
      flex-direction: column;
      min-width: 0;
    }
    .topbar {
      height: 70px;
      background-color: #ffffff;
      border-bottom: 1px solid var(--border-color);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 2rem;
      position: sticky;
      top: 0;
      z-index: 40;
    }
    .topbar-title {
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--primary);
    }
    .topbar-actions {
      display: flex;
      align-items: center;
      gap: 1rem;
    }
    .btn-secondary {
      background: #f8fafc;
      border: 1px solid var(--border-color);
      color: var(--text-main);
      padding: 0.5rem 1rem;
      border-radius: 6px;
      font-size: 0.875rem;
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      cursor: pointer;
    }
    .btn-primary {
      background: linear-gradient(135deg, #012a63 0%, #04780c 100%);
      border: none;
      color: #ffffff;
      padding: 0.55rem 1.2rem;
      border-radius: 6px;
      font-size: 0.875rem;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      cursor: pointer;
      box-shadow: 0 2px 6px rgba(1, 42, 99, 0.2);
      transition: all 0.2s;
    }
    .btn-primary:hover {
      filter: brightness(1.1);
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(4, 120, 12, 0.3);
    }

    /* Content Area */
    .content-area {
      padding: 2rem;
      flex: 1;
    }
    .tab-pane {
      display: none;
    }
    .tab-pane.active {
      display: block;
    }

    /* Metric Cards */
    .metrics-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.5rem;
      margin-bottom: 2rem;
    }
    @media (max-width: 1024px) {
      .metrics-grid { grid-template-columns: repeat(2, 1fr); }
    }
    .metric-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 1.5rem;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
      position: relative;
      overflow: hidden;
    }
    .metric-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 4px;
      height: 100%;
      background: var(--accent);
    }
    .metric-card.green::before { background: var(--success); }
    .metric-card.amber::before { background: var(--warning); }
    .metric-card.red::before { background: var(--danger); }
    .metric-label {
      font-size: 0.8125rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.04em;
      color: var(--text-muted);
      margin-bottom: 0.5rem;
    }
    .metric-val {
      font-size: 1.75rem;
      font-weight: 800;
      color: var(--primary);
    }

    /* Tables & Cards */
    .table-container {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 12px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
      overflow: hidden;
      margin-bottom: 2rem;
    }
    .table-header {
      padding: 1.25rem 1.5rem;
      border-bottom: 1px solid var(--border-color);
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 1rem;
    }
    .table-title {
      font-size: 1.125rem;
      font-weight: 700;
      color: var(--primary);
    }
    .filter-pills {
      display: flex;
      gap: 0.5rem;
    }
    .filter-pill {
      padding: 0.35rem 0.75rem;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 600;
      border: 1px solid var(--border-color);
      background: #ffffff;
      color: var(--text-muted);
      cursor: pointer;
    }
    .filter-pill.active {
      background: var(--primary);
      color: #ffffff;
      border-color: var(--primary);
    }

    table.data-table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
      font-size: 0.875rem;
    }
    table.data-table th {
      background: #f8fafc;
      color: var(--text-muted);
      font-weight: 600;
      padding: 0.85rem 1.25rem;
      border-bottom: 1px solid var(--border-color);
      text-transform: uppercase;
      font-size: 0.75rem;
      letter-spacing: 0.04em;
    }
    table.data-table td {
      padding: 1rem 1.25rem;
      border-bottom: 1px solid var(--border-color);
      vertical-align: middle;
    }
    table.data-table tr:hover {
      background-color: #f8fafc;
    }

    /* Status Badges */
    .status-badge {
      display: inline-block;
      padding: 0.25rem 0.65rem;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
    }
    .status-badge.processing { background: #fef3c7; color: #92400e; }
    .status-badge.confirmed { background: #dbeafe; color: #1e40af; }
    .status-badge.shipped { background: #e0e7ff; color: #3730a3; }
    .status-badge.delivered { background: #dcfce7; color: #166534; }
    .status-badge.cancelled { background: #fee2e2; color: #991b1b; }

    /* Modals */
    .admin-modal {
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, 0.6);
      backdrop-filter: blur(4px);
      z-index: 100;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
      opacity: 0;
      visibility: hidden;
      transition: all 0.2s;
    }
    .admin-modal.active {
      opacity: 1;
      visibility: visible;
    }
    .admin-modal-box {
      background: #ffffff;
      border-radius: 12px;
      width: 100%;
      max-width: 720px;
      max-height: 90vh;
      overflow-y: auto;
      padding: 2rem;
      position: relative;
    }
    .modal-close {
      position: absolute;
      top: 1.25rem;
      right: 1.25rem;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: #f1f5f9;
      border: none;
      font-size: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
      margin-bottom: 1rem;
    }
    .form-group {
      margin-bottom: 1rem;
    }
    .form-group label {
      display: block;
      font-size: 0.8125rem;
      font-weight: 600;
      color: var(--primary);
      margin-bottom: 0.35rem;
    }
    .admin-input, .admin-select, .admin-textarea {
      width: 100%;
      height: 42px;
      border: 1px solid var(--border-color);
      border-radius: 6px;
      padding: 0 0.85rem;
      font-family: inherit;
      font-size: 0.875rem;
      outline: none;
    }
    .admin-textarea {
      height: 80px;
      padding: 0.65rem 0.85rem;
    }
    .admin-input:focus, .admin-select:focus, .admin-textarea:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .thumbnail-img {
      width: 44px;
      height: 55px;
      object-fit: cover;
      border-radius: 4px;
      background: #f1f5f9;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <img src="../images/trade-meds-logo/trade-meds.png" alt="TRADE MEDS">
    </div>

    <nav class="sidebar-menu">
      <div class="menu-item active" onclick="switchTab('dashboard', this)">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
        <span>Dashboard</span>
      </div>
      <div class="menu-item" onclick="switchTab('orders', this)">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
        <span>Orders Management</span>
      </div>
      <div class="menu-item" onclick="switchTab('products', this)">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4.5 3v5a4.5 4.5 0 0 0 9 0V3M18 10a4 4 0 0 1-4 4h-.5a4.5 4.5 0 0 1-4.5-4.5V3M20 10a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/></svg>
        <span>Product Catalog</span>
      </div>
      <div class="menu-item" onclick="switchTab('categories', this)">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
        <span>Categories Manager</span>
      </div>
      <div class="menu-item" onclick="switchTab('menus', this)">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        <span>Navigation Menus</span>
      </div>
      <div class="menu-item" onclick="switchTab('coupons', this)">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
        <span>Coupons &amp; Offers</span>
      </div>
      <div class="menu-item" onclick="switchTab('reviews', this)">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
        <span>Doctor Reviews</span>
      </div>
      <div class="menu-item" onclick="switchTab('customers', this)">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
        <span>Customers Directory</span>
      </div>
      <div class="menu-item" onclick="switchTab('stock', this)">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
        <span>Stock &amp; Inventory</span>
      </div>
      <div class="menu-item" onclick="switchTab('reports', this)">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
        <span>Sales Reports</span>
      </div>
      <div class="menu-item" onclick="switchTab('security', this)">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
        <span>Password &amp; Security</span>
      </div>
    </nav>

    <div class="sidebar-footer">
      <div class="admin-pill">
        <span>Logged in: <strong><?php echo htmlspecialchars($adminUser['username']); ?></strong></span>
        <a href="logout.php" style="color:#ef4444;text-decoration:none;font-weight:700;display:inline-flex;align-items:center;gap:4px;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Logout</a>
      </div>
    </div>
  </aside>

  <!-- Main Content Wrapper -->
  <div class="main-wrapper">
    <header class="topbar">
      <div class="topbar-title" id="page-title">Dashboard Overview</div>
      <div class="topbar-actions">
        <a href="../index.php" target="_blank" class="btn-secondary">
          <span>View Live Storefront</span>
          <span>↗</span>
        </a>
        <button type="button" class="btn-primary" onclick="openAddProductModal()">
          <span>+ Add Medical Product</span>
        </button>
      </div>
    </header>

    <main class="content-area">
      
      <!-- ==========================================
           TAB 1: DASHBOARD OVERVIEW
           ========================================== -->
      <div id="tab-dashboard" class="tab-pane active">
        <div class="metrics-grid">
          <div class="metric-card">
            <div class="metric-label">Total Revenue</div>
            <div class="metric-val" id="kpi-revenue">₹<?php echo number_format($metrics['revenue'], 2); ?></div>
          </div>
          <div class="metric-card green">
            <div class="metric-label">Total Orders</div>
            <div class="metric-val" id="kpi-orders"><?php echo $metrics['orders']; ?></div>
          </div>
          <div class="metric-card">
            <div class="metric-label">Active Products</div>
            <div class="metric-val" id="kpi-products"><?php echo $metrics['products']; ?></div>
          </div>
          <div class="metric-card red">
            <div class="metric-label">Low Stock Alerts</div>
            <div class="metric-val" id="kpi-low-stock"><?php echo $metrics['low_stock']; ?></div>
          </div>
        </div>

        <div class="table-container">
          <div class="table-header">
            <div class="table-title">Recent Customer Orders</div>
            <button class="btn-secondary" onclick="switchTab('orders', document.querySelectorAll('.menu-item')[1])">View All Orders →</button>
          </div>
          <table class="data-table">
            <thead>
              <tr>
                <th>Order #</th>
                <th>Doctor / Customer</th>
                <th>Items</th>
                <th>Amount</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="dashboard-orders-tbody">
              <!-- Populated via JS -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- ==========================================
           TAB 2: ORDER DETAILS MANAGEMENT
           ========================================== -->
      <div id="tab-orders" class="tab-pane">
        <div class="table-container">
          <div class="table-header">
            <div class="table-title">Customer Orders Management</div>
            <div class="filter-pills">
              <button class="filter-pill active" onclick="filterOrders('all', this)">All Orders</button>
              <button class="filter-pill" onclick="filterOrders('Processing', this)">Processing</button>
              <button class="filter-pill" onclick="filterOrders('Confirmed', this)">Confirmed</button>
              <button class="filter-pill" onclick="filterOrders('Shipped', this)">Shipped</button>
              <button class="filter-pill" onclick="filterOrders('Delivered', this)">Delivered</button>
              <button class="filter-pill" onclick="filterOrders('Cancelled', this)">Cancelled</button>
            </div>
          </div>
          <!-- Live Orders Search Bar -->
          <div style="display:flex;align-items:center;gap:12px;padding:0.85rem 1.5rem;background:#f8fafc;border-bottom:1px solid var(--border-color);flex-wrap:wrap;">
            <div style="position:relative;flex:1;max-width:380px;">
              <input type="text" id="orders-search-input" oninput="filterOrdersLive(this.value)" placeholder="Search Order #, customer name, email, phone..." style="width:100%;height:38px;padding:0 36px 0 34px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;outline:none;">
              <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--text-muted);display:flex;"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></span>
              <button type="button" onclick="clearOrdersSearch()" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--text-muted);cursor:pointer;display:none;padding:4px;" id="orders-search-clear"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
            </div>
            <span id="orders-count-badge" style="font-size:0.8125rem;color:var(--text-muted);font-weight:600;"></span>
          </div>
          <table class="data-table">
            <thead>
              <tr>
                <th>Order Number</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Contact</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="orders-full-tbody">
              <!-- Populated via JS -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- ==========================================
           TAB 3: STOCK & INVENTORY MANAGEMENT
           ========================================== -->
      <div id="tab-stock" class="tab-pane">
        <div class="table-container">
          <div class="table-header">
            <div class="table-title">Real-Time Stock Management</div>
            <div style="font-size:0.8125rem;color:var(--text-muted);">Click on any stock number to update quantities instantly.</div>
          </div>
          <!-- Live Stock Search Bar -->
          <div style="display:flex;align-items:center;gap:12px;padding:0.85rem 1.5rem;background:#f8fafc;border-bottom:1px solid var(--border-color);flex-wrap:wrap;">
            <div style="position:relative;flex:1;max-width:380px;">
              <input type="text" id="stock-search-input" oninput="filterStockLive(this.value)" placeholder="Search medical product title, color, category..." style="width:100%;height:38px;padding:0 36px 0 34px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;outline:none;">
              <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--text-muted);display:flex;"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></span>
              <button type="button" onclick="clearStockSearch()" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--text-muted);cursor:pointer;display:none;padding:4px;" id="stock-search-clear"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
            </div>
            <span id="stock-count-badge" style="font-size:0.8125rem;color:var(--text-muted);font-weight:600;"></span>
          </div>
          <table class="data-table">
            <thead>
              <tr>
                <th>Item</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Unit Price</th>
                <th>In Stock (Units)</th>
                <th>Stock Status</th>
                <th>Quick Actions</th>
              </tr>
            </thead>
            <tbody id="stock-tbody">
              <!-- Populated via JS -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- ==========================================
           TAB 4: PRODUCT CATALOG (FULL CRUD)
           ========================================== -->
      <div id="tab-products" class="tab-pane">
        <div class="table-container">
          <div class="table-header">
            <div class="table-title">Product Catalog &amp; Media</div>
            <button class="btn-primary" onclick="openAddProductModal()">+ Add New Product</button>
          </div>
          <!-- Live Products Search Bar -->
          <div style="display:flex;align-items:center;gap:12px;padding:0.85rem 1.5rem;background:#f8fafc;border-bottom:1px solid var(--border-color);flex-wrap:wrap;">
            <div style="position:relative;flex:1;max-width:380px;">
              <input type="text" id="products-search-input" oninput="filterProductsLive(this.value)" placeholder="Search title, category, badge, status..." style="width:100%;height:38px;padding:0 36px 0 34px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;outline:none;">
              <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--text-muted);display:flex;"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></span>
              <button type="button" onclick="clearProductsSearch()" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--text-muted);cursor:pointer;display:none;padding:4px;" id="products-search-clear"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
            </div>
            <span id="products-count-badge" style="font-size:0.8125rem;color:var(--text-muted);font-weight:600;"></span>
          </div>
          <table class="data-table">
            <thead>
              <tr>
                <th>Media</th>
                <th>Title</th>
                <th>Category</th>
                <th>Price / MRP</th>
                <th>Stock</th>
                <th>Badge</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="products-tbody">
              <!-- Populated via JS -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- ==========================================
           TAB: CATEGORIES MANAGEMENT (FULL CRUD)
           ========================================== -->
      <div id="tab-categories" class="tab-pane">
        <div class="table-container">
          <div class="table-header">
            <div>
              <div class="table-title">Medical Categories Management</div>
              <div style="font-size:0.8125rem;color:var(--text-muted);margin-top:2px;">Organize products into clinical specialties, adjust ordering, and update category imagery.</div>
            </div>
            <button class="btn-primary" onclick="openAddCategoryModal()">+ Add New Category</button>
          </div>
          <table class="data-table">
            <thead>
              <tr>
                <th>Image</th>
                <th>Category Name</th>
                <th>URL Slug</th>
                <th>Description</th>
                <th>Products</th>
                <th>Order</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="categories-tbody">
              <!-- Populated via JS -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- ==========================================
           TAB: NAVIGATION MENUS (FULL CRUD)
           ========================================== -->
      <div id="tab-menus" class="tab-pane">
        <div class="table-container">
          <div class="table-header">
            <div>
              <div class="table-title">Navigation &amp; Mega Menus Manager</div>
              <div style="font-size:0.8125rem;color:var(--text-muted);margin-top:2px;">Add, edit, rearrange, or toggle header navigation items, mega-menu links, and footer directories.</div>
            </div>
            <div style="display:flex;gap:0.75rem;align-items:center;">
              <div class="filter-pills">
                <button class="filter-pill active" onclick="filterMenus('all', this)">All Menus</button>
                <button class="filter-pill" onclick="filterMenus('header', this)">Header Bar</button>
                <button class="filter-pill" onclick="filterMenus('footer_company', this)">Footer Company</button>
                <button class="filter-pill" onclick="filterMenus('footer_quick_links', this)">Footer Quick Links</button>
              </div>
              <button class="btn-primary" onclick="openAddMenuModal()">+ Add Menu Item</button>
            </div>
          </div>
          <table class="data-table">
            <thead>
              <tr>
                <th>Order</th>
                <th>Menu Title</th>
                <th>Destination Link / URL</th>
                <th>Location</th>
                <th>Badge Pill</th>
                <th>Target</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="menus-tbody">
              <!-- Populated via JS -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- ==========================================
           TAB: COUPONS & DISCOUNTS
           ========================================== -->
      <div id="tab-coupons" class="tab-pane">
        <div class="table-container">
          <div class="table-header">
            <div>
              <div class="table-title">Coupons &amp; Promotional Codes</div>
              <div style="font-size:0.8125rem;color:var(--text-muted);margin-top:2px;">Create coupon codes for doctor discounts, percentage cuts, and free delivery threshold promotions.</div>
            </div>
            <button class="btn-primary" onclick="openAddCouponModal()">+ Create Promo Coupon</button>
          </div>
          <table class="data-table">
            <thead>
              <tr>
                <th>Coupon Code</th>
                <th>Type</th>
                <th>Discount Value</th>
                <th>Min. Order</th>
                <th>Max. Discount</th>
                <th>Usage Limit</th>
                <th>Times Used</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="coupons-tbody">
              <!-- Populated via JS -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- ==========================================
           TAB: DOCTOR REVIEWS & TESTIMONIALS
           ========================================== -->
      <div id="tab-reviews" class="tab-pane">
        <div class="table-container">
          <div class="table-header">
            <div>
              <div class="table-title">Verified Doctor Reviews Management</div>
              <div style="font-size:0.8125rem;color:var(--text-muted);margin-top:2px;">Manage doctor testimonials displayed on the storefront home page with verified badges and product endorsements.</div>
            </div>
            <button class="btn-primary" onclick="openAddReviewModal()">+ Add Doctor Review</button>
          </div>
          <table class="data-table">
            <thead>
              <tr>
                <th>Doctor Portrait</th>
                <th>Practitioner &amp; Hospital</th>
                <th>Rating</th>
                <th>Product Worn / Used</th>
                <th>Review Quote</th>
                <th>Highlight Badge</th>
                <th>Order</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="doctor-reviews-tbody">
              <!-- Populated via JS -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- ==========================================
           TAB: CUSTOMERS & DOCTORS DIRECTORY
           ========================================== -->
      <div id="tab-customers" class="tab-pane">
        <div class="table-container">
          <div class="table-header">
            <div>
              <div class="table-title">Doctor &amp; Customer Accounts</div>
              <div style="font-size:0.8125rem;color:var(--text-muted);margin-top:2px;">Directory of registered healthcare professionals, clinical buyers, lifetime spend and order history.</div>
            </div>
          </div>
          <!-- Live Customers Search Bar -->
          <div style="display:flex;align-items:center;gap:12px;padding:0.85rem 1.5rem;background:#f8fafc;border-bottom:1px solid var(--border-color);flex-wrap:wrap;">
            <div style="position:relative;flex:1;max-width:380px;">
              <input type="text" id="customers-search-input" oninput="filterCustomersLive(this.value)" placeholder="Search doctor name, hospital email, phone..." style="width:100%;height:38px;padding:0 36px 0 34px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;outline:none;">
              <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--text-muted);display:flex;"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></span>
              <button type="button" onclick="clearCustomersSearch()" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--text-muted);cursor:pointer;display:none;padding:4px;" id="customers-search-clear"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
            </div>
            <span id="customers-count-badge" style="font-size:0.8125rem;color:var(--text-muted);font-weight:600;"></span>
          </div>
          <table class="data-table">
            <thead>
              <tr>
                <th>Customer / Doctor</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Total Orders</th>
                <th>Lifetime Spend</th>
                <th>Last Order Date</th>
              </tr>
            </thead>
            <tbody id="customers-tbody">
              <!-- Populated via JS -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- ==========================================
           TAB 5: SALES REPORTS & ANALYTICS
           ========================================== -->
      <div id="tab-reports" class="tab-pane">
        <div class="metrics-grid">
          <div class="metric-card green">
            <div class="metric-label">All-Time Gross Sales</div>
            <div class="metric-val" id="rep-gross-sales">₹<?php echo number_format($metrics['revenue'], 2); ?></div>
          </div>
          <div class="metric-card">
            <div class="metric-label">Completed Orders</div>
            <div class="metric-val" id="rep-completed-orders"><?php echo $metrics['orders']; ?></div>
          </div>
          <div class="metric-card">
            <div class="metric-label">Average Order Value</div>
            <div class="metric-val" id="rep-aov">₹<?php echo $metrics['orders'] > 0 ? number_format($metrics['revenue'] / $metrics['orders'], 2) : '0'; ?></div>
          </div>
          <div class="metric-card amber">
            <div class="metric-label">Total Warehouse Units</div>
            <div class="metric-val" id="rep-warehouse-stock">...</div>
          </div>
        </div>

        <div class="table-container">
          <div class="table-header">
            <div class="table-title">Order Status Breakdown</div>
          </div>
          <div id="status-breakdown-container" style="padding:1.5rem;display:grid;grid-template-columns:repeat(auto-fit, minmax(180px, 1fr));gap:1rem;">
            <!-- Status cards -->
          </div>
        </div>
      </div>

      <!-- ==========================================
           TAB 6: SECURITY / PASSWORD CHANGE
           ========================================== -->
      <div id="tab-security" class="tab-pane">
        <div class="table-container" style="max-width:540px;">
          <div class="table-header">
            <div class="table-title">Change Administrator Password</div>
          </div>
          <div style="padding:2rem;">
            <form id="change-pass-form" onsubmit="handlePasswordChange(event)">
              <div class="form-group">
                <label>Current Admin Password</label>
                <input type="password" id="cur-pass" class="admin-input" placeholder="••••••••" required>
              </div>
              <div class="form-group">
                <label>New Password (min 6 characters)</label>
                <input type="password" id="new-pass" class="admin-input" placeholder="••••••••" required>
              </div>
              <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" id="conf-pass" class="admin-input" placeholder="••••••••" required>
              </div>
              <button type="submit" class="btn-primary" style="width:100%;height:44px;">Update Password</button>
            </form>
          </div>
        </div>
      </div>

    </main>
  </div>

  <!-- ==========================================
       MODAL: ORDER DETAILS
       ========================================== -->
  <div id="order-modal" class="admin-modal">
    <div class="admin-modal-box">
      <button class="modal-close" onclick="closeModal('order-modal')"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
      <h3 style="font-size:1.25rem;font-weight:700;margin-bottom:1rem;color:var(--primary);" id="ord-modal-title">Order Details</h3>
      <div id="ord-modal-body"></div>
    </div>
  </div>

  <!-- ==========================================
       MODAL: ADD / EDIT PRODUCT
       ========================================== -->
  <div id="product-modal" class="admin-modal">
    <div class="admin-modal-box">
      <button class="modal-close" onclick="closeModal('product-modal')"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
      <h3 style="font-size:1.25rem;font-weight:700;margin-bottom:1.25rem;color:var(--primary);" id="prod-modal-title">Add Medical Product</h3>

      <form id="product-form" onsubmit="handleProductSubmit(event)">
        <input type="hidden" id="prod-id" value="">

        <div class="form-row">
          <div class="form-group">
            <label>Product Title *</label>
            <input type="text" id="prod-title" class="admin-input" placeholder="e.g. Classic Women's V-Neck Scrub" required>
          </div>
          <div class="form-group">
            <label>Category *</label>
            <select id="prod-category" class="admin-select" required>
              <option value="Classic Scrubs">Classic Scrubs</option>
              <option value="ecoflex™ Scrubs">ecoflex™ Scrubs</option>
              <option value="Lab Coats">Lab Coats</option>
              <option value="Stethoscope">Stethoscope</option>
              <option value="Footwear">Footwear</option>
              <option value="Accessories">Accessories</option>
              <option value="Underscrubs">Underscrubs</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Gender Target</label>
            <select id="prod-gender" class="admin-select">
              <option value="Women">Women</option>
              <option value="Men">Men</option>
              <option value="Unisex">Unisex</option>
            </select>
          </div>
          <div class="form-group">
            <label>Badge / Tag</label>
            <input type="text" id="prod-badge" class="admin-input" placeholder="e.g. Bestseller / 4-Way Stretch / New">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Selling Price (₹) *</label>
            <input type="number" id="prod-price" class="admin-input" placeholder="1099" required>
          </div>
          <div class="form-group">
            <label>Original MRP (₹) *</label>
            <input type="number" id="prod-original-price" class="admin-input" placeholder="1599" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Initial Stock (Units) *</label>
            <input type="number" id="prod-stock" class="admin-input" placeholder="50" value="50" required>
          </div>
          <div class="form-group">
            <label>Color Name &amp; Hex</label>
            <div style="display:flex;gap:0.5rem;">
              <input type="text" id="prod-color-name" class="admin-input" placeholder="Navy Blue" value="Navy Blue" style="flex:2;">
              <input type="color" id="prod-color-hex" value="#1c2447" style="height:42px;width:50px;padding:2px;border:1px solid var(--border-color);border-radius:6px;cursor:pointer;">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Primary Image (CDN URL or Upload below) *</label>
          <input type="text" id="prod-primary-image" class="admin-input" placeholder="https://knyamed.com/cdn/shop/files/..." required>
        </div>

        <div class="form-group">
          <label>Or Upload Image from Computer</label>
          <input type="file" id="prod-file-upload" class="admin-input" accept="image/*" onchange="uploadImageFile(this)">
          <div id="upload-status" style="font-size:0.75rem;color:var(--accent);margin-top:4px;"></div>
        </div>

        <div class="form-group">
          <label>Clinical Description</label>
          <textarea id="prod-desc" class="admin-textarea" placeholder="Detailed product specifications, anti-microbial treatments..."></textarea>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Fabric Details</label>
            <input type="text" id="prod-fabric" class="admin-input" placeholder="65% Polyester, 35% Viscose blend">
          </div>
          <div class="form-group">
            <label>Pocket Specs</label>
            <input type="text" id="prod-pockets" class="admin-input" placeholder="3 functional pockets (1 chest, 2 front)">
          </div>
        </div>

        <button type="submit" class="btn-primary" style="width:100%;height:46px;margin-top:1rem;" id="prod-submit-btn">Save Product</button>
      </form>
    </div>
  </div>

  <!-- ==========================================
       MODAL: ADD / EDIT CATEGORY
       ========================================== -->
  <div id="category-modal" class="admin-modal">
    <div class="admin-modal-box" style="max-width:580px;">
      <button class="modal-close" onclick="closeModal('category-modal')"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
      <h3 style="font-size:1.25rem;font-weight:700;margin-bottom:1.25rem;color:var(--primary);" id="cat-modal-title">Add Medical Category</h3>

      <form id="category-form" onsubmit="handleCategorySubmit(event)">
        <input type="hidden" id="cat-id" value="">

        <div class="form-group">
          <label>Category Name *</label>
          <input type="text" id="cat-name" class="admin-input" placeholder="e.g. Compression Scrubs / Lab Coats" required>
        </div>

        <div class="form-group">
          <label>Category Image CDN URL *</label>
          <input type="text" id="cat-image" class="admin-input" placeholder="https://knyamed.com/cdn/shop/files/..." required>
        </div>

        <div class="form-group">
          <label>Display Sort Order (1, 2, 3...)</label>
          <input type="number" id="cat-order" class="admin-input" placeholder="1" value="1" required>
        </div>

        <div class="form-group">
          <label>Category Subtitle / Description</label>
          <textarea id="cat-desc" class="admin-textarea" rows="3" placeholder="Brief clinical summary displayed on storefront..."></textarea>
        </div>

        <button type="submit" class="btn-primary" style="width:100%;height:46px;margin-top:1rem;" id="cat-submit-btn">Save Category</button>
      </form>
    </div>
  </div>

  <!-- ==========================================
       MODAL: ADD / EDIT NAVIGATION MENU ITEM
       ========================================== -->
  <div id="menu-modal" class="admin-modal">
    <div class="admin-modal-box" style="max-width:620px;">
      <button class="modal-close" onclick="closeModal('menu-modal')"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
      <h3 style="font-size:1.25rem;font-weight:700;margin-bottom:1.25rem;color:var(--primary);" id="menu-modal-title">Add Navigation Menu Item</h3>

      <form id="menu-form" onsubmit="handleMenuSubmit(event)">
        <input type="hidden" id="menu-id" value="">

        <div class="form-row">
          <div class="form-group">
            <label>Menu Title *</label>
            <input type="text" id="menu-title" class="admin-input" placeholder="e.g. Women, ecoflex™, Stethoscopes" required>
          </div>
          <div class="form-group">
            <label>Menu Location *</label>
            <select id="menu-location" class="admin-select" required>
              <option value="header">Main Header Navigation Bar</option>
              <option value="footer_company">Footer: Company &amp; Hospital</option>
              <option value="footer_quick_links">Footer: Quick Links &amp; Care</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Target URL or Anchor Link *</label>
          <input type="text" id="menu-url" class="admin-input" placeholder="e.g. #classic-scrubs-section, #stethoscope-section, or https://..." required>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Badge Highlight (Optional)</label>
            <input type="text" id="menu-badge" class="admin-input" placeholder="e.g. NEW, POPULAR, STRETCH, HOT">
          </div>
          <div class="form-group">
            <label>Display Sort Order</label>
            <input type="number" id="menu-order" class="admin-input" placeholder="1" value="1" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Open In</label>
            <select id="menu-target" class="admin-select">
              <option value="_self">Same Window (_self)</option>
              <option value="_blank">New Tab (_blank)</option>
            </select>
          </div>
          <div class="form-group">
            <label>Active Status</label>
            <select id="menu-is-active" class="admin-select">
              <option value="1">Active (Visible in Storefront)</option>
              <option value="0">Hidden / Draft</option>
            </select>
          </div>
        </div>

        <button type="submit" class="btn-primary" style="width:100%;height:46px;margin-top:1rem;" id="menu-submit-btn">Save Menu Item</button>
      </form>
    </div>
  </div>

  <!-- ==========================================
       MODAL: ADD / EDIT PROMO COUPON
       ========================================== -->
  <div id="coupon-modal" class="admin-modal">
    <div class="admin-modal-box" style="max-width:580px;">
      <button class="modal-close" onclick="closeModal('coupon-modal')"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
      <h3 style="font-size:1.25rem;font-weight:700;margin-bottom:1.25rem;color:var(--primary);" id="coupon-modal-title">Create Promo Coupon</h3>

      <form id="coupon-form" onsubmit="handleCouponSubmit(event)">
        <input type="hidden" id="coupon-id" value="">

        <div class="form-row">
          <div class="form-group">
            <label>Coupon Code *</label>
            <input type="text" id="coupon-code" class="admin-input" placeholder="e.g. DOCTOR10, SURGEON20" style="text-transform:uppercase;font-weight:700;" required>
          </div>
          <div class="form-group">
            <label>Discount Type *</label>
            <select id="coupon-type" class="admin-select" required>
              <option value="percentage">Percentage Discount (%)</option>
              <option value="fixed">Fixed Flat Discount (₹)</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Discount Value *</label>
            <input type="number" step="0.1" id="coupon-value" class="admin-input" placeholder="10 (for 10%) or 200 (for ₹200)" required>
          </div>
          <div class="form-group">
            <label>Minimum Order Amount (₹)</label>
            <input type="number" id="coupon-min-order" class="admin-input" placeholder="1499" value="0">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Max Discount Cap (₹, 0 for no cap)</label>
            <input type="number" id="coupon-max-disc" class="admin-input" placeholder="500" value="0">
          </div>
          <div class="form-group">
            <label>Total Usage Limit (0 for unlimited)</label>
            <input type="number" id="coupon-limit" class="admin-input" placeholder="500" value="0">
          </div>
        </div>

        <div class="form-group">
          <label>Status</label>
          <select id="coupon-is-active" class="admin-select">
            <option value="1">Active</option>
            <option value="0">Disabled / Expired</option>
          </select>
        </div>

        <button type="submit" class="btn-primary" style="width:100%;height:46px;margin-top:1rem;" id="coupon-submit-btn">Save Coupon</button>
      </form>
    </div>
  </div>

  <!-- ==========================================
       MODAL: ADD / EDIT DOCTOR REVIEW
       ========================================== -->
  <div id="review-modal" class="admin-modal">
    <div class="admin-modal-box" style="max-width:680px;">
      <button class="modal-close" onclick="closeModal('review-modal')"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
      <h3 style="font-size:1.25rem;font-weight:700;margin-bottom:1.25rem;color:var(--primary);" id="review-modal-title">Add Doctor Review</h3>

      <form id="review-form" onsubmit="handleReviewSubmit(event)">
        <input type="hidden" id="review-id" value="">

        <div class="form-row">
          <div class="form-group">
            <label>Doctor Full Name *</label>
            <input type="text" id="review-doctor-name" class="admin-input" placeholder="Dr. Mili Dogra" required>
          </div>
          <div class="form-group">
            <label>Medical Specialty / Resident Role *</label>
            <input type="text" id="review-doctor-title" class="admin-input" placeholder="Anesthesiology Resident" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Hospital &amp; City *</label>
            <input type="text" id="review-hospital-name" class="admin-input" placeholder="AIIMS Hospital, New Delhi" required>
          </div>
          <div class="form-group">
            <label>Doctor Photo Avatar URL *</label>
            <input type="text" id="review-avatar-url" class="admin-input" placeholder="https://knyamed.com/cdn/shop/files/..." required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Star Rating (1 - 5)</label>
            <select id="review-rating" class="admin-select">
              <option value="5">5 Stars - Outstanding (Recommended)</option>
              <option value="4">4 Stars - Excellent</option>
              <option value="3">3 Stars - Good</option>
            </select>
          </div>
          <div class="form-group">
            <label>Product Worn / Endorsed</label>
            <input type="text" id="review-product-worn" class="admin-input" placeholder="e.g. Wears: ecoflex™ Scrub Suit (Navy Blue)">
          </div>
        </div>

        <div class="form-group">
          <label>Review Testimonial Text *</label>
          <textarea id="review-text" class="admin-textarea" rows="3" placeholder="Real clinical feedback on shift comfort, fluid resistance, fabric quality..." required></textarea>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Highlight Feature Tag</label>
            <input type="text" id="review-highlight-tag" class="admin-input" placeholder="e.g. 4-Way Stretch Tech / Acoustic Clarity" value="Verified Review">
          </div>
          <div class="form-group">
            <label>Display Sort Order</label>
            <input type="number" id="review-order" class="admin-input" value="1">
          </div>
        </div>

        <button type="submit" class="btn-primary" style="width:100%;height:46px;margin-top:1rem;" id="review-submit-btn">Save Doctor Review</button>
      </form>
    </div>
  </div>

  <script>
    // Tab Switching
    function switchTab(tabName, el) {
      document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
      document.querySelectorAll('.sidebar-menu .menu-item').forEach(m => m.classList.remove('active'));
      const target = document.getElementById('tab-' + tabName);
      if (target) target.classList.add('active');
      if (el) el.classList.add('active');

      const titles = {
        dashboard: 'Dashboard Overview',
        orders: 'Customer Orders Management',
        products: 'Product Catalog (Add, Edit, Update, Delete)',
        categories: 'Medical Categories Manager (Full CRUD)',
        menus: 'Navigation & Mega Menus Manager (Full CRUD)',
        coupons: 'Discount Coupons & Promotional Offers',
        reviews: 'Verified Doctor Reviews Management',
        customers: 'Registered Healthcare Buyers & Customers',
        stock: 'Stock & Inventory Management',
        reports: 'Sales & Financial Reports',
        security: 'Password & Security Settings'
      };
      document.getElementById('page-title').textContent = titles[tabName] || 'Admin Console';

      if (tabName === 'orders') loadOrders();
      if (tabName === 'stock') loadStock();
      if (tabName === 'products') loadProducts();
      if (tabName === 'categories') loadCategories();
      if (tabName === 'menus') loadMenus();
      if (tabName === 'coupons') loadCoupons();
      if (tabName === 'reviews') loadDoctorReviews();
      if (tabName === 'customers') loadCustomers();
      if (tabName === 'reports') loadSalesReport();
    }

    // Modal helpers
    function openModal(id) { document.getElementById(id).classList.add('active'); }
    function closeModal(id) { document.getElementById(id).classList.remove('active'); }

    // Load Orders
    let currentOrders = [];
    async function loadOrders(status = 'all') {
      try {
        const res = await fetch('api.php?action=get_orders&status=' + status);
        const data = await res.json();
        if (data.success) {
          currentOrders = data.orders;
          renderOrdersTable(data.orders);
          renderDashboardOrders(data.orders.slice(0, 5));
          const badge = document.getElementById('orders-count-badge');
          if (badge) badge.textContent = `Showing ${data.orders.length} of ${data.orders.length} orders`;
        }
      } catch (e) { console.error(e); }
    }

    function renderOrdersTable(orders) {
      const tbody = document.getElementById('orders-full-tbody');
      if (!tbody) return;
      if (orders.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center;padding:2rem;">No orders matching your search.</td></tr>';
        return;
      }
      tbody.innerHTML = orders.map(o => `
        <tr>
          <td><strong>${o.order_number}</strong></td>
          <td>${o.created_at.substring(0, 16)}</td>
          <td>${o.customer_name}<br><small style="color:var(--text-muted);">${o.customer_email}</small></td>
          <td>${o.customer_phone}</td>
          <td><strong>₹${Number(o.total).toLocaleString('en-IN')}</strong></td>
          <td><span style="font-weight:600;">${o.payment_method}</span></td>
          <td><span class="status-badge ${o.status.toLowerCase()}">${o.status}</span></td>
          <td>
            <button class="btn-secondary" style="padding:4px 8px;font-size:0.75rem;" onclick="viewOrderDetails(${o.id})">Details / Status</button>
          </td>
        </tr>
      `).join('');
    }

    // Live Orders Search
    function filterOrdersLive(q) {
      const clearBtn = document.getElementById('orders-search-clear');
      if (clearBtn) clearBtn.style.display = q ? 'block' : 'none';
      const term = q.toLowerCase().trim();
      const filtered = term ? currentOrders.filter(o =>
        (o.order_number && o.order_number.toLowerCase().includes(term)) ||
        (o.customer_name && o.customer_name.toLowerCase().includes(term)) ||
        (o.customer_email && o.customer_email.toLowerCase().includes(term)) ||
        (o.customer_phone && o.customer_phone.toLowerCase().includes(term)) ||
        (o.payment_method && o.payment_method.toLowerCase().includes(term)) ||
        (o.status && o.status.toLowerCase().includes(term))
      ) : currentOrders;
      renderOrdersTable(filtered);
      const badge = document.getElementById('orders-count-badge');
      if (badge) badge.textContent = `Showing ${filtered.length} of ${currentOrders.length} orders`;
    }

    function clearOrdersSearch() {
      const inp = document.getElementById('orders-search-input');
      if (inp) { inp.value = ''; filterOrdersLive(''); }
    }

    function renderDashboardOrders(orders) {
      const tbody = document.getElementById('dashboard-orders-tbody');
      if (!tbody) return;
      tbody.innerHTML = orders.map(o => `
        <tr>
          <td><strong>${o.order_number}</strong></td>
          <td>${o.customer_name}</td>
          <td>${o.items ? o.items.length : 1} item(s)</td>
          <td><strong>₹${Number(o.total).toLocaleString('en-IN')}</strong></td>
          <td>${o.payment_method}</td>
          <td><span class="status-badge ${o.status.toLowerCase()}">${o.status}</span></td>
          <td>
            <button class="btn-secondary" style="padding:4px 8px;font-size:0.75rem;" onclick="viewOrderDetails(${o.id})">View</button>
          </td>
        </tr>
      `).join('');
    }

    function filterOrders(status, btn) {
      document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
      if (btn) btn.classList.add('active');
      loadOrders(status);
    }

    // View Order Details Modal
    function viewOrderDetails(orderId) {
      const ord = currentOrders.find(o => o.id == orderId);
      if (!ord) return;

      const title = document.getElementById('ord-modal-title');
      const body = document.getElementById('ord-modal-body');
      title.textContent = `Order Details: ${ord.order_number}`;

      body.innerHTML = `
        <div style="background:#f8fafc;padding:1rem;border-radius:8px;margin-bottom:1.25rem;">
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;font-size:0.875rem;">
            <div><strong>Doctor / Customer:</strong> ${ord.customer_name}</div>
            <div><strong>Email:</strong> ${ord.customer_email}</div>
            <div><strong>Phone:</strong> ${ord.customer_phone}</div>
            <div><strong>Payment Method:</strong> ${ord.payment_method}</div>
            <div style="grid-column:1/-1;"><strong>Shipping Address:</strong> ${ord.shipping_address}</div>
          </div>
        </div>

        <h4 style="font-size:0.9375rem;font-weight:700;margin-bottom:0.75rem;">Ordered Items:</h4>
        <div style="border:1px solid var(--border-color);border-radius:8px;overflow:hidden;margin-bottom:1.25rem;">
          <table style="width:100%;border-collapse:collapse;font-size:0.875rem;">
            <thead><tr style="background:#f1f5f9;text-align:left;"><th style="padding:8px 12px;">Item</th><th style="padding:8px 12px;">Specs</th><th style="padding:8px 12px;">Qty</th><th style="padding:8px 12px;">Price</th></tr></thead>
            <tbody>
              ${(ord.items || []).map(i => `
                <tr style="border-bottom:1px solid var(--border-color);">
                  <td style="padding:8px 12px;"><strong>${i.product_title}</strong></td>
                  <td style="padding:8px 12px;font-size:0.8125rem;">Size: ${i.size} | Color: ${i.color} ${i.embroidery ? `<br><span style="color:var(--accent);display:inline-flex;align-items:center;gap:3px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg> "${i.embroidery}"</span>` : ''}</td>
                  <td style="padding:8px 12px;">${i.quantity}</td>
                  <td style="padding:8px 12px;"><strong>₹${i.product_price * i.quantity}</strong></td>
                </tr>
              `).join('')}
            </tbody>
          </table>
        </div>

        <div style="display:flex;justify-content:space-between;align-items:center;padding:1rem 0;border-top:1px solid var(--border-color);font-size:1.125rem;font-weight:700;">
          <span>Total Order Value:</span>
          <span>₹${Number(ord.total).toLocaleString('en-IN')}</span>
        </div>

        <div style="display:flex;gap:1rem;align-items:center;margin-top:1.25rem;background:#f8fafc;padding:1rem;border-radius:8px;">
          <label style="font-weight:600;font-size:0.875rem;">Update Order Status:</label>
          <select id="ord-status-select" class="admin-select" style="max-width:200px;">
            <option value="Processing" ${ord.status === 'Processing' ? 'selected' : ''}>Processing</option>
            <option value="Confirmed" ${ord.status === 'Confirmed' ? 'selected' : ''}>Confirmed</option>
            <option value="Shipped" ${ord.status === 'Shipped' ? 'selected' : ''}>Shipped</option>
            <option value="Delivered" ${ord.status === 'Delivered' ? 'selected' : ''}>Delivered</option>
            <option value="Cancelled" ${ord.status === 'Cancelled' ? 'selected' : ''}>Cancelled</option>
          </select>
          <button class="btn-primary" onclick="updateOrderStatus(${ord.id})">Save Status</button>
        </div>
      `;

      openModal('order-modal');
    }

    async function updateOrderStatus(orderId) {
      const select = document.getElementById('ord-status-select');
      const status = select.value;
      try {
        const res = await fetch('api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ action: 'update_order_status', order_id: orderId, status: status })
        });
        const data = await res.json();
        if (data.success) {
          alert('Order status updated!');
          closeModal('order-modal');
          loadOrders();
        }
      } catch (e) { alert('Failed to update status'); }
    }

    // Load Stock
    let currentProducts = [];
    async function loadStock() {
      await loadProducts();
      renderStockTable(currentProducts);
      const badge = document.getElementById('stock-count-badge');
      if (badge) badge.textContent = `Showing ${currentProducts.length} of ${currentProducts.length} items`;
    }

    function renderStockTable(products) {
      const tbody = document.getElementById('stock-tbody');
      if (!tbody) return;
      if (products.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" style="text-align:center;padding:2rem;">No items matching your search.</td></tr>';
        return;
      }
      tbody.innerHTML = products.map(p => `
        <tr>
          <td><img src="${p.primary_image}" class="thumbnail-img"></td>
          <td><strong>${p.title}</strong><br><small style="color:var(--text-muted);">${p.color_name || 'Standard'}</small></td>
          <td>${p.category}</td>
          <td>₹${p.price}</td>
          <td>
            <input type="number" value="${p.stock}" style="width:80px;height:34px;padding:4px;border:1px solid var(--border-color);border-radius:4px;font-weight:700;" onchange="saveStockDirect(${p.id}, this.value)">
          </td>
          <td>
            ${p.stock < 20 ? '<span class="status-badge cancelled">Low Stock</span>' : '<span class="status-badge delivered">In Stock</span>'}
          </td>
          <td>
            <button class="btn-secondary" style="padding:4px 8px;font-size:0.75rem;" onclick="addStockQuick(${p.id}, 25)">+25</button>
            <button class="btn-secondary" style="padding:4px 8px;font-size:0.75rem;" onclick="addStockQuick(${p.id}, 50)">+50</button>
          </td>
        </tr>
      `).join('');
    }

    // Live Stock Search
    function filterStockLive(q) {
      const clearBtn = document.getElementById('stock-search-clear');
      if (clearBtn) clearBtn.style.display = q ? 'block' : 'none';
      const term = q.toLowerCase().trim();
      const filtered = term ? currentProducts.filter(p =>
        (p.title && p.title.toLowerCase().includes(term)) ||
        (p.category && p.category.toLowerCase().includes(term)) ||
        (p.color_name && p.color_name.toLowerCase().includes(term))
      ) : currentProducts;
      renderStockTable(filtered);
      const badge = document.getElementById('stock-count-badge');
      if (badge) badge.textContent = `Showing ${filtered.length} of ${currentProducts.length} items`;
    }

    function clearStockSearch() {
      const inp = document.getElementById('stock-search-input');
      if (inp) { inp.value = ''; filterStockLive(''); }
    }

    async function saveStockDirect(productId, stock) {
      try {
        const res = await fetch('api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ action: 'update_stock', product_id: productId, stock: stock })
        });
        const data = await res.json();
        if (data.success) {
          console.log(data.message);
        }
      } catch (e) {}
    }

    async function addStockQuick(productId, increment) {
      const p = currentProducts.find(pr => pr.id == productId);
      if (!p) return;
      const newStock = Number(p.stock) + increment;
      await saveStockDirect(productId, newStock);
      loadStock();
    }

    // Load Products
    async function loadProducts() {
      try {
        const res = await fetch('api.php?action=get_products');
        const data = await res.json();
        if (data.success) {
          currentProducts = data.products;
          renderProductsTable(data.products);
          const badge = document.getElementById('products-count-badge');
          if (badge) badge.textContent = `Showing ${data.products.length} of ${data.products.length} products`;
        }
      } catch (e) { console.error(e); }
    }

    function renderProductsTable(prods) {
      const tbody = document.getElementById('products-tbody');
      if (!tbody) return;
      if (prods.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center;padding:2rem;">No products matching your search.</td></tr>';
        return;
      }
      tbody.innerHTML = prods.map(p => `
        <tr>
          <td><img src="${p.primary_image}" class="thumbnail-img"></td>
          <td><strong>${p.title}</strong></td>
          <td>${p.category}</td>
          <td><strong>₹${p.price}</strong> <small style="color:var(--text-muted);text-decoration:line-through;">₹${p.original_price}</small></td>
          <td>${p.stock} units</td>
          <td><span style="font-size:0.75rem;font-weight:600;color:var(--accent);">${p.badge || '—'}</span></td>
          <td><span class="status-badge ${p.status === 'active' ? 'delivered' : 'cancelled'}">${p.status}</span></td>
          <td>
            <button class="btn-secondary" style="padding:4px 8px;font-size:0.75rem;" onclick="editProductModal(${p.id})">Edit</button>
            <button class="btn-secondary" style="padding:4px 8px;font-size:0.75rem;color:#ef4444;" onclick="deleteProduct(${p.id})">Delete</button>
          </td>
        </tr>
      `).join('');
    }

    // Live Products Search
    function filterProductsLive(q) {
      const clearBtn = document.getElementById('products-search-clear');
      if (clearBtn) clearBtn.style.display = q ? 'block' : 'none';
      const term = q.toLowerCase().trim();
      const filtered = term ? currentProducts.filter(p =>
        (p.title && p.title.toLowerCase().includes(term)) ||
        (p.category && p.category.toLowerCase().includes(term)) ||
        (p.badge && p.badge.toLowerCase().includes(term)) ||
        (p.status && p.status.toLowerCase().includes(term))
      ) : currentProducts;
      renderProductsTable(filtered);
      const badge = document.getElementById('products-count-badge');
      if (badge) badge.textContent = `Showing ${filtered.length} of ${currentProducts.length} products`;
    }

    function clearProductsSearch() {
      const inp = document.getElementById('products-search-input');
      if (inp) { inp.value = ''; filterProductsLive(''); }
    }

    // Add / Edit Product Modal
    function openAddProductModal() {
      document.getElementById('prod-id').value = '';
      document.getElementById('product-form').reset();
      document.getElementById('prod-modal-title').textContent = 'Add New Medical Product';
      document.getElementById('prod-submit-btn').textContent = 'Create Product';
      openModal('product-modal');
    }

    function editProductModal(productId) {
      const p = currentProducts.find(pr => pr.id == productId);
      if (!p) return;

      document.getElementById('prod-id').value = p.id;
      document.getElementById('prod-title').value = p.title;
      document.getElementById('prod-category').value = p.category;
      document.getElementById('prod-gender').value = p.gender || 'Unisex';
      document.getElementById('prod-badge').value = p.badge || '';
      document.getElementById('prod-price').value = p.price;
      document.getElementById('prod-original-price').value = p.original_price;
      document.getElementById('prod-stock').value = p.stock;
      document.getElementById('prod-color-name').value = p.color_name || 'Navy Blue';
      document.getElementById('prod-color-hex').value = p.color_hex || '#1c2447';
      document.getElementById('prod-primary-image').value = p.primary_image;
      document.getElementById('prod-desc').value = p.description || '';
      document.getElementById('prod-fabric').value = p.fabric || '';
      document.getElementById('prod-pockets').value = p.pockets || '';

      document.getElementById('prod-modal-title').textContent = `Edit Product #${p.id}: ${p.title}`;
      document.getElementById('prod-submit-btn').textContent = 'Update Product Details';
      openModal('product-modal');
    }

    async function handleProductSubmit(e) {
      e.preventDefault();
      const id = document.getElementById('prod-id').value;
      const payload = {
        action: id ? 'update_product' : 'add_product',
        id: id,
        title: document.getElementById('prod-title').value.trim(),
        category: document.getElementById('prod-category').value,
        collection: document.getElementById('prod-category').value.toLowerCase().replace(/[^a-z]/g, ''),
        gender: document.getElementById('prod-gender').value,
        badge: document.getElementById('prod-badge').value.trim(),
        price: document.getElementById('prod-price').value,
        original_price: document.getElementById('prod-original-price').value,
        stock: document.getElementById('prod-stock').value,
        color_name: document.getElementById('prod-color-name').value.trim(),
        color_hex: document.getElementById('prod-color-hex').value,
        color_family: 'All ' + document.getElementById('prod-color-name').value.trim(),
        primary_image: document.getElementById('prod-primary-image').value.trim(),
        description: document.getElementById('prod-desc').value.trim(),
        fabric: document.getElementById('prod-fabric').value.trim(),
        pockets: document.getElementById('prod-pockets').value.trim()
      };

      try {
        const res = await fetch('api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
        const data = await res.json();
        if (data.success) {
          alert(data.message);
          closeModal('product-modal');
          loadProducts();
          loadStock();
        } else {
          alert(data.error || 'Operation failed');
        }
      } catch (err) { alert('Failed to save product'); }
    }

    async function deleteProduct(productId) {
      if (!confirm(`Are you sure you want to delete product #${productId}?`)) return;
      try {
        const res = await fetch('api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ action: 'delete_product', id: productId })
        });
        const data = await res.json();
        if (data.success) {
          alert('Product deleted!');
          loadProducts();
          loadStock();
        }
      } catch (e) { alert('Delete failed'); }
    }

    async function uploadImageFile(input) {
      if (!input.files || !input.files[0]) return;
      const file = input.files[0];
      const status = document.getElementById('upload-status');
      status.textContent = 'Uploading image...';

      const formData = new FormData();
      formData.append('action', 'upload_image');
      formData.append('image', file);

      try {
        const res = await fetch('api.php', { method: 'POST', body: formData });
        const data = await res.json();
        if (data.success) {
          status.textContent = 'Image uploaded successfully!';
          document.getElementById('prod-primary-image').value = data.url;
        } else {
          status.textContent = data.error || 'Upload failed';
        }
      } catch (e) {
        status.textContent = 'Error uploading image';
      }
    }

    // Sales Reports
    async function loadSalesReport() {
      try {
        const res = await fetch('api.php?action=sales_report');
        const data = await res.json();
        if (data.success) {
          document.getElementById('rep-gross-sales').textContent = '₹' + Number(data.metrics.total_revenue).toLocaleString('en-IN');
          document.getElementById('rep-completed-orders').textContent = data.metrics.total_orders;
          document.getElementById('rep-warehouse-stock').textContent = data.metrics.total_stock + ' Units';
          if (data.metrics.total_orders > 0) {
            document.getElementById('rep-aov').textContent = '₹' + Number(data.metrics.total_revenue / data.metrics.total_orders).toLocaleString('en-IN');
          }

          const statusCont = document.getElementById('status-breakdown-container');
          if (statusCont && data.status_breakdown) {
            statusCont.innerHTML = data.status_breakdown.map(s => `
              <div style="background:#f8fafc;padding:1rem;border-radius:8px;border:1px solid var(--border-color);text-align:center;">
                <span class="status-badge ${s.status.toLowerCase()}">${s.status}</span>
                <div style="font-size:1.5rem;font-weight:800;color:var(--primary);margin-top:0.5rem;">${s.count}</div>
              </div>
            `).join('');
          }
        }
      } catch (e) {}
    }

    // ==========================================
    // CATEGORIES MANAGEMENT (FULL CRUD)
    // ==========================================
    let currentCategories = [];
    async function loadCategories() {
      try {
        const res = await fetch('api.php?action=get_categories');
        const data = await res.json();
        if (data.success) {
          currentCategories = data.categories;
          renderCategoriesTable(data.categories);
          populateProductCategoryDropdown(data.categories);
        }
      } catch (e) { console.error(e); }
    }

    function renderCategoriesTable(cats) {
      const tbody = document.getElementById('categories-tbody');
      if (!tbody) return;
      if (cats.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" style="text-align:center;padding:2rem;">No categories defined. Click "+ Add New Category" to create one.</td></tr>';
        return;
      }
      tbody.innerHTML = cats.map(c => `
        <tr>
          <td><img src="${c.image || 'https://knyamed.com/cdn/shop/files/Women.png'}" class="thumbnail-img" style="border-radius:50%;width:44px;height:44px;object-fit:cover;"></td>
          <td><strong>${c.name}</strong></td>
          <td><code style="background:#f1f5f9;padding:2px 6px;border-radius:4px;font-size:0.75rem;">${c.slug}</code></td>
          <td style="max-width:280px;font-size:0.8125rem;color:var(--text-muted);">${c.description || '—'}</td>
          <td><span class="status-badge delivered">${c.product_count || 0} Products</span></td>
          <td><strong style="color:var(--primary);">${c.display_order || 0}</strong></td>
          <td>
            <button class="btn-secondary" style="padding:4px 8px;font-size:0.75rem;" onclick="editCategoryModal(${c.id})">Edit</button>
            <button class="btn-secondary" style="padding:4px 8px;font-size:0.75rem;color:#ef4444;" onclick="deleteCategory(${c.id}, '${c.name.replace(/'/g, "\\'")}')">Delete</button>
          </td>
        </tr>
      `).join('');
    }

    function populateProductCategoryDropdown(cats) {
      const select = document.getElementById('prod-category');
      if (!select) return;
      const currentVal = select.value;
      select.innerHTML = cats.map(c => `<option value="${c.name}">${c.name}</option>`).join('');
      if (currentVal) select.value = currentVal;
    }

    function openAddCategoryModal() {
      document.getElementById('cat-id').value = '';
      document.getElementById('category-form').reset();
      document.getElementById('cat-order').value = currentCategories.length + 1;
      document.getElementById('cat-modal-title').textContent = 'Add New Medical Category';
      document.getElementById('cat-submit-btn').textContent = 'Create Category';
      openModal('category-modal');
    }

    function editCategoryModal(catId) {
      const c = currentCategories.find(item => item.id == catId);
      if (!c) return;
      document.getElementById('cat-id').value = c.id;
      document.getElementById('cat-name').value = c.name;
      document.getElementById('cat-image').value = c.image || '';
      document.getElementById('cat-order').value = c.display_order || 1;
      document.getElementById('cat-desc').value = c.description || '';
      document.getElementById('cat-modal-title').textContent = `Edit Category: ${c.name}`;
      document.getElementById('cat-submit-btn').textContent = 'Update Category';
      openModal('category-modal');
    }

    async function handleCategorySubmit(e) {
      e.preventDefault();
      const id = document.getElementById('cat-id').value;
      const payload = {
        action: id ? 'update_category' : 'add_category',
        id: id,
        name: document.getElementById('cat-name').value.trim(),
        image: document.getElementById('cat-image').value.trim(),
        display_order: document.getElementById('cat-order').value,
        description: document.getElementById('cat-desc').value.trim()
      };

      try {
        const res = await fetch('api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
        const data = await res.json();
        if (data.success) {
          alert(data.message);
          closeModal('category-modal');
          loadCategories();
        } else {
          alert(data.error || 'Operation failed');
        }
      } catch (err) { alert('Failed to save category'); }
    }

    async function deleteCategory(id, name) {
      if (!confirm(`Are you sure you want to delete category "${name}"?`)) return;
      try {
        const res = await fetch('api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ action: 'delete_category', id: id })
        });
        const data = await res.json();
        if (data.success) {
          alert('Category deleted successfully!');
          loadCategories();
        } else {
          alert(data.error || 'Failed to delete');
        }
      } catch (e) { alert('Delete failed'); }
    }

    // ==========================================
    // NAVIGATION MENUS (FULL CRUD)
    // ==========================================
    let currentMenus = [];
    let activeMenuFilter = 'all';

    async function loadMenus(location = activeMenuFilter) {
      activeMenuFilter = location;
      try {
        const res = await fetch('api.php?action=get_menus&location=' + location);
        const data = await res.json();
        if (data.success) {
          currentMenus = data.menus;
          renderMenusTable(data.menus);
        }
      } catch (e) { console.error(e); }
    }

    function filterMenus(loc, btn) {
      document.querySelectorAll('#tab-menus .filter-pill').forEach(p => p.classList.remove('active'));
      if (btn) btn.classList.add('active');
      loadMenus(loc);
    }

    function renderMenusTable(menus) {
      const tbody = document.getElementById('menus-tbody');
      if (!tbody) return;
      if (menus.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center;padding:2rem;">No menu items found for this location. Click "+ Add Menu Item" to create one.</td></tr>';
        return;
      }
      tbody.innerHTML = menus.map(m => `
        <tr>
          <td><strong style="color:var(--primary);">${m.display_order}</strong></td>
          <td><strong>${m.title}</strong></td>
          <td><code style="background:#f1f5f9;padding:2px 6px;border-radius:4px;font-size:0.75rem;color:#1e40af;">${m.url}</code></td>
          <td><span style="font-size:0.75rem;font-weight:600;text-transform:uppercase;color:var(--text-muted);">${m.menu_location.replace('_', ' ')}</span></td>
          <td>${m.badge ? `<span style="background:#fee2e2;color:#991b1b;padding:2px 6px;border-radius:4px;font-size:0.7rem;font-weight:700;">${m.badge}</span>` : '—'}</td>
          <td><span style="font-size:0.75rem;color:var(--text-muted);">${m.target}</span></td>
          <td>
            <button class="status-badge ${m.is_active ? 'delivered' : 'cancelled'}" style="cursor:pointer;border:none;" onclick="toggleMenuStatus(${m.id})">
              ${m.is_active ? 'Active' : 'Hidden'}
            </button>
          </td>
          <td>
            <button class="btn-secondary" style="padding:4px 8px;font-size:0.75rem;" onclick="editMenuModal(${m.id})">Edit</button>
            <button class="btn-secondary" style="padding:4px 8px;font-size:0.75rem;color:#ef4444;" onclick="deleteMenu(${m.id}, '${m.title.replace(/'/g, "\\'")}')">Delete</button>
          </td>
        </tr>
      `).join('');
    }

    function openAddMenuModal() {
      document.getElementById('menu-id').value = '';
      document.getElementById('menu-form').reset();
      document.getElementById('menu-order').value = currentMenus.length + 1;
      document.getElementById('menu-modal-title').textContent = 'Add Navigation Menu Item';
      document.getElementById('menu-submit-btn').textContent = 'Save Menu Item';
      openModal('menu-modal');
    }

    function editMenuModal(menuId) {
      const m = currentMenus.find(item => item.id == menuId);
      if (!m) return;
      document.getElementById('menu-id').value = m.id;
      document.getElementById('menu-title').value = m.title;
      document.getElementById('menu-location').value = m.menu_location;
      document.getElementById('menu-url').value = m.url;
      document.getElementById('menu-badge').value = m.badge || '';
      document.getElementById('menu-order').value = m.display_order || 1;
      document.getElementById('menu-target').value = m.target || '_self';
      document.getElementById('menu-is-active').value = m.is_active ? '1' : '0';
      document.getElementById('menu-modal-title').textContent = `Edit Menu Item: ${m.title}`;
      document.getElementById('menu-submit-btn').textContent = 'Update Menu Item';
      openModal('menu-modal');
    }

    async function handleMenuSubmit(e) {
      e.preventDefault();
      const id = document.getElementById('menu-id').value;
      const payload = {
        action: id ? 'update_menu' : 'add_menu',
        id: id,
        title: document.getElementById('menu-title').value.trim(),
        menu_location: document.getElementById('menu-location').value,
        url: document.getElementById('menu-url').value.trim(),
        badge: document.getElementById('menu-badge').value.trim(),
        display_order: document.getElementById('menu-order').value,
        target: document.getElementById('menu-target').value,
        is_active: document.getElementById('menu-is-active').value
      };

      try {
        const res = await fetch('api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
        const data = await res.json();
        if (data.success) {
          alert(data.message);
          closeModal('menu-modal');
          loadMenus();
        } else {
          alert(data.error || 'Operation failed');
        }
      } catch (err) { alert('Failed to save menu'); }
    }

    async function deleteMenu(id, title) {
      if (!confirm(`Are you sure you want to delete menu item "${title}"?`)) return;
      try {
        const res = await fetch('api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ action: 'delete_menu', id: id })
        });
        const data = await res.json();
        if (data.success) {
          alert('Menu item deleted successfully!');
          loadMenus();
        } else {
          alert(data.error || 'Failed to delete');
        }
      } catch (e) { alert('Delete failed'); }
    }

    async function toggleMenuStatus(id) {
      try {
        const res = await fetch('api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ action: 'toggle_menu_status', id: id })
        });
        const data = await res.json();
        if (data.success) {
          loadMenus();
        }
      } catch (e) {}
    }

    // ==========================================
    // COUPONS MANAGEMENT (FULL CRUD)
    // ==========================================
    let currentCoupons = [];
    async function loadCoupons() {
      try {
        const res = await fetch('api.php?action=get_coupons');
        const data = await res.json();
        if (data.success) {
          currentCoupons = data.coupons;
          renderCouponsTable(data.coupons);
        }
      } catch (e) { console.error(e); }
    }

    function renderCouponsTable(coupons) {
      const tbody = document.getElementById('coupons-tbody');
      if (!tbody) return;
      if (coupons.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9" style="text-align:center;padding:2rem;">No coupons found. Click "+ Create Promo Coupon" to add one.</td></tr>';
        return;
      }
      tbody.innerHTML = coupons.map(c => `
        <tr>
          <td><strong style="letter-spacing:0.05em;color:var(--primary);font-size:0.9375rem;">${c.code}</strong></td>
          <td><span style="font-size:0.75rem;text-transform:uppercase;color:var(--text-muted);font-weight:600;">${c.discount_type}</span></td>
          <td><strong style="color:#059669;">${c.discount_type === 'percentage' ? c.discount_value + '%' : '₹' + c.discount_value} OFF</strong></td>
          <td>₹${Number(c.min_order_amount).toLocaleString('en-IN')}</td>
          <td>${c.max_discount_amount > 0 ? '₹' + c.max_discount_amount : 'No Cap'}</td>
          <td>${c.usage_limit > 0 ? c.usage_limit + ' uses' : 'Unlimited'}</td>
          <td><strong>${c.times_used || 0}</strong></td>
          <td>
            <button class="status-badge ${c.is_active ? 'delivered' : 'cancelled'}" style="cursor:pointer;border:none;" onclick="toggleCouponStatus(${c.id})">
              ${c.is_active ? 'Active' : 'Disabled'}
            </button>
          </td>
          <td>
            <button class="btn-secondary" style="padding:4px 8px;font-size:0.75rem;" onclick="editCouponModal(${c.id})">Edit</button>
            <button class="btn-secondary" style="padding:4px 8px;font-size:0.75rem;color:#ef4444;" onclick="deleteCoupon(${c.id}, '${c.code}')">Delete</button>
          </td>
        </tr>
      `).join('');
    }

    function openAddCouponModal() {
      document.getElementById('coupon-id').value = '';
      document.getElementById('coupon-form').reset();
      document.getElementById('coupon-modal-title').textContent = 'Create Promo Coupon';
      document.getElementById('coupon-submit-btn').textContent = 'Create Coupon';
      openModal('coupon-modal');
    }

    function editCouponModal(id) {
      const c = currentCoupons.find(cp => cp.id == id);
      if (!c) return;
      document.getElementById('coupon-id').value = c.id;
      document.getElementById('coupon-code').value = c.code;
      document.getElementById('coupon-type').value = c.discount_type;
      document.getElementById('coupon-value').value = c.discount_value;
      document.getElementById('coupon-min-order').value = c.min_order_amount;
      document.getElementById('coupon-max-disc').value = c.max_discount_amount || 0;
      document.getElementById('coupon-limit').value = c.usage_limit || 0;
      document.getElementById('coupon-is-active').value = c.is_active ? '1' : '0';
      document.getElementById('coupon-modal-title').textContent = `Edit Coupon: ${c.code}`;
      document.getElementById('coupon-submit-btn').textContent = 'Update Coupon';
      openModal('coupon-modal');
    }

    async function handleCouponSubmit(e) {
      e.preventDefault();
      const id = document.getElementById('coupon-id').value;
      const payload = {
        action: id ? 'update_coupon' : 'add_coupon',
        id: id,
        code: document.getElementById('coupon-code').value.trim().toUpperCase(),
        discount_type: document.getElementById('coupon-type').value,
        discount_value: document.getElementById('coupon-value').value,
        min_order_amount: document.getElementById('coupon-min-order').value,
        max_discount_amount: document.getElementById('coupon-max-disc').value,
        usage_limit: document.getElementById('coupon-limit').value,
        is_active: document.getElementById('coupon-is-active').value
      };

      try {
        const res = await fetch('api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
        const data = await res.json();
        if (data.success) {
          alert(data.message);
          closeModal('coupon-modal');
          loadCoupons();
        } else {
          alert(data.error || 'Operation failed');
        }
      } catch (err) { alert('Failed to save coupon'); }
    }

    async function deleteCoupon(id, code) {
      if (!confirm(`Are you sure you want to delete coupon code "${code}"?`)) return;
      try {
        const res = await fetch('api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ action: 'delete_coupon', id: id })
        });
        const data = await res.json();
        if (data.success) {
          alert('Coupon deleted successfully!');
          loadCoupons();
        }
      } catch (e) { alert('Delete failed'); }
    }

    async function toggleCouponStatus(id) {
      try {
        const res = await fetch('api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ action: 'toggle_coupon_status', id: id })
        });
        const data = await res.json();
        if (data.success) {
          loadCoupons();
        }
      } catch (e) {}
    }

    // ==========================================
    // DOCTOR REVIEWS & TESTIMONIALS (FULL CRUD)
    // ==========================================
    let currentReviews = [];
    async function loadDoctorReviews() {
      try {
        const res = await fetch('api.php?action=get_doctor_reviews');
        const data = await res.json();
        if (data.success) {
          currentReviews = data.reviews;
          renderDoctorReviewsTable(data.reviews);
        }
      } catch (e) { console.error(e); }
    }

    function renderDoctorReviewsTable(revs) {
      const tbody = document.getElementById('doctor-reviews-tbody');
      if (!tbody) return;
      if (revs.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center;padding:2rem;">No doctor reviews found. Click "+ Add Doctor Review" to create one.</td></tr>';
        return;
      }
      tbody.innerHTML = revs.map(r => `
        <tr>
          <td><img src="${r.avatar_url}" style="width:44px;height:44px;border-radius:50%;object-fit:cover;border:2px solid var(--border-color);"></td>
          <td><strong>${r.doctor_name}</strong><br><small style="color:var(--text-muted);">${r.doctor_title} • ${r.hospital_name}</small></td>
          <td><span style="display:inline-flex;gap:2px;">${'<svg width="12" height="12" viewBox="0 0 24 24" fill="#f59e0b"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>'.repeat(r.rating || 5)}</span></td>
          <td style="font-size:0.8125rem;">${r.product_worn || '—'}</td>
          <td style="max-width:320px;font-size:0.8125rem;color:var(--text-muted);font-style:italic;">"${r.review_text.substring(0, 110)}..."</td>
          <td><span class="status-badge confirmed" style="font-size:0.7rem;">${r.highlight_tag || 'Verified'}</span></td>
          <td><strong style="color:var(--primary);">${r.display_order || 1}</strong></td>
          <td>
            <button class="btn-secondary" style="padding:4px 8px;font-size:0.75rem;" onclick="editReviewModal(${r.id})">Edit</button>
            <button class="btn-secondary" style="padding:4px 8px;font-size:0.75rem;color:#ef4444;" onclick="deleteReview(${r.id}, '${r.doctor_name.replace(/'/g, "\\'")}')">Delete</button>
          </td>
        </tr>
      `).join('');
    }

    function openAddReviewModal() {
      document.getElementById('review-id').value = '';
      document.getElementById('review-form').reset();
      document.getElementById('review-order').value = currentReviews.length + 1;
      document.getElementById('review-modal-title').textContent = 'Add Doctor Review';
      document.getElementById('review-submit-btn').textContent = 'Save Doctor Review';
      openModal('review-modal');
    }

    function editReviewModal(id) {
      const r = currentReviews.find(rev => rev.id == id);
      if (!r) return;
      document.getElementById('review-id').value = r.id;
      document.getElementById('review-doctor-name').value = r.doctor_name;
      document.getElementById('review-doctor-title').value = r.doctor_title;
      document.getElementById('review-hospital-name').value = r.hospital_name;
      document.getElementById('review-avatar-url').value = r.avatar_url;
      document.getElementById('review-rating').value = r.rating || 5;
      document.getElementById('review-product-worn').value = r.product_worn || '';
      document.getElementById('review-text').value = r.review_text;
      document.getElementById('review-highlight-tag').value = r.highlight_tag || 'Verified Review';
      document.getElementById('review-order').value = r.display_order || 1;
      document.getElementById('review-modal-title').textContent = `Edit Review: ${r.doctor_name}`;
      document.getElementById('review-submit-btn').textContent = 'Update Review';
      openModal('review-modal');
    }

    async function handleReviewSubmit(e) {
      e.preventDefault();
      const id = document.getElementById('review-id').value;
      const payload = {
        action: id ? 'update_doctor_review' : 'add_doctor_review',
        id: id,
        doctor_name: document.getElementById('review-doctor-name').value.trim(),
        doctor_title: document.getElementById('review-doctor-title').value.trim(),
        hospital_name: document.getElementById('review-hospital-name').value.trim(),
        avatar_url: document.getElementById('review-avatar-url').value.trim(),
        rating: document.getElementById('review-rating').value,
        product_worn: document.getElementById('review-product-worn').value.trim(),
        review_text: document.getElementById('review-text').value.trim(),
        highlight_tag: document.getElementById('review-highlight-tag').value.trim(),
        display_order: document.getElementById('review-order').value
      };

      try {
        const res = await fetch('api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
        const data = await res.json();
        if (data.success) {
          alert(data.message);
          closeModal('review-modal');
          loadDoctorReviews();
        } else {
          alert(data.error || 'Operation failed');
        }
      } catch (err) { alert('Failed to save review'); }
    }

    async function deleteReview(id, name) {
      if (!confirm(`Are you sure you want to delete review by "${name}"?`)) return;
      try {
        const res = await fetch('api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ action: 'delete_doctor_review', id: id })
        });
        const data = await res.json();
        if (data.success) {
          alert('Review deleted successfully!');
          loadDoctorReviews();
        }
      } catch (e) { alert('Delete failed'); }
    }

    // ==========================================
    // CUSTOMERS & DOCTORS DIRECTORY
    // ==========================================
    let currentCustomersList = [];
    async function loadCustomers() {
      try {
        const res = await fetch('api.php?action=get_customers');
        const data = await res.json();
        if (data.success) {
          currentCustomersList = data.customers;
          renderCustomersTable(data.customers);
          const badge = document.getElementById('customers-count-badge');
          if (badge) badge.textContent = `Showing ${data.customers.length} of ${data.customers.length} accounts`;
        }
      } catch (e) { console.error(e); }
    }

    function renderCustomersTable(customers) {
      const tbody = document.getElementById('customers-tbody');
      if (!tbody) return;
      if (customers.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;padding:2rem;">No customer accounts matching your search.</td></tr>';
        return;
      }
      tbody.innerHTML = customers.map(c => `
        <tr>
          <td><strong style="color:var(--primary);">${c.name || 'Healthcare Practitioner'}</strong></td>
          <td>${c.email || '—'}</td>
          <td>${c.phone || '—'}</td>
          <td><span class="status-badge delivered">${c.total_orders} Orders</span></td>
          <td><strong style="color:#059669;">₹${Number(c.total_spent).toLocaleString('en-IN')}</strong></td>
          <td style="font-size:0.8125rem;color:var(--text-muted);">${c.last_order_date ? c.last_order_date.substring(0, 16) : '—'}</td>
        </tr>
      `).join('');
    }

    // Live Customers Search
    function filterCustomersLive(q) {
      const clearBtn = document.getElementById('customers-search-clear');
      if (clearBtn) clearBtn.style.display = q ? 'block' : 'none';
      const term = q.toLowerCase().trim();
      const filtered = term ? currentCustomersList.filter(c =>
        (c.name && c.name.toLowerCase().includes(term)) ||
        (c.email && c.email.toLowerCase().includes(term)) ||
        (c.phone && c.phone.toLowerCase().includes(term))
      ) : currentCustomersList;
      renderCustomersTable(filtered);
      const badge = document.getElementById('customers-count-badge');
      if (badge) badge.textContent = `Showing ${filtered.length} of ${currentCustomersList.length} accounts`;
    }

    function clearCustomersSearch() {
      const inp = document.getElementById('customers-search-input');
      if (inp) { inp.value = ''; filterCustomersLive(''); }
    }

    // Password Change
    async function handlePasswordChange(e) {
      e.preventDefault();
      const cur = document.getElementById('cur-pass').value;
      const n1 = document.getElementById('new-pass').value;
      const n2 = document.getElementById('conf-pass').value;

      if (n1 !== n2) {
        alert('New passwords do not match');
        return;
      }

      try {
        const res = await fetch('api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ action: 'change_password', current_password: cur, new_password: n1 })
        });
        const data = await res.json();
        if (data.success) {
          alert('Admin password updated successfully! Please remember your new password.');
          document.getElementById('change-pass-form').reset();
        } else {
          alert(data.error || 'Failed to update password');
        }
      } catch (e) { alert('Password change request failed'); }
    }

    // Init
    document.addEventListener('DOMContentLoaded', () => {
      loadOrders();
      loadProducts();
      loadCategories();
    });
  </script>
</body>
</html>

