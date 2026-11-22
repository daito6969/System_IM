<?php require '../includes/auth.php'; require_role(['admin', 'staff', 'traveler']);
$s = $pdo->prepare('SELECT password_hash FROM users WHERE id=?'); $s->execute([user()['id']]);
$ok = password_verify($_POST['current'] ?? '', (string)$s->fetchColumn()) && strlen($_POST['new'] ?? '') >= 6;
if ($ok) $pdo->prepare('UPDATE users SET password_hash=? WHERE id=?')->execute([password_hash($_POST['new'], PASSWORD_DEFAULT), user()['id']]);
header('Location: ' . BASE . '/account.php?msg=' . urlencode($ok ? 'Password changed.' : 'Wrong current password, or the new one is too short.'));
