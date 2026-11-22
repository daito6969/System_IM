<?php
require_once __DIR__ . '/includes/auth.php';
$loginError = isset($_GET['error']) ? 'Invalid email or password. Please try again.' : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>Sign In – Wayfarer PH</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-body">

<div class="auth-ambient-bg"></div>

<div class="auth-wrapper">
  <div class="auth-panel">
    <!-- Brand / Header -->
    <div class="auth-brand-area">
      <a href="index.php" class="auth-brand-logo">
        <span class="auth-logo-badge">PH</span>
        <span class="auth-logo-text">WAYFARER</span>
      </a>
      <h1>Welcome Back</h1>
      <p>Sign in to access your Philippine trips, flight bookings & budget planner.</p>
    </div>

    <?php if ($loginError): ?>
    <div class="auth-alert" id="auth-alert" role="alert">
      <span class="alert-icon">⚠️</span>
      <span id="auth-alert-text"><?= e($loginError) ?></span>
    </div>
    <?php endif; ?>

    <form method="post" action="actions/login_process.php" class="auth-form-aesthetic">
      <div class="input-group">
        <label for="email">
          <span>Email Address</span>
        </label>
        <div class="input-inner">
          <span class="input-icon">✉️</span>
          <input type="email" id="email" name="email" placeholder="name@example.com" required autofocus>
        </div>
      </div>

      <div class="input-group">
        <label for="password">
          <span>Password</span>
        </label>
        <div class="input-inner">
          <span class="input-icon">🔒</span>
          <input type="password" id="password" name="password" placeholder="••••••••" required>
        </div>
      </div>

      <button type="submit" class="auth-btn-primary">
        <span>Sign In to Wayfarer</span>
        <span class="arrow">➔</span>
      </button>

      <div class="auth-footer-nav">
        <span>Don't have an account?</span>
        <a href="<?= BASE ?>/register.php" class="auth-link">Create Account</a>
      </div>
    </form>

    <!-- Quick Demo Box -->
    <div class="auth-demo-card">
      <div class="demo-card-title">🔑 Quick Demo Sign In:</div>
      <div class="demo-card-body">
        <div><b>Admin:</b> <code>admin@roadtrip.local</code> / <code>admin123</code></div>
        <button type="button" class="demo-fill-btn" onclick="fillAdmin()">1-Click Fill Admin</button>
      </div>
    </div>
  </div>
</div>

<script>
function fillAdmin() {
  document.getElementById('email').value = 'admin@roadtrip.local';
  document.getElementById('password').value = 'admin123';
}

</script>

</body>
</html>
