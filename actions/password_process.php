<?php
require '../includes/auth.php';
require_role(['admin', 'staff', 'traveler']);

$current = $_POST['current'] ?? '';
$new = $_POST['new'] ?? '';

if (strlen($new) < 6) {
  header('Location: ' . BASE . '/account.php?msg=' . urlencode('New password must be at least 6 characters.'));
  exit;
}

$stmt = $pdo->prepare('SELECT password_hash FROM users WHERE id=?');
$stmt->execute([user()['id']]);
$hash = $stmt->fetchColumn();

if (!$hash || !password_verify($current, $hash)) {
  header('Location: ' . BASE . '/account.php?msg=' . urlencode('Current password is incorrect.'));
  exit;
}

$pdo->prepare('UPDATE users SET password_hash=? WHERE id=?')
    ->execute([password_hash($new, PASSWORD_DEFAULT), user()['id']]);

header('Location: ' . BASE . '/account.php?ok=1');
