  <!-- Backdrop Overlay -->
  <div id="drawer-backdrop" class="drawer-backdrop" onclick="window.TM.closeCartDrawer();window.TM.closeMobileMenu();"></div>

  <!-- SLIDE-OVER SHOPPING CART DRAWER -->
  <aside id="cart-drawer" class="cart-drawer" aria-label="Shopping Cart Drawer">
    <div class="drawer-header">
      <h3 class="drawer-title">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
        <span>Your Bag</span>
        <span id="cart-drawer-count" style="font-size:0.9375rem;font-weight:500;color:var(--tm-text-secondary);">(0)</span>
      </h3>
      <button type="button" class="drawer-close-btn" onclick="window.TM.closeCartDrawer()" aria-label="Close Cart"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
    </div>

    <!-- Free Delivery Progress Tracker -->
    <div class="cart-shipping-bar">
      <div class="shipping-bar-text" id="cart-shipping-text">Add <strong>₹1,499</strong> more to unlock <strong>FREE Delivery</strong>!</div>
      <div class="shipping-progress-bg">
        <div class="shipping-progress-fill" id="cart-shipping-progress" style="width: 0%;"></div>
      </div>
    </div>

    <!-- Empty State -->
    <div id="cart-empty-state" style="display:none;text-align:center;padding:4rem 1.5rem;">
      <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--tm-text-light)" stroke-width="1.5" style="margin:0 auto 1rem;"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
      <h4 style="font-size:1.125rem;font-weight:700;color:var(--tm-primary);margin-bottom:0.5rem;">Your bag is empty</h4>
      <p style="font-size:0.875rem;color:var(--tm-text-secondary);margin-bottom:1.5rem;">Explore our best selling scrubs, doctor aprons, and stethoscopes.</p>
      <button type="button" class="newsletter-btn" onclick="window.TM.closeCartDrawer()">Start Shopping</button>
    </div>

    <!-- Cart Items Scrollable List -->
    <div class="cart-items-body" id="cart-items-body"></div>

    <!-- Cart Footer with Coupon & Checkout -->
    <div class="cart-drawer-footer" id="cart-drawer-footer">
      <div class="cart-coupon-row">
        <input type="text" id="cart-coupon-input" class="cart-coupon-input" placeholder="Promo code (e.g. FLASH12)">
        <button type="button" class="cart-coupon-btn" onclick="window.TM.applyCoupon()">Apply</button>
      </div>

      <div class="cart-summary-line">
        <span>Subtotal</span>
        <span id="cart-subtotal">₹0</span>
      </div>
      <div class="cart-summary-line" id="cart-discount-row" style="display:none;color:var(--tm-green);">
        <span>Discount (Promo)</span>
        <span id="cart-discount">-₹0</span>
      </div>
      <div class="cart-summary-line">
        <span>Delivery Fee</span>
        <span id="cart-shipping">Calculated</span>
      </div>
      <div class="cart-summary-line total">
        <span>Estimated Total</span>
        <span id="cart-total">₹0</span>
      </div>

      <button type="button" class="cart-checkout-btn" onclick="window.TM.checkout()">
        <span>Proceed to Checkout</span>
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </button>
    </div>
  </aside>

  <!-- QUICK VIEW PRODUCT MODAL -->
  <div id="quickview-modal" class="modal-overlay">
    <div class="modal-box">
      <button type="button" class="modal-close-btn" onclick="window.TM.closeModal('quickview-modal')"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
      <div id="quickview-content"></div>
    </div>
  </div>

  <!-- WISHLIST MODAL -->
  <div id="wishlist-modal" class="modal-overlay">
    <div class="modal-box" style="max-width:760px;">
      <div class="drawer-header">
        <h3 class="drawer-title">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" style="color:var(--tm-red)"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
          <span>Saved to Wishlist</span>
        </h3>
        <button type="button" class="modal-close-btn" onclick="window.TM.closeModal('wishlist-modal')"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
      </div>
      <div id="wishlist-modal-body" style="padding:1.5rem;max-height:75vh;overflow-y:auto;"></div>
    </div>
  </div>

  <!-- ==========================================
       CUSTOMER AUTHENTICATION MODAL (2-OPTIONS)
       Option 1: Email OTP Authentication
       Option 2: Password Login / New Account Registration
       ========================================== -->
  <div id="auth-modal" class="modal-overlay">
    <div class="modal-box" style="max-width:480px;padding:2.25rem;border-radius:var(--radius-lg);">
      <button type="button" class="modal-close-btn" onclick="window.TM.closeModal('auth-modal')"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
      
      <div style="text-align:center;margin-bottom:1.5rem;">
        <img src="images/trade-meds-logo/trade-meds.png" style="height:42px;margin:0 auto 0.75rem;" alt="TRADE MEDS">
        <h3 style="font-size:1.35rem;font-weight:800;color:var(--tm-primary);margin-bottom:0.25rem;">Healthcare Professional Portal</h3>
        <p style="font-size:0.875rem;color:var(--tm-text-secondary);">Access orders, instant scrubs dispatch & clinical rewards</p>
      </div>

      <!-- Main Tabs: Log In vs Create Account vs Forgot Password -->
      <div style="display:flex;border-bottom:2px solid var(--tm-border-light);margin-bottom:1.5rem;">
        <button type="button" id="auth-tab-login" class="auth-tab-btn active" onclick="window.TM.switchAuthTab('login')" style="flex:1;padding:0.75rem 0.5rem;border:none;background:none;font-weight:700;font-size:0.9rem;cursor:pointer;color:var(--tm-primary);border-bottom:3px solid var(--tm-primary);">Log In</button>
        <button type="button" id="auth-tab-register" class="auth-tab-btn" onclick="window.TM.switchAuthTab('register')" style="flex:1;padding:0.75rem 0.5rem;border:none;background:none;font-weight:600;font-size:0.9rem;cursor:pointer;color:var(--tm-text-muted);border-bottom:3px solid transparent;">Create Account</button>
        <button type="button" id="auth-tab-forgot" class="auth-tab-btn" onclick="window.TM.switchAuthTab('forgot')" style="flex:1;padding:0.75rem 0.5rem;border:none;background:none;font-weight:600;font-size:0.9rem;cursor:pointer;color:var(--tm-text-muted);border-bottom:3px solid transparent;">Forgot Password</button>
      </div>

      <!-- PANEL 1: LOGIN (DIRECT EMAIL & PASSWORD) -->
      <div id="auth-panel-login">
        <form id="pass-login-form" onsubmit="window.TM.handlePasswordLogin(event)">
          <div style="margin-bottom:1.15rem;">
            <label style="display:block;font-size:0.8125rem;font-weight:700;color:var(--tm-primary);margin-bottom:0.4rem;">Hospital / Personal Email</label>
            <input type="email" id="pass-login-email" class="newsletter-input" style="width:100%;border-radius:var(--radius-sm);" placeholder="doctor@hospital.com or yourname@gmail.com" required autocomplete="email">
          </div>
          <div style="margin-bottom:1.15rem;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.4rem;">
              <label style="font-size:0.8125rem;font-weight:700;color:var(--tm-primary);margin:0;">Password</label>
              <a href="javascript:void(0)" onclick="window.TM.switchAuthTab('forgot')" style="font-size:0.75rem;color:var(--tm-accent-blue);font-weight:600;text-decoration:none;">Forgot Password?</a>
            </div>
            <div style="position:relative;">
              <input type="password" id="pass-login-pass" class="newsletter-input" style="width:100%;padding-right:42px;border-radius:var(--radius-sm);" placeholder="Enter your password" required autocomplete="current-password">
              <button type="button" onclick="window.TM.togglePasswordVisibility('pass-login-pass', this)" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--tm-text-muted);cursor:pointer;padding:6px;display:flex;align-items:center;" aria-label="Toggle password visibility">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
              </button>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-top:0.65rem;font-size:0.8125rem;">
              <label style="display:flex;align-items:center;gap:6px;cursor:pointer;color:var(--tm-text-secondary);font-size:0.8125rem;">
                <input type="checkbox" id="pass-login-remember" checked style="accent-color:var(--tm-primary);cursor:pointer;">
                <span>Remember Me</span>
              </label>
              <a href="javascript:void(0)" onclick="window.TM.switchAuthTab('register')" style="font-size:0.75rem;color:var(--tm-accent-blue);font-weight:600;text-decoration:none;">New here? Create Account</a>
            </div>
          </div>
          <button type="submit" class="cart-checkout-btn" style="width:100%;height:46px;font-size:0.9375rem;font-weight:700;margin-top:0.5rem;">Sign In to Account</button>
        </form>

        <div style="margin-top:1.25rem;padding:0.75rem 1rem;background:#f8fafc;border:1px dashed var(--tm-border);border-radius:8px;display:flex;align-items:center;justify-content:space-between;">
          <span style="font-size:0.75rem;color:var(--tm-text-secondary);">Demo Test Account:</span>
          <button type="button" style="background:none;border:none;font-size:0.75rem;font-weight:700;color:var(--tm-accent-blue);cursor:pointer;text-decoration:underline;" onclick="document.getElementById('pass-login-email').value='doctor@hospital.com';document.getElementById('pass-login-pass').value='doctor123';">
            Autofill Demo Doctor
          </button>
        </div>
      </div>

      <!-- PANEL 2: CREATE NEW ACCOUNT -->
      <div id="auth-panel-register" style="display:none;">
        <div id="reg-step1">
          <div style="margin-bottom:0.85rem;">
            <label style="display:block;font-size:0.8125rem;font-weight:700;color:var(--tm-primary);margin-bottom:0.35rem;">Full Name (with Dr. prefix if applicable)</label>
            <input type="text" id="reg-name" class="newsletter-input" style="width:100%;border-radius:var(--radius-sm);" placeholder="Dr. Sarah Sharma" required>
          </div>
          <div style="margin-bottom:0.85rem;">
            <label style="display:block;font-size:0.8125rem;font-weight:700;color:var(--tm-primary);margin-bottom:0.35rem;">Hospital / Personal Email</label>
            <input type="email" id="reg-email" class="newsletter-input" style="width:100%;border-radius:var(--radius-sm);" placeholder="sarah.s@hospital.org" required>
          </div>
          <div style="margin-bottom:0.85rem;">
            <label style="display:block;font-size:0.8125rem;font-weight:700;color:var(--tm-primary);margin-bottom:0.35rem;">Mobile Number</label>
            <input type="tel" id="reg-phone" class="newsletter-input" style="width:100%;border-radius:var(--radius-sm);" placeholder="+91 98765 43210" required>
          </div>
          <div style="margin-bottom:0.85rem;">
            <label style="display:block;font-size:0.8125rem;font-weight:700;color:var(--tm-primary);margin-bottom:0.35rem;">Create Account Password</label>
            <div style="position:relative;">
              <input type="password" id="reg-password" class="newsletter-input" style="width:100%;padding-right:42px;border-radius:var(--radius-sm);" placeholder="Minimum 6 characters" oninput="window.TM.checkPasswordStrength(this.value); window.TM.checkPasswordMatch();" required>
              <button type="button" onclick="window.TM.togglePasswordVisibility('reg-password', this)" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--tm-text-muted);cursor:pointer;padding:6px;display:flex;align-items:center;" aria-label="Toggle password visibility">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
              </button>
            </div>
            <!-- Live Password Strength Meter -->
            <div style="margin-top:6px;">
              <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:3px;">
                <span style="font-size:0.75rem;color:var(--tm-text-muted);">Password Strength:</span>
                <span id="reg-strength-label" style="font-size:0.75rem;font-weight:700;color:var(--tm-text-muted);">None</span>
              </div>
              <div style="height:4px;width:100%;background:#e2e8f0;border-radius:2px;overflow:hidden;">
                <div id="reg-strength-bar" style="height:100%;width:0%;background:#ef4444;transition:all 0.3s ease;"></div>
              </div>
            </div>
          </div>
          <div style="margin-bottom:1rem;">
            <label style="display:block;font-size:0.8125rem;font-weight:700;color:var(--tm-primary);margin-bottom:0.35rem;">Confirm Password</label>
            <div style="position:relative;">
              <input type="password" id="reg-confirm-password" class="newsletter-input" style="width:100%;padding-right:42px;border-radius:var(--radius-sm);" placeholder="Re-enter password" oninput="window.TM.checkPasswordMatch();" required>
              <button type="button" onclick="window.TM.togglePasswordVisibility('reg-confirm-password', this)" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--tm-text-muted);cursor:pointer;padding:6px;display:flex;align-items:center;" aria-label="Toggle password visibility">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
              </button>
            </div>
            <!-- Match Indicator -->
            <div id="reg-match-msg" style="font-size:0.75rem;margin-top:5px;display:none;align-items:center;gap:4px;"></div>
          </div>

          <label style="display:flex;align-items:flex-start;gap:8px;font-size:0.75rem;color:var(--tm-text-secondary);margin-bottom:1.25rem;cursor:pointer;line-height:1.4;">
            <input type="checkbox" id="reg-terms-check" checked style="margin-top:2px;accent-color:var(--tm-primary);cursor:pointer;">
            <span>I verify that I am a healthcare professional or institutional clinical buyer and agree to TRADE MEDS Terms of Service.</span>
          </label>

          <button type="button" class="cart-checkout-btn" style="width:100%;" onclick="window.TM.requestRegisterOTP()">Verify Email &amp; Create Account</button>
        </div>

        <div id="reg-step2" style="display:none;">
          <div style="background:#f0fdf4;border:1px solid #bbf7d0;padding:0.75rem 1rem;border-radius:8px;margin-bottom:1rem;font-size:0.8125rem;color:#166534;">
            <span><svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:-2px;margin-right:3px;"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Verification OTP dispatched to: <strong id="reg-otp-dest-email"></strong></span>
          </div>
          <div style="margin-bottom:1.25rem;">
            <label style="display:block;font-size:0.8125rem;font-weight:700;color:var(--tm-primary);margin-bottom:0.4rem;">Enter 6-Digit Email Code</label>
            <input type="text" id="reg-otp-input" class="newsletter-input" style="width:100%;text-align:center;font-size:1.5rem;letter-spacing:6px;font-weight:800;border-radius:var(--radius-sm);" maxlength="6" placeholder="••••••">
          </div>
          <button type="button" class="cart-checkout-btn" style="width:100%;" onclick="window.TM.verifyRegisterOTP()">Verify &amp; Activate Account</button>
        </div>
      </div>

      <!-- PANEL 3: FORGOT PASSWORD -->
      <div id="auth-panel-forgot" style="display:none;">
        <!-- Step 1: Request Reset Code -->
        <div id="forgot-step1">
          <div style="background:#eff6ff;border:1px solid #bfdbfe;padding:0.85rem 1rem;border-radius:8px;margin-bottom:1.25rem;display:flex;align-items:flex-start;gap:10px;">
            <div style="color:var(--tm-accent-blue);flex-shrink:0;margin-top:2px;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            </div>
            <div style="font-size:0.8125rem;color:#1e40af;line-height:1.45;">
              Enter your registered healthcare or personal email. We will send a 6-digit reset code to restore your account.
            </div>
          </div>
          <div style="margin-bottom:1.25rem;">
            <label style="display:block;font-size:0.8125rem;font-weight:700;color:var(--tm-primary);margin-bottom:0.4rem;">Registered Email Address</label>
            <input type="email" id="forgot-email-input" class="newsletter-input" style="width:100%;border-radius:var(--radius-sm);" placeholder="doctor@hospital.com" required>
          </div>
          <button type="button" class="cart-checkout-btn" style="width:100%;" onclick="window.TM.requestForgotPasswordOTP()">Send 6-Digit Reset Code</button>
          <div style="text-align:center;margin-top:1rem;">
            <a href="javascript:void(0)" onclick="window.TM.switchAuthTab('login')" style="font-size:0.8125rem;color:var(--tm-accent-blue);font-weight:600;text-decoration:none;">← Back to Log In</a>
          </div>
        </div>

        <!-- Step 2: Enter Code & Set New Password -->
        <div id="forgot-step2" style="display:none;">
          <div style="background:#f0fdf4;border:1px solid #bbf7d0;padding:0.75rem 1rem;border-radius:8px;margin-bottom:1rem;font-size:0.8125rem;color:#166534;">
            <span><svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:-2px;margin-right:3px;"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Reset code sent to: <strong id="forgot-dest-email"></strong></span>
            <a href="javascript:void(0)" onclick="window.TM.resetForgotPasswordStep()" style="color:var(--tm-accent-blue);margin-left:8px;font-size:0.75rem;font-weight:700;">Edit</a>
          </div>
          <div style="margin-bottom:1rem;">
            <label style="display:block;font-size:0.8125rem;font-weight:700;color:var(--tm-primary);margin-bottom:0.4rem;">Enter 6-Digit Reset Code</label>
            <input type="text" id="forgot-otp-input" class="newsletter-input" style="width:100%;text-align:center;font-size:1.5rem;letter-spacing:6px;font-weight:800;border-radius:var(--radius-sm);" maxlength="6" placeholder="••••••">
          </div>
          <div style="margin-bottom:0.85rem;">
            <label style="display:block;font-size:0.8125rem;font-weight:700;color:var(--tm-primary);margin-bottom:0.35rem;">New Password</label>
            <div style="position:relative;">
              <input type="password" id="forgot-new-password" class="newsletter-input" style="width:100%;padding-right:42px;border-radius:var(--radius-sm);" placeholder="Minimum 6 characters" oninput="window.TM.checkForgotMatch();" required>
              <button type="button" onclick="window.TM.togglePasswordVisibility('forgot-new-password', this)" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--tm-text-muted);cursor:pointer;padding:6px;display:flex;align-items:center;" aria-label="Toggle password visibility">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
              </button>
            </div>
          </div>
          <div style="margin-bottom:1.25rem;">
            <label style="display:block;font-size:0.8125rem;font-weight:700;color:var(--tm-primary);margin-bottom:0.35rem;">Confirm New Password</label>
            <div style="position:relative;">
              <input type="password" id="forgot-confirm-password" class="newsletter-input" style="width:100%;padding-right:42px;border-radius:var(--radius-sm);" placeholder="Re-enter new password" oninput="window.TM.checkForgotMatch();" required>
              <button type="button" onclick="window.TM.togglePasswordVisibility('forgot-confirm-password', this)" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--tm-text-muted);cursor:pointer;padding:6px;display:flex;align-items:center;" aria-label="Toggle password visibility">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
              </button>
            </div>
            <div id="forgot-match-msg" style="font-size:0.75rem;margin-top:5px;display:none;align-items:center;gap:4px;"></div>
          </div>
          <button type="button" class="cart-checkout-btn" style="width:100%;" onclick="window.TM.verifyResetPassword()">Reset Password &amp; Log In</button>
          <div style="display:flex;justify-content:space-between;align-items:center;margin-top:0.85rem;font-size:0.8125rem;">
            <span id="forgot-timer-text" style="color:var(--tm-text-muted);">Resend code in <strong id="forgot-timer-count">60</strong>s</span>
            <button type="button" id="forgot-resend-btn" style="display:none;background:none;border:none;color:var(--tm-accent-blue);font-weight:700;cursor:pointer;" onclick="window.TM.requestForgotPasswordOTP(true)">Resend Code</button>
          </div>
          <div style="text-align:center;margin-top:1rem;">
            <a href="javascript:void(0)" onclick="window.TM.switchAuthTab('login')" style="font-size:0.8125rem;color:var(--tm-accent-blue);font-weight:600;text-decoration:none;">Cancel &amp; Return to Log In</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ==========================================
       CUSTOMER ACCOUNT DASHBOARD MODAL
       ========================================== -->
  <div id="account-dashboard-modal" class="modal-overlay">
    <div class="modal-box" style="max-width:720px;padding:2rem;border-radius:var(--radius-lg);">
      <button type="button" class="modal-close-btn" onclick="window.TM.closeModal('account-dashboard-modal')"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>

      <div style="display:flex;align-items:center;justify-content:space-between;padding-bottom:1.25rem;border-bottom:1px solid var(--tm-border-light);margin-bottom:1.5rem;">
        <div style="display:flex;align-items:center;gap:1rem;">
          <div style="width:48px;height:48px;border-radius:50%;background:var(--tm-primary);color:#fff;display:flex;align-items:center;justify-content:center;font-size:1.25rem;font-weight:800;" id="cust-avatar">DR</div>
          <div>
            <h3 style="font-size:1.2rem;font-weight:800;color:var(--tm-primary);margin:0;" id="cust-name-display">Dr. Medico</h3>
            <span style="font-size:0.8125rem;color:var(--tm-green);font-weight:600;"><svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:-2px;margin-right:3px;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>Verified Healthcare Professional</span>
          </div>
        </div>
        <button type="button" class="btn-secondary" style="font-size:0.8125rem;padding:6px 14px;color:#ef4444;display:inline-flex;align-items:center;" onclick="window.TM.logoutUser()"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:-2px;margin-right:4px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Sign Out</button>
      </div>

      <!-- Account Sub-Tabs -->
      <div style="display:flex;gap:0.75rem;margin-bottom:1.25rem;border-bottom:1px solid var(--tm-border-light);padding-bottom:0.75rem;">
        <button type="button" class="cust-tab-pill active" id="cust-tab-btn-orders" onclick="window.TM.switchCustomerTab('orders')">My Orders & Tracking</button>
        <button type="button" class="cust-tab-pill" id="cust-tab-btn-profile" onclick="window.TM.switchCustomerTab('profile')">Profile Details</button>
      </div>

      <!-- Tab: My Orders -->
      <div id="cust-tab-orders">
        <div id="cust-orders-list" style="max-height:50vh;overflow-y:auto;">
          <!-- Dynamically loaded from api/orders.php?my_orders=1 -->
        </div>
      </div>

      <!-- Tab: Profile Details -->
      <div id="cust-tab-profile" style="display:none;">
        <form id="cust-profile-form" onsubmit="window.TM.handleProfileUpdate(event)">
          <div style="margin-bottom:1rem;">
            <label style="display:block;font-size:0.8125rem;font-weight:700;color:var(--tm-primary);margin-bottom:0.35rem;">Full Name</label>
            <input type="text" id="cust-edit-name" class="newsletter-input" style="width:100%;border-radius:var(--radius-sm);" required>
          </div>
          <div style="margin-bottom:1rem;">
            <label style="display:block;font-size:0.8125rem;font-weight:700;color:var(--tm-primary);margin-bottom:0.35rem;">Email Address</label>
            <input type="email" id="cust-edit-email" class="newsletter-input" style="width:100%;border-radius:var(--radius-sm);background:#f1f5f9;" readonly>
          </div>
          <div style="margin-bottom:1.25rem;">
            <label style="display:block;font-size:0.8125rem;font-weight:700;color:var(--tm-primary);margin-bottom:0.35rem;">Mobile Number</label>
            <input type="tel" id="cust-edit-phone" class="newsletter-input" style="width:100%;border-radius:var(--radius-sm);">
          </div>
          <button type="submit" class="cart-checkout-btn" style="width:100%;">Save Profile Changes</button>
        </form>
      </div>
    </div>
  </div>

  <!-- ==========================================
       CHECKOUT MODAL (ADDRESS & PAYMENT GATEWAY)
       ========================================== -->
  <div id="checkout-modal" class="modal-overlay">
    <div class="checkout-modal-box">
      <button type="button" class="modal-close-btn" onclick="window.TM.closeModal('checkout-modal')"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>

      <div style="display:flex;align-items:center;justify-content:space-between;padding-bottom:1rem;border-bottom:1.5px solid var(--tm-border-light);">
        <div style="display:flex;align-items:center;gap:10px;">
          <img src="images/trade-meds-logo/trade-meds.png" style="height:34px;" alt="TRADE MEDS">
          <div>
            <h3 style="font-size:1.25rem;font-weight:800;color:var(--tm-primary);margin:0;">Clinical Order Checkout</h3>
            <span style="font-size:0.75rem;color:var(--tm-green);font-weight:600;display:inline-flex;align-items:center;gap:4px;">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
              256-Bit SSL Encrypted &amp; HIPAA-Safe
            </span>
          </div>
        </div>
      </div>

      <form id="checkout-form" onsubmit="window.TM.submitOrder(event)">
        <div class="checkout-grid">
          <!-- Left Column: Shipping & Payment Details -->
          <div>
            <!-- Section 1: Doctor / Contact Info -->
            <div class="checkout-section-title">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
              <span>1. Contact &amp; Doctor Details</span>
            </div>

            <div class="checkout-row">
              <div class="checkout-form-group">
                <label class="checkout-label">Full Name / Doctor Title *</label>
                <input type="text" id="chk-name" class="checkout-input" placeholder="e.g. Dr. Riya Sen" required>
              </div>
              <div class="checkout-form-group">
                <label class="checkout-label">Mobile Phone Number *</label>
                <input type="tel" id="chk-phone" class="checkout-input" placeholder="+91 98401 23456" pattern="[\+0-9\s-]{10,15}" required>
              </div>
            </div>

            <div class="checkout-form-group">
              <label class="checkout-label">Email Address (for Invoice &amp; Dispatch SLA) *</label>
              <input type="email" id="chk-email" class="checkout-input" placeholder="doctor@hospital.in" required>
            </div>

            <!-- Section 2: Delivery Address -->
            <div class="checkout-section-title" style="margin-top:1.5rem;">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
              <span>2. Clinical Delivery Address</span>
            </div>

            <div class="checkout-row">
              <div class="checkout-form-group">
                <label class="checkout-label">Hospital / Clinic / Institute *</label>
                <input type="text" id="chk-hospital" class="checkout-input" placeholder="e.g. Apollo Hospital / AIIMS Quarters" required>
              </div>
              <div class="checkout-form-group">
                <label class="checkout-label">Flat / Room / Department No. *</label>
                <input type="text" id="chk-flat" class="checkout-input" placeholder="e.g. Room 402, Dept of Surgery" required>
              </div>
            </div>

            <div class="checkout-form-group">
              <label class="checkout-label">Street / Area / Landmark *</label>
              <input type="text" id="chk-street" class="checkout-input" placeholder="e.g. Greams Road, Thousand Lights" required>
            </div>

            <div class="checkout-row">
              <div class="checkout-form-group">
                <label class="checkout-label">City *</label>
                <input type="text" id="chk-city" class="checkout-input" placeholder="Chennai" required>
              </div>
              <div class="checkout-form-group">
                <label class="checkout-label">PIN Code *</label>
                <input type="text" id="chk-pincode" class="checkout-input" placeholder="600006" pattern="[0-9]{6}" maxlength="6" required>
              </div>
            </div>

            <div class="checkout-form-group">
              <label class="checkout-label">State / Union Territory *</label>
              <select id="chk-state" class="checkout-input" required>
                <option value="Tamil Nadu">Tamil Nadu</option>
                <option value="Maharashtra">Maharashtra</option>
                <option value="Delhi">Delhi NCR</option>
                <option value="Karnataka">Karnataka</option>
                <option value="Telangana">Telangana</option>
                <option value="Kerala">Kerala</option>
                <option value="Gujarat">Gujarat</option>
                <option value="West Bengal">West Bengal</option>
                <option value="Uttar Pradesh">Uttar Pradesh</option>
                <option value="Other State">Other State</option>
              </select>
            </div>

            <!-- Section 3: Payment Method Selection -->
            <div class="checkout-section-title" style="margin-top:1.5rem;">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
              <span>3. Payment Method</span>
            </div>

            <div class="payment-options-grid">
              <label class="payment-card-label">
                <input type="radio" name="chk_payment" value="COD" checked onchange="window.TM.updatePaymentSelection(this)">
                <div>
                  <strong style="display:block;font-size:0.875rem;color:var(--tm-primary);">Cash on Delivery</strong>
                  <span style="font-size:0.75rem;color:var(--tm-text-secondary);">Pay when package arrives</span>
                </div>
              </label>

              <label class="payment-card-label">
                <input type="radio" name="chk_payment" value="UPI" onchange="window.TM.updatePaymentSelection(this)">
                <div>
                  <strong style="display:block;font-size:0.875rem;color:var(--tm-primary);">Instant UPI / QR</strong>
                  <span style="font-size:0.75rem;color:var(--tm-text-secondary);">GPay, PhonePe, Paytm</span>
                </div>
              </label>

              <label class="payment-card-label">
                <input type="radio" name="chk_payment" value="Card" onchange="window.TM.updatePaymentSelection(this)">
                <div>
                  <strong style="display:block;font-size:0.875rem;color:var(--tm-primary);">Credit / Debit Card</strong>
                  <span style="font-size:0.75rem;color:var(--tm-text-secondary);">Visa, MasterCard, RuPay</span>
                </div>
              </label>

              <label class="payment-card-label">
                <input type="radio" name="chk_payment" value="NetBanking" onchange="window.TM.updatePaymentSelection(this)">
                <div>
                  <strong style="display:block;font-size:0.875rem;color:var(--tm-primary);">Net Banking</strong>
                  <span style="font-size:0.75rem;color:var(--tm-text-secondary);">All Indian Scheduled Banks</span>
                </div>
              </label>
            </div>
          </div>

          <!-- Right Column: Order Summary Review -->
          <div>
            <div class="checkout-summary-box">
              <h4 style="font-size:1.05rem;font-weight:800;color:var(--tm-primary);margin-bottom:1rem;display:flex;justify-content:space-between;align-items:center;">
                <span>Order Summary</span>
                <span id="chk-item-count" style="font-size:0.8125rem;font-weight:600;color:var(--tm-text-secondary);">(0 items)</span>
              </h4>

              <!-- Items List -->
              <div class="checkout-items-list" id="chk-items-list">
                <!-- Dynamically rendered from state.cart.items -->
              </div>

              <!-- Promo Code in Checkout -->
              <div style="display:flex;gap:0.5rem;margin-bottom:1.25rem;">
                <input type="text" id="chk-coupon-input" class="checkout-input" placeholder="Promo code (e.g. DOCTOR10)" style="height:38px;font-size:0.8125rem;text-transform:uppercase;">
                <button type="button" class="btn-secondary" style="height:38px;padding:0 14px;font-size:0.8125rem;font-weight:700;" onclick="window.TM.applyCheckoutCoupon()">Apply</button>
              </div>

              <!-- Price Breakdown -->
              <div style="display:flex;flex-direction:column;gap:0.6rem;font-size:0.875rem;padding:0.75rem 0;border-top:1px solid var(--tm-border-light);border-bottom:1px solid var(--tm-border-light);">
                <div style="display:flex;justify-content:space-between;color:var(--tm-text-secondary);">
                  <span>Items Subtotal</span>
                  <span id="chk-subtotal" style="font-weight:600;color:var(--tm-primary);">₹0</span>
                </div>
                <div id="chk-discount-row" style="display:none;justify-content:space-between;color:var(--tm-green);">
                  <span id="chk-discount-label">Promo Discount</span>
                  <span id="chk-discount" style="font-weight:700;">-₹0</span>
                </div>
                <div style="display:flex;justify-content:space-between;color:var(--tm-text-secondary);">
                  <span>Expedited Delivery</span>
                  <span id="chk-shipping" style="font-weight:600;">Calculated</span>
                </div>
              </div>

              <div style="display:flex;justify-content:space-between;align-items:center;padding:1rem 0;font-size:1.15rem;font-weight:800;color:var(--tm-primary);">
                <span>Total Payable:</span>
                <span id="chk-total" style="color:var(--tm-primary);">₹0</span>
              </div>

              <button type="submit" class="cart-checkout-btn" style="width:100%;height:48px;" id="chk-submit-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                <span>Confirm &amp; Place Order</span>
              </button>

              <div style="margin-top:1rem;text-align:center;font-size:0.71875rem;color:var(--tm-text-secondary);line-height:1.4;">
                By placing your order, you agree to TRADE MEDS standard clinical terms and 7-day doorstep size exchange policy.
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- ==========================================
       ORDER SUCCESS CONFIRMATION MODAL
       ========================================== -->
  <div id="order-success-modal" class="modal-overlay">
    <div class="order-success-modal-box">
      <button type="button" class="modal-close-btn" onclick="window.TM.closeModal('order-success-modal')"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>

      <div class="success-check-icon">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
      </div>

      <h3 style="font-size:1.5rem;font-weight:800;color:var(--tm-primary);margin-bottom:0.35rem;">Order Placed Successfully!</h3>
      <p style="font-size:0.875rem;color:var(--tm-text-secondary);margin-bottom:1.5rem;">Thank you for your order with TRADE MEDS. Your medical apparel is being tailored &amp; prepped for dispatch.</p>

      <div style="background:#f8fafc;border:1.5px solid var(--tm-border-light);border-radius:12px;padding:1.25rem;text-align:left;margin-bottom:1.5rem;font-size:0.875rem;">
        <div style="display:flex;justify-content:space-between;padding-bottom:0.75rem;border-bottom:1px solid var(--tm-border-light);margin-bottom:0.75rem;">
          <span style="color:var(--tm-text-secondary);">Order Reference:</span>
          <strong id="success-order-num" style="color:var(--tm-primary);letter-spacing:0.02em;">TM-2026-XXXX</strong>
        </div>
        <div style="display:flex;justify-content:space-between;margin-bottom:0.5rem;">
          <span style="color:var(--tm-text-secondary);">Customer:</span>
          <strong id="success-customer-name">Dr. Medico</strong>
        </div>
        <div style="display:flex;justify-content:space-between;margin-bottom:0.5rem;">
          <span style="color:var(--tm-text-secondary);">Payment Mode:</span>
          <span id="success-payment-mode" style="font-weight:700;">Cash on Delivery</span>
        </div>
        <div style="display:flex;justify-content:space-between;margin-bottom:0.5rem;">
          <span style="color:var(--tm-text-secondary);">Delivery Address:</span>
          <span id="success-address" style="text-align:right;max-width:260px;font-weight:600;">—</span>
        </div>
        <div style="display:flex;justify-content:space-between;padding-top:0.75rem;border-top:1px solid var(--tm-border-light);font-size:1rem;font-weight:800;">
          <span>Total Amount:</span>
          <span id="success-total" style="color:#059669;">₹0</span>
        </div>
      </div>

      <div style="display:flex;gap:0.75rem;">
        <button type="button" class="btn-secondary" style="flex:1;height:44px;" onclick="window.TM.trackSuccessOrder()">Track Order</button>
        <button type="button" class="cart-checkout-btn" style="flex:1;height:44px;" onclick="window.TM.closeModal('order-success-modal')">Continue Shopping</button>
      </div>
    </div>
  </div>

  <!-- MOBILE NAVIGATION DRAWER -->
  <aside id="mobile-drawer" class="mobile-drawer" aria-label="Mobile Navigation Menu">
    <div class="mobile-drawer-header">
      <img src="images/trade-meds-logo/trade-meds.png" style="height:32px;" alt="TRADE MEDS">
      <button type="button" class="drawer-close-btn" onclick="window.TM.closeMobileMenu()"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
    </div>

    <!-- Mobile Search -->
    <div style="padding:0.75rem 1.25rem;background:var(--tm-bg-gray);">
      <div class="search-input-wrapper" style="height:38px;padding-left:2.25rem;">
        <svg class="search-icon" style="left:0.75rem;width:16px;height:16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <input type="text" id="mobile-search-input" class="search-input" placeholder="Search scrubs, coats..." style="font-size:0.875rem;">
      </div>
    </div>

    <!-- Mobile Tabs: Women, Men, All -->
    <div class="mobile-tabs">
      <button type="button" class="mobile-tab-btn active" onclick="this.parentElement.querySelectorAll('button').forEach(b=>b.classList.remove('active'));this.classList.add('active');">Women</button>
      <button type="button" class="mobile-tab-btn" onclick="this.parentElement.querySelectorAll('button').forEach(b=>b.classList.remove('active'));this.classList.add('active');">Men</button>
      <button type="button" class="mobile-tab-btn" onclick="this.parentElement.querySelectorAll('button').forEach(b=>b.classList.remove('active'));this.classList.add('active');">Equipment</button>
    </div>

    <!-- Mobile Category Links -->
    <div class="mobile-menu-body">
      <div class="mobile-category-item">
        <a href="#classic-scrubs-section" class="mobile-category-link" onclick="window.TM.closeMobileMenu()">
          <span>Classic Scrubs</span>
          <span>›</span>
        </a>
      </div>
      <div class="mobile-category-item">
        <a href="#ecoflex-section" class="mobile-category-link" onclick="window.TM.closeMobileMenu()">
          <span>ecoflex™ 4-Way Stretch</span>
          <span>›</span>
        </a>
      </div>
      <div class="mobile-category-item">
        <a href="javascript:void(0)" class="mobile-category-link" onclick="window.TM.closeMobileMenu();window.TM.openQuickView(11)">
          <span>Lab Coats &amp; Aprons</span>
          <span>›</span>
        </a>
      </div>
      <div class="mobile-category-item">
        <a href="#stethoscope-section" class="mobile-category-link" onclick="window.TM.closeMobileMenu()">
          <span>6sense Stethoscopes</span>
          <span>›</span>
        </a>
      </div>
      <div class="mobile-category-item">
        <a href="javascript:void(0)" class="mobile-category-link" onclick="window.TM.closeMobileMenu();window.TM.openQuickView(16)">
          <span>Medical Footwear Clogs</span>
          <span>›</span>
        </a>
      </div>
      <div class="mobile-category-item">
        <a href="#bulk-banner" class="mobile-category-link" onclick="window.TM.closeMobileMenu()">
          <span>Hospital Bulk Order</span>
          <span>›</span>
        </a>
      </div>
      <div class="mobile-category-item">
        <a href="#join-club" class="mobile-category-link" onclick="window.TM.closeMobileMenu()">
          <span>TRADE MEDS Club Rewards</span>
          <span>›</span>
        </a>
      </div>

      <!-- Account in Mobile -->
      <div style="margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--tm-border);">
        <button type="button" class="cart-checkout-btn" style="height:42px;font-size:0.9375rem;" onclick="window.TM.closeMobileMenu();window.TM.openModal('auth-modal');">
          Log In / Sign Up
        </button>
        <p style="text-align:center;font-size:0.75rem;color:var(--tm-text-secondary);margin-top:0.75rem;">
          Need help? Call +91 (044) 4800-MEDS
        </p>
      </div>
    </div>
  </aside>

  <!-- ==========================================
       SIZE & MEASUREMENT FIT GUIDE MODAL
       ========================================== -->
  <div id="size-guide-modal" class="modal-overlay">
    <div class="modal-box" style="max-width:760px;padding:2rem;border-radius:var(--radius-lg);">
      <button type="button" class="modal-close-btn" onclick="window.TM.closeModal('size-guide-modal')"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>

      <div style="display:flex;align-items:center;gap:12px;margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:1.5px solid var(--tm-border-light);">
        <div style="width:40px;height:40px;border-radius:10px;background:#f0f9ff;color:#0284c7;display:flex;align-items:center;justify-content:center;">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.3 8.7l-6-6a1 1 0 0 0-1.4 0l-11 11a1 1 0 0 0 0 1.4l6 6a1 1 0 0 0 1.4 0l11-11a1 1 0 0 0 0-1.4z"></path><path d="M7.5 10.5l2 2"></path><path d="M10.5 7.5l2 2"></path><path d="M13.5 4.5l2 2"></path></svg>
        </div>
        <div>
          <h3 style="font-size:1.35rem;font-weight:800;color:var(--tm-primary);margin:0;">Clinical Size &amp; Measurement Guide</h3>
          <p style="font-size:0.8125rem;color:var(--tm-text-secondary);margin:2px 0 0 0;">Engineered for 12-hour hospital mobility. All sizes in standard Indian doctor proportions.</p>
        </div>
      </div>

      <!-- Unit Selector Tabs -->
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
        <span style="font-size:0.8125rem;font-weight:700;color:var(--tm-primary);">Body &amp; Garment Measurements</span>
        <div style="display:inline-flex;border:1px solid var(--tm-border);border-radius:8px;overflow:hidden;">
          <button type="button" id="size-unit-in" class="cust-tab-pill active" style="border:none;border-radius:0;padding:4px 12px;font-size:0.75rem;" onclick="window.TM.switchSizeUnit('in')">Inches (in)</button>
          <button type="button" id="size-unit-cm" class="cust-tab-pill" style="border:none;border-radius:0;padding:4px 12px;font-size:0.75rem;" onclick="window.TM.switchSizeUnit('cm')">Centimeters (cm)</button>
        </div>
      </div>

      <!-- Sizing Table -->
      <div style="overflow-x:auto;margin-bottom:1.5rem;">
        <table style="width:100%;border-collapse:collapse;font-size:0.875rem;text-align:center;">
          <thead>
            <tr style="background:#f8fafc;border-bottom:2px solid var(--tm-border-light);color:var(--tm-primary);">
              <th style="padding:10px 14px;text-align:left;font-weight:800;">Size</th>
              <th style="padding:10px 14px;font-weight:800;">Chest / Bust</th>
              <th style="padding:10px 14px;font-weight:800;">Waist</th>
              <th style="padding:10px 14px;font-weight:800;">Hip</th>
              <th style="padding:10px 14px;font-weight:800;">Top Length</th>
              <th style="padding:10px 14px;font-weight:800;">Pant Inseam</th>
            </tr>
          </thead>
          <tbody id="size-chart-tbody">
            <!-- Populated dynamically via JS -->
            <tr style="border-bottom:1px solid var(--tm-border-light);">
              <td style="padding:10px 14px;text-align:left;font-weight:800;color:var(--tm-primary);">XS</td>
              <td style="padding:10px 14px;">32 - 34"</td>
              <td style="padding:10px 14px;">26 - 28"</td>
              <td style="padding:10px 14px;">34 - 36"</td>
              <td style="padding:10px 14px;">26"</td>
              <td style="padding:10px 14px;">29"</td>
            </tr>
            <tr style="border-bottom:1px solid var(--tm-border-light);background:#fcfcfd;">
              <td style="padding:10px 14px;text-align:left;font-weight:800;color:var(--tm-primary);">S</td>
              <td style="padding:10px 14px;">35 - 37"</td>
              <td style="padding:10px 14px;">29 - 31"</td>
              <td style="padding:10px 14px;">37 - 39"</td>
              <td style="padding:10px 14px;">27"</td>
              <td style="padding:10px 14px;">29.5"</td>
            </tr>
            <tr style="border-bottom:1px solid var(--tm-border-light);">
              <td style="padding:10px 14px;text-align:left;font-weight:800;color:var(--tm-primary);">M</td>
              <td style="padding:10px 14px;">38 - 40"</td>
              <td style="padding:10px 14px;">32 - 34"</td>
              <td style="padding:10px 14px;">40 - 42"</td>
              <td style="padding:10px 14px;">28"</td>
              <td style="padding:10px 14px;">30"</td>
            </tr>
            <tr style="border-bottom:1px solid var(--tm-border-light);background:#fcfcfd;">
              <td style="padding:10px 14px;text-align:left;font-weight:800;color:var(--tm-primary);">L</td>
              <td style="padding:10px 14px;">41 - 43"</td>
              <td style="padding:10px 14px;">35 - 37"</td>
              <td style="padding:10px 14px;">43 - 45"</td>
              <td style="padding:10px 14px;">29"</td>
              <td style="padding:10px 14px;">30.5"</td>
            </tr>
            <tr style="border-bottom:1px solid var(--tm-border-light);">
              <td style="padding:10px 14px;text-align:left;font-weight:800;color:var(--tm-primary);">XL</td>
              <td style="padding:10px 14px;">44 - 46"</td>
              <td style="padding:10px 14px;">38 - 40"</td>
              <td style="padding:10px 14px;">46 - 48"</td>
              <td style="padding:10px 14px;">30"</td>
              <td style="padding:10px 14px;">31"</td>
            </tr>
            <tr style="border-bottom:1px solid var(--tm-border-light);background:#fcfcfd;">
              <td style="padding:10px 14px;text-align:left;font-weight:800;color:var(--tm-primary);">2XL</td>
              <td style="padding:10px 14px;">47 - 50"</td>
              <td style="padding:10px 14px;">41 - 44"</td>
              <td style="padding:10px 14px;">49 - 52"</td>
              <td style="padding:10px 14px;">31"</td>
              <td style="padding:10px 14px;">31.5"</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Fit Note -->
      <div style="background:#f0fdf4;border:1px solid #bbf7d0;padding:0.85rem 1.25rem;border-radius:10px;font-size:0.8125rem;color:#166534;line-height:1.5;">
        <strong>Hassle-Free Exchange:</strong> If the fit isn't 100% perfect, enjoy our free 7-Day doorstep size exchange across India. WhatsApp us or exchange in 1 click from your account dashboard.
      </div>
    </div>
  </div>