<?php
require '../includes/auth.php';
require_role(['staff', 'admin']);

$id = (int)($_POST['id'] ?? 0);
$status = $_POST['status'] ?? '';

if (($_POST['action'] ?? '') === 'status' && in_array($status, ['confirmed', 'delayed', 'cancelled'])) {
  $pdo->beginTransaction();
  $s = $pdo->prepare('SELECT * FROM flight_bookings WHERE id=? FOR UPDATE');
  $s->execute([$id]);
  if ($b = $s->fetch()) {
    $wasActive = in_array($b['status'], ['confirmed', 'delayed']);
    $nowCancelled = ($status === 'cancelled');
    $pdo->prepare('UPDATE flight_bookings SET status=? WHERE id=?')->execute([$status, $id]);

    // Restore seats if cancelled from an active state
    if ($wasActive && $nowCancelled) {
      foreach (array_filter([$b['flight_id'], $b['return_flight_id']]) as $fid) {
        $pdo->prepare('UPDATE flights SET seats=seats+? WHERE id=?')->execute([$b['pax'], $fid]);
      }
    } elseif (!$wasActive && !$nowCancelled) {
      // Re-deduct seats if restored from cancelled
      foreach (array_filter([$b['flight_id'], $b['return_flight_id']]) as $fid) {
        $pdo->prepare('UPDATE flights SET seats=GREATEST(0, seats-?) WHERE id=?')->execute([$b['pax'], $fid]);
      }
    }
  }
  $pdo->commit();
}

header('Location: ' . BASE . '/' . (user()['role'] === 'staff' ? 'staff/dashboard.php' : 'admin/reports.php'));
