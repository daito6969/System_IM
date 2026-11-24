<?php 
require '../includes/auth.php'; 
require_role(['traveler', 'staff', 'admin']);

if (($_POST['action'] ?? '') === 'delete') { 
  $pdo->prepare('DELETE FROM trips WHERE id=? AND (user_id=? OR ? IN ("admin","staff"))')
      ->execute([(int)$_POST['id'], user()['id'], user()['role']]); 
  
  $ref = $_SERVER['HTTP_REFERER'] ?? '';
  if (str_contains($ref, 'dashboard.php')) {
    header('Location: ' . BASE . '/' . (user()['role'] === 'staff' ? 'staff/dashboard.php' : 'traveler/dashboard.php'));
  } elseif (str_contains($ref, 'trips.php') && user()['role'] === 'staff') {
    header('Location: ' . BASE . '/staff/trips.php');
  } else {
    header('Location: ' . BASE . '/traveler/my_trips.php');
  }
  exit; 
}

$pdo->prepare('INSERT INTO trips(user_id,title,destination,budget,start_date,end_date) VALUES(?,?,?,?,?,?)')
    ->execute([user()['id'], trim($_POST['title']), trim($_POST['destination'] ?? ''), (float)($_POST['budget'] ?? 0), $_POST['start_date'] ?: null, $_POST['end_date'] ?: null]);

header('Location: ' . BASE . '/traveler/my_trips.php');
