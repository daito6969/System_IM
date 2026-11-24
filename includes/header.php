<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>Wayfarer PH – Smart Travel & Flight Manager</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= BASE ?>/assets/css/style.css">
<script>
(function() {
  const saved = localStorage.getItem('wayfarer_theme');
  const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
  const theme = saved ? saved : (prefersDark ? 'dark' : 'light');
  document.documentElement.setAttribute('data-theme', theme);
})();
</script>
</head>
<body>
<nav class="wayfarer-nav">
  <div class="nav-left">
    <a href="<?= BASE ?>/<?= user() ? user()['role'] . '/dashboard.php' : '' ?>" class="nav-brand">
      <span class="brand-badge">PH</span>
      <span class="brand-name">WAYFARER</span>
    </a>
    <span class="nav-tagline">Trip & Experience Hub</span>
  </div>

  <div class="nav-center">
    <?php if (user()) { include __DIR__ . '/sidebar.php'; } ?>
  </div>

  <div class="nav-right">
    <button id="themeToggleBtn" type="button" class="theme-toggle-btn" aria-label="Toggle theme">
      <span class="theme-icon">🌓</span>
      <span class="theme-text">Theme</span>
    </button>
    <?php if (user()): ?>
      <a href="<?= BASE ?>/account.php" class="user-chip">
        <span class="avatar-dot"></span>
        <span><?= e(user()['name']) ?></span>
      </a>
      <a href="<?= BASE ?>/logout.php" class="nav-logout-btn">Log out</a>
    <?php endif; ?>
  </div>
</nav>
<main class="page-main-wrap">
