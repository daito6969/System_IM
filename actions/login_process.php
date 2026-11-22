<?php
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ' . BASE . '/login.php');
  exit;
}

$email = strtolower(trim($_POST['email'] ?? ''));
$password = $_POST['password'] ?? '';
$s = $pdo->prepare('SELECT * FROM users WHERE LOWER(email) = ?');
$s->execute([$email]);
$u = $s->fetch();
if ($u && password_verify($password, $u['password_hash'])) {
  session_regenerate_id(true);
  $_SESSION['user'] = ['id' => $u['id'], 'name' => $u['name'], 'role' => $u['role']];
  header('Location: ' . home_for($u['role']));
  exit;
}

header('Location: ' . BASE . '/login.php?error=1&email=' . urlencode($email));
exit;
