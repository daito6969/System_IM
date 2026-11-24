<?php 
require '../includes/auth.php'; 
require_role(['traveler', 'staff', 'admin']);

if (($_POST['action'] ?? '') === 'delete') {
  require_role(['admin']);
  $pdo->prepare('DELETE FROM bookings WHERE id=?')->execute([(int)$_POST['id']]);
  header('Location: ' . BASE . '/admin/dashboard.php');
  exit;
}

if (($_POST['action'] ?? '') === 'status') {          // staff/admin change a booking's status
  require_role(['staff', 'admin']);
  $status = $_POST['status'] ?? '';
  if (in_array($status, ['pending', 'confirmed', 'delayed', 'cancelled'])) {
    $pdo->prepare('UPDATE bookings SET status=? WHERE id=?')->execute([$status, (int)$_POST['id']]);
  }
  header('Location: ' . BASE . '/' . (user()['role'] === 'staff' ? 'staff/bookings.php' : 'admin/dashboard.php')); 
  exit;
}

require_role(['traveler', 'admin']);                   // travelers & admins create bookings
$destId = (int)($_POST['destination_id'] ?? 0);
$date = trim($_POST['travel_date'] ?? '');
$pax = max(1, (int)($_POST['pax'] ?? 1));
$d = $pdo->prepare('SELECT price FROM destinations WHERE id=?'); 
$d->execute([$destId]);
$price = $d->fetchColumn();

if ($price !== false && $date !== '') {
  $pdo->prepare('INSERT INTO bookings(user_id,destination_id,travel_date,pax,total) VALUES(?,?,?,?,?)')
    ->execute([user()['id'], $destId, $date, $pax, (float)$price * $pax]);
}

header('Location: ' . BASE . '/traveler/bookings.php');
