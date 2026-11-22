<?php
require_once __DIR__ . '/includes/auth.php';

if (user()) {
  header('Location: ' . home_for(user()['role']));
  exit;
}

$loginError = isset($_GET['error']) ? 'Invalid email or password. Please try again.' : '';
$loginNotice = isset($_GET['logged_out']) ? 'You have been signed out securely.' : '';
$email = trim((string) ($_GET['email'] ?? ''));
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
    <?php elseif ($loginNotice): ?>
    <div class="auth-alert auth-alert-success" role="status">
      <span class="alert-icon">✓</span>
      <span><?= e($loginNotice) ?></span>
    </div>
    <?php endif; ?>

    <form method="post" action="<?= BASE ?>/actions/login_process.php" class="auth-form-aesthetic" novalidate>
      <div class="input-group">
        <label for="email">
          <span>Email Address</span>
        </label>
        <div class="input-inner">
          <span class="input-icon">✉️</span>
          <input type="email" id="email" name="email" value="<?= e($email) ?>" placeholder="name@example.com" autocomplete="username" required autofocus>
        </div>
      </div>

      <div class="input-group">
        <label for="password">
          <span>Password</span>
        </label>
        <div class="input-inner">
          <span class="input-icon">🔒</span>
          <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
          <button type="button" class="password-toggle" data-target="password" aria-label="Show password" aria-pressed="false">Show</button>
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
  </div>
</div>

<script>
document.querySelectorAll('.password-toggle').forEach(function(button) {
  button.addEventListener('click', function() {
    var input = document.getElementById(button.dataset.target);
    var show = input.type === 'password';
    input.type = show ? 'text' : 'password';
    button.textContent = show ? 'Hide' : 'Show';
    button.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
    button.setAttribute('aria-pressed', show ? 'true' : 'false');
  });
});

document.querySelector('.auth-form-aesthetic').addEventListener('submit', function() {
  var submit = this.querySelector('.auth-btn-primary');
  submit.disabled = true;
  submit.querySelector('span:first-child').textContent = 'Signing in…';
});
</script>

</body>
</html>
