<?php require '../includes/auth.php'; require_role(['admin']);
$id = (int)$_POST['id']; $role = $_POST['role'] ?? '';
if (($_POST['action'] ?? '') === 'reset') {      // admin sets a temporary password
  $tmp = substr(bin2hex(random_bytes(4)), 0, 8);
  $pdo->prepare('UPDATE users SET password_hash=? WHERE id=?')->execute([password_hash($tmp, PASSWORD_DEFAULT), $id]);
  header('Location: ' . BASE . '/admin/users.php?temp=' . $tmp); exit;
}
if ($id !== user()['id'] && in_array($role, ['admin', 'staff', 'traveler'])) $pdo->prepare('UPDATE users SET role=? WHERE id=?')->execute([$role, $id]);
header('Location: ' . BASE . '/admin/users.php');
