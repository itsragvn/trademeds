<?php
require_once __DIR__ . '/../config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $pdo = getDB();
    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['admin_user'] = [
            'id' => $admin['id'],
            'username' => $admin['username'],
            'email' => $admin['email'],
            'role' => $admin['role']
        ];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid admin credentials. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Portal Login – TRADE MEDS</title>
  <link rel="icon" type="image/png" sizes="32x32" href="../images/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon-16x16.png">
  <link rel="apple-touch-icon" sizes="180x180" href="../images/apple-touch-icon.png">
  <link rel="shortcut icon" href="../favicon.ico">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Heebo', sans-serif;
      background: linear-gradient(135deg, #011c42 0%, #012a63 50%, #034b22 100%);
      color: #f8fafc;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
    }
    .login-card {
      background: rgba(1, 28, 66, 0.92);
      backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.12);
      border-radius: 16px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
      width: 100%;
      max-width: 440px;
      padding: 2.5rem;
    }
    .logo-box {
      text-align: center;
      margin-bottom: 2rem;
    }
    .logo-box img {
      height: 46px;
      background: #ffffff;
      padding: 6px 14px;
      border-radius: 8px;
      margin-bottom: 0.75rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    .logo-box h2 {
      font-size: 1.25rem;
      font-weight: 700;
      color: #ffffff;
      letter-spacing: -0.01em;
    }
    .logo-box p {
      font-size: 0.875rem;
      color: #94a3b8;
    }
    .form-group {
      margin-bottom: 1.25rem;
    }
    .form-group label {
      display: block;
      font-size: 0.8125rem;
      font-weight: 600;
      color: #cbd5e1;
      margin-bottom: 0.4rem;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }
    .form-input {
      width: 100%;
      height: 46px;
      background: #011c42;
      border: 1px solid #1e3a68;
      border-radius: 8px;
      padding: 0 1rem;
      color: #ffffff;
      font-size: 0.9375rem;
      outline: none;
      transition: border-color 0.2s;
    }
    .form-input:focus {
      border-color: #04780c;
      box-shadow: 0 0 0 3px rgba(4, 120, 12, 0.25);
    }
    .login-btn {
      width: 100%;
      height: 48px;
      background: linear-gradient(135deg, #012a63 0%, #04780c 100%);
      color: #ffffff;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(4, 120, 12, 0.35);
      transition: all 0.2s;
      margin-top: 0.75rem;
    }
    .login-btn:hover {
      filter: brightness(1.1);
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(4, 120, 12, 0.5);
    }
    .login-btn:active {
      transform: scale(0.98);
    }
    .error-alert {
      background: rgba(225, 29, 72, 0.15);
      border: 1px solid #e11d48;
      color: #fecdd3;
      padding: 0.75rem 1rem;
      border-radius: 8px;
      font-size: 0.875rem;
      margin-bottom: 1.25rem;
    }
    .demo-hint {
      margin-top: 1.5rem;
      padding: 1rem;
      background: rgba(15, 23, 42, 0.6);
      border-radius: 8px;
      border: 1px dashed #334155;
      font-size: 0.8125rem;
      color: #94a3b8;
    }
    .demo-hint strong {
      color: #38bdf8;
    }
    .back-link {
      display: block;
      text-align: center;
      margin-top: 1.25rem;
      font-size: 0.8125rem;
      color: #94a3b8;
      text-decoration: none;
    }
    .back-link:hover {
      color: #ffffff;
    }
  </style>
</head>
<body>

  <div class="login-card">
    <div class="logo-box">
      <img src="../images/trade-meds-logo/trade-meds.png" alt="TRADE MEDS">
      <h2>Administrative Console</h2>
      <p>Secure Management &amp; Stock Operations</p>
    </div>

    <?php if ($error): ?>
      <div class="error-alert"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
      <div class="form-group">
        <label for="username">Admin Username or Email</label>
        <input type="text" id="username" name="username" class="form-input" placeholder="admin" value="admin" required autofocus>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <div style="position:relative;">
          <input type="password" id="password" name="password" class="form-input" style="padding-right:44px;" placeholder="••••••••" value="admin123" required>
          <button type="button" id="admin-pass-toggle" onclick="toggleAdminPassword()" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:#94a3b8;cursor:pointer;padding:6px;display:flex;align-items:center;" aria-label="Toggle password visibility">
            <svg class="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
          </button>
        </div>
      </div>

      <button type="submit" class="login-btn">Sign In to Dashboard</button>
    </form>

    <div class="demo-hint" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;">
      <div>
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:-2px;margin-right:4px;"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg><strong>Default Admin Access:</strong><br>
        <code>admin</code> / <code>admin123</code>
      </div>
      <button type="button" onclick="autofillAdmin()" style="background:rgba(56,189,248,0.15);border:1px solid #38bdf8;color:#38bdf8;padding:6px 12px;border-radius:6px;font-size:0.75rem;font-weight:700;cursor:pointer;transition:all 0.2s;">
        1-Click Autofill
      </button>
    </div>

    <a href="../index.php" class="back-link">← Return to TRADE MEDS Storefront</a>
  </div>

  <script>
    function toggleAdminPassword() {
      const pass = document.getElementById('password');
      const btn = document.getElementById('admin-pass-toggle');
      if (!pass) return;
      const isPass = pass.type === 'password';
      pass.type = isPass ? 'text' : 'password';
      if (btn) {
        btn.innerHTML = isPass
          ? '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>'
          : '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
      }
    }

    function autofillAdmin() {
      document.getElementById('username').value = 'admin';
      document.getElementById('password').value = 'admin123';
      const btn = event.target;
      if (btn) {
        const orig = btn.innerText;
        btn.innerText = 'Autofilled!';
        btn.style.background = '#04780c';
        btn.style.color = '#ffffff';
        setTimeout(() => {
          btn.innerText = orig;
          btn.style.background = 'rgba(56,189,248,0.15)';
          btn.style.color = '#38bdf8';
        }, 1500);
      }
    }
  </script>

</body>
</html>

