<?php require '../includes/auth.php'; require_role(['traveler', 'staff', 'admin']);
if (($_POST['action'] ?? '') === 'status') {          // staff/admin change a booking's status
  require_role(['staff', 'admin']);
  $pdo->prepare('UPDATE bookings SET status=? WHERE id=?')->execute([$_POST['status'], (int)$_POST['id']]);
  header('Location: ' . BASE . '/admin/dashboard.php'); exit;
}
require_role(['traveler']);                           // travelers create bookings
$d = $pdo->prepare('SELECT price FROM destinations WHERE id=?'); $d->execute([(int)$_POST['destination_id']]);
$price = $d->fetchColumn(); $pax = max(1, (int)$_POST['pax']);
if ($price !== false) $pdo->prepare('INSERT INTO bookings(user_id,destination_id,travel_date,pax,total) VALUES(?,?,?,?,?)')
  ->execute([user()['id'], (int)$_POST['destination_id'], $_POST['travel_date'], $pax, $price * $pax]);
header('Location: ' . BASE . '/traveler/bookings.php');
