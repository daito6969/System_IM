<?php
require_once __DIR__ . '/includes/auth.php';

if (user()) {
  header('Location: ' . home_for(user()['role']));
  exit;
}

$registerError = isset($_GET['error']) ? trim((string) $_GET['error']) : '';
$old = $_SESSION['register_old'] ?? [];
unset($_SESSION['register_old']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>Create Traveler Account – Wayfarer PH</title>
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
      <h1>Start Your Adventure</h1>
      <p>Create your traveler account to plan custom Philippine itineraries, track budgets & book flights.</p>
    </div>

    <?php if ($registerError): ?>
    <div class="auth-alert" id="auth-alert" role="alert">
      <span class="alert-icon">⚠️</span>
      <span id="auth-alert-text"><?= e($registerError) ?></span>
    </div>
    <?php endif; ?>

    <form method="post" action="<?= BASE ?>/actions/register_process.php" class="auth-form-aesthetic" novalidate>
      <!-- Name Fields: First Name + MI -->
      <div class="form-row-2-1">
        <div class="input-group">
          <label for="first_name">
            <span>First Name <span class="req">*</span></span>
          </label>
          <div class="input-inner">
            <span class="input-icon">👤</span>
            <input type="text" id="first_name" name="first_name" value="<?= e($old['first_name'] ?? '') ?>" placeholder="e.g. Juan" autocomplete="given-name" maxlength="50" required autofocus>
          </div>
        </div>

        <div class="input-group">
          <label for="middle_initial">
            <span>M.I.</span>
          </label>
          <div class="input-inner">
            <input type="text" id="middle_initial" name="middle_initial" value="<?= e($old['middle_initial'] ?? '') ?>" placeholder="D." maxlength="4" autocomplete="additional-name" style="text-align:center;">
          </div>
        </div>
      </div>

      <!-- Name Fields: Last Name + Suffix -->
      <div class="form-row-2-1">
        <div class="input-group">
          <label for="last_name">
            <span>Last Name <span class="req">*</span></span>
          </label>
          <div class="input-inner">
            <input type="text" id="last_name" name="last_name" value="<?= e($old['last_name'] ?? '') ?>" placeholder="e.g. Dela Cruz" autocomplete="family-name" maxlength="50" required>
          </div>
        </div>

        <div class="input-group">
          <label for="suffix">
            <span>Suffix <span class="opt">(Optional)</span></span>
          </label>
          <div class="input-inner">
            <input type="text" id="suffix" name="suffix" value="<?= e($old['suffix'] ?? '') ?>" placeholder="Jr., III" maxlength="10">
          </div>
        </div>
      </div>

      <!-- Email Address -->
      <div class="input-group">
        <label for="email">
          <span>Email Address <span class="req">*</span></span>
        </label>
        <div class="input-inner">
          <span class="input-icon">✉️</span>
          <input type="email" id="email" name="email" value="<?= e($old['email'] ?? '') ?>" placeholder="name@example.com" autocomplete="username" maxlength="191" required>
        </div>
      </div>

      <!-- Password -->
      <div class="input-group">
        <label for="password">
          <span>Password <span class="req">*</span> <small>(at least 8 characters)</small></span>
        </label>
        <div class="input-inner">
          <span class="input-icon">🔒</span>
          <input type="password" id="password" name="password" minlength="8" placeholder="Create a strong password" autocomplete="new-password" required>
          <button type="button" class="password-toggle" data-target="password" aria-label="Show password" aria-pressed="false">Show</button>
        </div>
      </div>

      <div class="input-group">
        <label for="confirm_password">
          <span>Confirm Password <span class="req">*</span></span>
        </label>
        <div class="input-inner">
          <span class="input-icon">🔒</span>
          <input type="password" id="confirm_password" name="confirm_password" minlength="8" placeholder="Repeat your password" autocomplete="new-password" required>
          <button type="button" class="password-toggle" data-target="confirm_password" aria-label="Show password" aria-pressed="false">Show</button>
        </div>
      </div>

      <button type="submit" class="auth-btn-primary">
        <span>Create Account & Start Planning</span>
        <span class="arrow">➔</span>
      </button>

      <div class="auth-footer-nav">
        <span>Already have an account?</span>
        <a href="<?= BASE ?>/login.php" class="auth-link">Sign In</a>
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

var form = document.querySelector('.auth-form-aesthetic');
form.addEventListener('submit', function(event) {
  var password = document.getElementById('password');
  var confirmation = document.getElementById('confirm_password');
  if (password.value !== confirmation.value) {
    event.preventDefault();
    confirmation.setCustomValidity('Passwords do not match.');
    confirmation.reportValidity();
  } else {
    confirmation.setCustomValidity('');
    var submit = form.querySelector('.auth-btn-primary');
    submit.disabled = true;
    submit.querySelector('span:first-child').textContent = 'Creating account…';
  }
});

document.getElementById('confirm_password').addEventListener('input', function() {
  this.setCustomValidity('');
});
</script>

</body>
</html>
