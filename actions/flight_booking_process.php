<?php require '../includes/auth.php'; header('Content-Type: application/json');
if (!user() || user()['role'] !== 'traveler') { http_response_code(403); exit('{"ok":false,"error":"Log in as a traveler"}'); }
$in = json_decode(file_get_contents('php://input'), true) ?: [];
if (!empty($in['cancel'])) {                                   // cancel and give the seats back
  $pdo->beginTransaction();
  $s = $pdo->prepare("SELECT * FROM flight_bookings WHERE id=? AND user_id=? AND status='confirmed'"); $s->execute([(int)$in['cancel'], user()['id']]);
  if ($b = $s->fetch()) {
    $pdo->prepare("UPDATE flight_bookings SET status='cancelled' WHERE id=?")->execute([$b['id']]);
    foreach (array_filter([$b['flight_id'], $b['return_flight_id']]) as $fid) $pdo->prepare('UPDATE flights SET seats=seats+? WHERE id=?')->execute([$b['pax'], $fid]);
  }
  $pdo->commit(); exit('{"ok":true}');
}
$legs = array_map('intval', $in['legs'] ?? []); $pax = max(1, min(9, (int)($in['pax'] ?? 1)));
if (!$legs || count($legs) > 2) exit('{"ok":false,"error":"No flight selected"}');
$pdo->beginTransaction(); $total = 0;
foreach ($legs as $id) {
  $s = $pdo->prepare('SELECT price,seats FROM flights WHERE id=? FOR UPDATE'); $s->execute([$id]); $f = $s->fetch();
  if (!$f || $f['seats'] < $pax) { $pdo->rollBack(); exit('{"ok":false,"error":"Not enough seats left"}'); }
  $total += $f['price'] * $pax;
}
$ref = 'PH-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));
$pdo->prepare('INSERT INTO flight_bookings(ref,user_id,flight_id,return_flight_id,pax,total) VALUES(?,?,?,?,?,?)')->execute([$ref, user()['id'], $legs[0], $legs[1] ?? null, $pax, $total]);
foreach ($legs as $id) $pdo->prepare('UPDATE flights SET seats=seats-? WHERE id=?')->execute([$pax, $id]);
$pdo->commit(); echo json_encode(['ok' => true, 'ref' => $ref]);
