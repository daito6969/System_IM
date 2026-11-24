<?php 
require '../includes/auth.php'; 
require_role(['admin']);

$id = (int)($_POST['id'] ?? 0); 
$role = $_POST['role'] ?? '';

if (($_POST['action'] ?? '') === 'delete') {
  if ($id !== (int)user()['id']) {
    try {
      $pdo->prepare('DELETE FROM users WHERE id=?')->execute([$id]);
    } catch (PDOException $e) {}
  }
  header('Location: ' . BASE . '/admin/users.php');
  exit;
}

if (($_POST['action'] ?? '') === 'reset') {      // admin sets a temporary password
  $tmp = substr(bin2hex(random_bytes(4)), 0, 8);
  $pdo->prepare('UPDATE users SET password_hash=? WHERE id=?')->execute([password_hash($tmp, PASSWORD_DEFAULT), $id]);
  header('Location: ' . BASE . '/admin/users.php?temp=' . $tmp); 
  exit;
}

if ($id !== (int)user()['id'] && in_array($role, ['admin', 'staff', 'traveler'])) {
  $pdo->prepare('UPDATE users SET role=? WHERE id=?')->execute([$role, $id]);
}

header('Location: ' . BASE . '/admin/users.php');
