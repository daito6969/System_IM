<?php 
require '../includes/auth.php'; 
require_role(['traveler', 'admin']);

if (($_POST['action'] ?? '') === 'delete') { 
  $pdo->prepare('DELETE e FROM expenses e JOIN trips t ON t.id=e.trip_id WHERE e.id=? AND (t.user_id=? OR ?="admin")')
      ->execute([(int)$_POST['id'], user()['id'], user()['role']]); 
  $tid = (int)($_POST['trip_id'] ?? 0);
  header('Location: ' . BASE . '/traveler/expenses.php' . ($tid ? '?trip=' . $tid : ''));
  exit; 
}

$tid = (int)($_POST['trip_id'] ?? 0);
$cat = trim($_POST['category'] ?? '');
$amount = (float)($_POST['amount'] ?? 0);
$note = trim($_POST['note'] ?? '');

$own = $pdo->prepare('SELECT id FROM trips WHERE id=? AND (user_id=? OR ?="admin")'); 
$own->execute([$tid, user()['id'], user()['role']]);

if ($own->fetch() && $cat !== '' && $amount > 0) {
  $pdo->prepare('INSERT INTO expenses(trip_id,category,amount,note) VALUES(?,?,?,?)')->execute([$tid, $cat, $amount, $note]);
}
header('Location: ' . BASE . '/traveler/expenses.php?trip=' . $tid);
