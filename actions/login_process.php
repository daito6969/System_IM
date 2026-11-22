<?php require '../includes/auth.php';
$s = $pdo->prepare('SELECT * FROM users WHERE email = ?');
$s->execute([trim($_POST['email'] ?? '')]);
$u = $s->fetch();
if ($u && password_verify($_POST['password'] ?? '', $u['password_hash'])) {
  session_regenerate_id(true);
  $_SESSION['user'] = ['id' => $u['id'], 'name' => $u['name'], 'role' => $u['role']];
  header('Location: ' . home_for($u['role']));
} else header('Location: ' . BASE . '/login.php?error=1');
