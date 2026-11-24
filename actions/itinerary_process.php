<?php 
require '../includes/auth.php'; 
require_role(['traveler', 'staff', 'admin']);

if (($_POST['action'] ?? '') === 'delete') { 
  $pdo->prepare('DELETE i FROM itineraries i JOIN trips t ON t.id=i.trip_id WHERE i.id=? AND (t.user_id=? OR ? IN ("admin","staff"))')
      ->execute([(int)$_POST['id'], user()['id'], user()['role']]); 
  $tid = (int)($_POST['trip_id'] ?? 0);
  $ref = $_SERVER['HTTP_REFERER'] ?? '';
  if (str_contains($ref, 'my_trips.php')) {
    header('Location: ' . BASE . '/traveler/my_trips.php');
  } elseif (str_contains($ref, 'itineraries.php') && user()['role'] === 'staff') {
    header('Location: ' . BASE . '/staff/itineraries.php');
  } else {
    header('Location: ' . BASE . '/traveler/itinerary.php' . ($tid ? '?trip=' . $tid : ''));
  }
  exit; 
}

$tid = (int)($_POST['trip_id'] ?? 0);
$act = trim($_POST['activity'] ?? '');
$day = max(1, (int)($_POST['day_no'] ?? 1));

$own = $pdo->prepare('SELECT id FROM trips WHERE id=? AND (user_id=? OR ? IN ("admin","staff"))'); 
$own->execute([$tid, user()['id'], user()['role']]);

if ($own->fetch() && $act !== '') {
  $pdo->prepare('INSERT INTO itineraries(trip_id,day_no,activity) VALUES(?,?,?)')->execute([$tid, $day, $act]);
}

$ref = $_SERVER['HTTP_REFERER'] ?? '';
if (str_contains($ref, 'my_trips.php')) {
  header('Location: ' . BASE . '/traveler/my_trips.php');
} else {
  header('Location: ' . BASE . '/traveler/itinerary.php?trip=' . $tid);
}
