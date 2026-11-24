<?php 
require '../includes/auth.php'; 
require_role(['staff', 'admin']);

$id = (int)$_POST['id']; 
$st = $_POST['status'] ?? '';

if (in_array($st, ['confirmed', 'delayed', 'cancelled'])) {
  $pdo->beginTransaction();
  $s = $pdo->prepare('SELECT * FROM flight_bookings WHERE id=? FOR UPDATE'); 
  $s->execute([$id]); 
  $b = $s->fetch();
  if ($b && $b['status'] !== $st) {
    $oldSt = $b['status'];
    $pdo->prepare('UPDATE flight_bookings SET status=? WHERE id=?')->execute([$st, $id]);

    // Seat adjustment logic:
    // - If previously cancelled and now confirmed or delayed: re-reserve seats (- pax)
    // - If previously confirmed or delayed and now cancelled: return seats (+ pax)
    // - Moving between confirmed and delayed maintains seat reservation
    if ($oldSt === 'cancelled' && in_array($st, ['confirmed', 'delayed'])) {
      foreach (array_filter([$b['flight_id'], $b['return_flight_id']]) as $f) {
        $pdo->prepare("UPDATE flights SET seats=seats - ? WHERE id=?")->execute([$b['pax'], $f]);
      }
    } elseif (in_array($oldSt, ['confirmed', 'delayed']) && $st === 'cancelled') {
      foreach (array_filter([$b['flight_id'], $b['return_flight_id']]) as $f) {
        $pdo->prepare("UPDATE flights SET seats=seats + ? WHERE id=?")->execute([$b['pax'], $f]);
      }
    }
  }
  $pdo->commit();
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) || str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json')) {
  header('Content-Type: application/json');
  exit(json_encode(['ok' => true]));
}

$back = user()['role'] === 'admin' ? BASE . '/admin/reports.php' : BASE . '/staff/dashboard.php';
header('Location: ' . $back);
exit;
