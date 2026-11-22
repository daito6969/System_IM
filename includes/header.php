<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Wayfarer PH – Smart Travel & Flight Manager</title>
<link rel="stylesheet" href="<?= BASE ?>/assets/css/style.css">
</head>
<body>
<nav>
  <b>ROADTRIP</b>
  <?php if (user()) { include __DIR__ . '/sidebar.php'; ?>
    <span>
      <?= e(user()['name']) ?> (<?= e(user()['role']) ?>)
      <a href="<?= BASE ?>/account.php">Account</a>
      <a href="<?= BASE ?>/logout.php">Log out</a>
    </span>
  <?php } ?>
</nav>
<main>
