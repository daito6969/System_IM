<?php require '../includes/auth.php'; require_role(['staff', 'admin']);
$id = (int)$_POST['id']; $st = $_POST['status'] ?? '';
if (in_array($st, ['confirmed', 'cancelled'])) {
  $pdo->beginTransaction();
  $s = $pdo->prepare('SELECT * FROM flight_bookings WHERE id=? FOR UPDATE'); $s->execute([$id]); $b = $s->fetch();
  if ($b && $b['status'] !== $st) {
    $pdo->prepare('UPDATE flight_bookings SET status=? WHERE id=?')->execute([$st, $id]);
    $sign = $st === 'cancelled' ? '+' : '-';    // cancelling returns seats; re-confirming takes them again
    foreach (array_filter([$b['flight_id'], $b['return_flight_id']]) as $f)
      $pdo->prepare("UPDATE flights SET seats=seats $sign ? WHERE id=?")->execute([$b['pax'], $f]);
  }
  $pdo->commit();
}
