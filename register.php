<?php 
require_once __DIR__ . '/includes/auth.php'; 
if (user()) {
  header('Location: ' . home_for(user()['role']));
  exit;
}
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
<link rel="stylesheet" href="<?= BASE ?>/assets/css/style.css">
</head>
<body class="auth-body">

<div class="auth-ambient-bg"></div>

<div class="auth-wrapper">
  <div class="auth-panel">
    <!-- Brand / Header -->
    <div class="auth-brand-area">
      <a href="<?= BASE ?>/" class="auth-brand-logo">
        <span class="auth-logo-badge">PH</span>
        <span class="auth-logo-text">WAYFARER</span>
      </a>
      <h1>Start Your Adventure</h1>
      <p>Create your traveler account to plan custom Philippine itineraries, track budgets & book flights.</p>
    </div>

    <?php if (!empty($_GET['error'])): ?>
      <div class="auth-alert">
        <span class="alert-icon">⚠️</span>
        <span><?= e($_GET['error']) ?></span>
      </div>
    <?php endif; ?>

    <form method="post" action="<?= BASE ?>/actions/register_process.php" class="auth-form-aesthetic">
      <!-- Name Fields: First Name + MI -->
      <div class="form-row-2-1">
        <div class="input-group">
          <label for="first_name">
            <span>First Name <span class="req">*</span></span>
          </label>
          <div class="input-inner">
            <span class="input-icon">👤</span>
            <input type="text" id="first_name" name="first_name" placeholder="e.g. Juan" required autofocus>
          </div>
        </div>

        <div class="input-group">
          <label for="middle_initial">
            <span>M.I.</span>
          </label>
          <div class="input-inner">
            <input type="text" id="middle_initial" name="middle_initial" placeholder="D." maxlength="4" style="text-align:center;">
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
            <input type="text" id="last_name" name="last_name" placeholder="e.g. Dela Cruz" required>
          </div>
        </div>

        <div class="input-group">
          <label for="suffix">
            <span>Suffix <span class="opt">(Optional)</span></span>
          </label>
          <div class="input-inner">
            <input type="text" id="suffix" name="suffix" placeholder="Jr., III" maxlength="10">
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
          <input type="email" id="email" name="email" placeholder="name@example.com" required>
        </div>
      </div>

      <!-- Password -->
      <div class="input-group">
        <label for="password">
          <span>Password <span class="req">*</span> <small>(at least 6 characters)</small></span>
        </label>
        <div class="input-inner">
          <span class="input-icon">🔒</span>
          <input type="password" id="password" name="password" minlength="6" placeholder="••••••••" required>
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

</body>
</html>
